
// api/checkPassword.php
<?php
header('Content-Type: application/json');

// POST 요청이 아니면 거부
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'message' => '허용되지 않은 메소드입니다.']);
  exit;
}

// 요청 본문 읽기
$requestBody = file_get_contents('php://input');
$postData = json_decode($requestBody, true);

if (!isset($postData['password'])) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => '비밀번호가 필요합니다.']);
  exit;
}

$configFile = __DIR__ . '/../data/config.json';

// 설정 파일이 없으면 생성 (초기 설정)
if (!file_exists($configFile)) {
  // 기본 비밀번호: admin1234 (실제 운영 시 반드시 변경 필요)
  $defaultPassword = 'admin1234';
  $adminToken = bin2hex(random_bytes(32)); // 임의의 토큰 생성
  
  $config = [
    'adminPassword' => password_hash($defaultPassword, PASSWORD_DEFAULT),
    'adminToken' => $adminToken
  ];
  
  if (!file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT))) {
    http_response_code(500); 
    echo json_encode(['success' => false, 'message' => '설정 파일 생성에 실패했습니다.']);
    exit;
  }
} else {
  $configJson = file_get_contents($configFile);
  $config = json_decode($configJson, true);
}

// 비밀번호 검증
if (password_verify($postData['password'], $config['adminPassword'])) {
  echo json_encode(['success' => true, 'token' => $config['adminToken']]);
} else {
  echo json_encode(['success' => false, 'message' => '비밀번호가 올바르지 않습니다.']);
}
?>
