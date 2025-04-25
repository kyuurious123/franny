
<?php
header('Content-Type: application/json');

// POST 요청이 아니면 거부
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'message' => '허용되지 않은 메소드입니다.']);
  exit;
}

// 관리자 인증 확인
$headers = getallheaders();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if (!preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
  http_response_code(401);
  echo json_encode(['success' => false, 'message' => '인증 정보가 필요합니다.']);
  exit;
}

$token = $matches[1];
$configFile = __DIR__ . '/../data/config.json';

if (!file_exists($configFile)) {
  http_response_code(500);
  echo json_encode(['success' => false, 'message' => '설정 파일을 찾을 수 없습니다.']);
  exit;
}

$configJson = file_get_contents($configFile);
$config = json_decode($configJson, true);

// 토큰 검증
if (!isset($config['adminToken']) || $config['adminToken'] !== $token) {
  http_response_code(403);
  echo json_encode(['success' => false, 'message' => '권한이 없습니다.']);
  exit;
}

// 요청 본문 읽기
$requestBody = file_get_contents('php://input');
$postData = json_decode($requestBody, true);

if (!isset($postData['title']) || !isset($postData['content'])) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => '제목과 내용이 필요합니다.']);
  exit;
}

$postsFile = __DIR__ . '/../data/posts.json';
$posts = [];

if (file_exists($postsFile)) {
  $postsJson = file_get_contents($postsFile);
  $posts = json_decode($postsJson, true);
}

// 새 ID 생성 (배열이 비어있거나 기존 ID 중 최대값 + 1)
$newId = 1;
if (!empty($posts)) {
  $ids = array_column($posts, 'id');
  $newId = max($ids) + 1;
}

// 새 게시글 데이터
$newPost = [
  'id' => $newId,
  'title' => $postData['title'],
  'content' => $postData['content'],
  'date' => isset($postData['date']) ? $postData['date'] : date('c'),
  'views' => 0
];

$posts[] = $newPost;

// 파일에 저장
if (file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT))) {
  echo json_encode(['success' => true, 'postId' => $newId]);
} else {
  http_response_code(500);
  echo json_encode(['success' => false, 'message' => '게시글 저장에 실패했습니다.']);
}
?>