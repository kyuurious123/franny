<?php
// 현재 요청된 URI를 가져옵니다
$request_uri = $_SERVER['REQUEST_URI'];

// JavaScript 파일 처리 - 더 포괄적인 패턴 매칭
if (preg_match('/\.(js|mjs)(\?.*)?$/', $request_uri)) {
    $file_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($request_uri, PHP_URL_PATH);
    if (file_exists($file_path)) {
        header('Content-Type: application/javascript');
        header('Cache-Control: public, max-age=31536000');
        readfile($file_path);
        exit();
    }
}

// HTTPS 강제 적용
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}

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