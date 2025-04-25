
// api/getPost.php
<?php
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
  echo json_encode(['success' => false, 'message' => 'ID가 제공되지 않았습니다.']);
  exit;
}

$postId = intval($_GET['id']);
$postsFile = __DIR__ . '/../data/posts.json';

if (!file_exists($postsFile)) {
  echo json_encode(['success' => false, 'message' => '게시글을 찾을 수 없습니다.']);
  exit;
}

$postsJson = file_get_contents($postsFile);
$posts = json_decode($postsJson, true);

// ID로 게시글 찾기
$foundPost = null;
foreach ($posts as $index => $post) {
  if ($post['id'] === $postId) {
    // 조회수 증가
    $posts[$index]['views'] = isset($post['views']) ? $post['views'] + 1 : 1;
    $foundPost = $posts[$index];
    break;
  }
}

if ($foundPost) {
  // 업데이트된 게시글 정보 저장
  file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT));
  echo json_encode(['success' => true, 'post' => $foundPost]);
} else {
  echo json_encode(['success' => false, 'message' => '게시글을 찾을 수 없습니다.']);
}
?>