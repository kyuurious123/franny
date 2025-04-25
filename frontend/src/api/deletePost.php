
// api/deletePost.php
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

if (!isset($postData['id'])) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => '게시글 ID가 필요합니다.']);
  exit;
}

$postId = intval($postData['id']);
$postsFile = __DIR__ . '/../data/posts.json';

if (!file_exists($postsFile)) {
  http_response_code(404);
  echo json_encode(['success' => false, 'message' => '게시글을 찾을 수 없습니다.']);
  exit;
}

$postsJson = file_get_contents($postsFile);
$posts = json_decode($postsJson, true);

// 게시글 찾아서 삭제
$found = false;
$newPosts = [];
foreach ($posts as $post) {
  if ($post['id'] !== $postId) {
    $newPosts[] = $post;
  } else {
    $found = true;
  }
}

if (!$found) {
  http_response_code(404);
  echo json_encode(['success' => false, 'message' => '삭제할 게시글을 찾을 수 없습니다.']);
  exit;
}

// 파일에 저장
if (file_put_contents($postsFile, json_encode($newPosts, JSON_PRETTY_PRINT))) {
  echo json_encode(['success' => true]);
} else {
  http_response_code(500);
  echo json_encode(['success' => false, 'message' => '게시글 삭제에 실패했습니다.']);
}
?>