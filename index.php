<?php
// 현재 요청된 URI를 가져옵니다
$request_uri = $_SERVER['REQUEST_URI'];

// 요청된 파일 경로가 실제로 존재하지 않으면 index.html로 리디렉션
$file_path = $_SERVER['DOCUMENT_ROOT'] . $request_uri;

if (!file_exists($file_path)) {
    include('index.html');  // Vue 앱의 index.html 파일을 서빙
    exit();
}
?>
