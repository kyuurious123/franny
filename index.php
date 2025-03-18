<?php
// 현재 요청된 URI를 가져옵니다
$request_uri = $_SERVER['REQUEST_URI'];

// API나 실제 파일에 대한 요청인지 확인
if (strpos($request_uri, '/api/') === 0 || strpos($request_uri, '/writings/') === 0) {
    // 실제 파일 경로 확인
    $file_path = $_SERVER['DOCUMENT_ROOT'] . $request_uri;
    
    // 파일이 존재하는 경우 파일 제공
    if (file_exists($file_path)) {
        // 마크다운 파일인 경우 텍스트로 제공
        if (pathinfo($file_path, PATHINFO_EXTENSION) === 'md') {
            header('Content-Type: text/plain');
            readfile($file_path);
            exit();
        }
        // 그 외 파일은 그대로 제공
        return false;
    }
}

// 그 외 모든 요청은 Vue 앱의 index.html로 리다이렉션
include($_SERVER['DOCUMENT_ROOT'] . '/index.html');
exit();
?>