<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>경로 테스트</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>경로 테스트</h1>
    
    <h2>서버 정보</h2>
    <pre>
Document Root: <?= $_SERVER['DOCUMENT_ROOT'] ?>
HTTP Host: <?= $_SERVER['HTTP_HOST'] ?>
Request URI: <?= $_SERVER['REQUEST_URI'] ?>
    </pre>
    
    <h2>마크다운 파일 체크</h2>
    <?php
    $paths_to_check = [
        '/writings/01.md',
        '/writings/02.md',
        '/data/writings.json'
    ];
    
    foreach ($paths_to_check as $path) {
        $full_path = $_SERVER['DOCUMENT_ROOT'] . $path;
        echo '<h3>' . htmlspecialchars($path) . '</h3>';
        
        if (file_exists($full_path)) {
            echo '<p class="success">파일이 존재합니다!</p>';
            echo '<p>파일 크기: ' . filesize($full_path) . ' bytes</p>';
            echo '<p>마지막 수정: ' . date("Y-m-d H:i:s", filemtime($full_path)) . '</p>';
            
            // 파일 내용 출력 (처음 200자)
            $content = file_get_contents($full_path);
            echo '<h4>파일 내용 미리보기:</h4>';
            echo '<pre>' . htmlspecialchars(substr($content, 0, 200)) . '...</pre>';
        } else {
            echo '<p class="error">파일이 존재하지 않습니다.</p>';
            
            // 상위 디렉토리 검사
            $dir = dirname($full_path);
            if (is_dir($dir)) {
                echo '<p>디렉토리 ' . htmlspecialchars($dir) . '는 존재합니다.</p>';
                
                // 디렉토리 내용 출력
                echo '<h4>디렉토리 내용:</h4>';
                echo '<ul>';
                foreach (scandir($dir) as $file) {
                    if ($file != '.' && $file != '..') {
                        echo '<li>' . htmlspecialchars($file) . '</li>';
                    }
                }
                echo '</ul>';
            } else {
                echo '<p class="error">디렉토리 ' . htmlspecialchars($dir) . '도 존재하지 않습니다.</p>';
            }
        }
    }
    ?>
    
    <h2>API 테스트</h2>
    <div id="apiTest">
        <button onclick="testAPI()">마크다운 파일 로드 테스트</button>
        <div id="apiResult"></div>
    </div>
    
    <script>
    async function testAPI() {
        const resultDiv = document.getElementById('apiResult');
        resultDiv.innerHTML = '<p>테스트 중...</p>';
        
        const paths = [
            '/writings/01.md',
            '/writings/02.md',
            window.location.origin + '/writings/01.md',
            window.location.origin + '/writings/02.md'
        ];
        
        let results = '<h3>결과:</h3><ul>';
        
        for (const path of paths) {
            try {
                const startTime = performance.now();
                const response = await fetch(path);
                const endTime = performance.now();
                const timeMs = (endTime - startTime).toFixed(2);
                
                if (response.ok) {
                    const text = await response.text();
                    results += `<li style="color:green">성공! ${path} (${timeMs}ms)<br>
                               <small>응답 상태: ${response.status} ${response.statusText}</small><br>
                               <small>내용 미리보기: ${text.substring(0, 100).replace(/</g, '&lt;').replace(/>/g, '&gt;')}...</small></li>`;
                } else {
                    results += `<li style="color:red">실패: ${path} (${timeMs}ms)<br>
                               <small>응답 상태: ${response.status} ${response.statusText}</small></li>`;
                }
            } catch (error) {
                results += `<li style="color:red">오류: ${path}<br>
                           <small>${error.message}</small></li>`;
            }
        }
        
        results += '</ul>';
        resultDiv.innerHTML = results;
    }
    </script>
</body>
</html>