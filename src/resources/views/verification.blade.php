<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>请进行安全验证</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; background-color: #f4f6f9; color: #4b5563; text-align: center; }
        .container { max-width: 400px; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .icon { font-size: 48px; color: #3498db; margin-bottom: 20px; }
        h1 { margin-top: 0; color: #333; }
        p { margin-bottom: 25px; }
        .verify-button {
            display: inline-block;
            background-color: #3498db;
            color: #ffffff;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            text-decoration: none;
        }
        .verify-button:hover { background-color: #2980b9; }
        .verify-button:active { transform: scale(0.98); }
        .verify-button:disabled { background-color: #a0a0a0; cursor: not-allowed; }
        .loader { border: 4px solid #f3f3f3; border-radius: 50%; border-top: 4px solid #3498db; width: 24px; height: 24px; animation: spin 2s linear infinite; margin: 0 auto; display: none; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon"></div> <!-- Shield Icon -->
        <h1>安全验证</h1>
        <p>为了保护您的账户安全，请点击下方的按钮以继续访问。</p>
        
        <button id="verifyBtn" class="verify-button">我不是机器人，继续访问</button>
        
        <div id="loader" class="loader"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const verifyButton = document.getElementById('verifyBtn');
            const loader = document.getElementById('loader');

            verifyButton.addEventListener('click', function() {
                // 禁用按钮并显示加载动画，防止重复点击
                verifyButton.disabled = true;
                verifyButton.style.display = 'none'; // 隐藏按钮
                loader.style.display = 'block';     // 显示加载动画

                // 发送验证请求
                fetch('/anti-replay/verify', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        // 验证成功后，重新加载当前页面
                        window.location.reload();
                    } else {
                        throw new Error('Verification failed.');
                    }
                })
                .catch(error => {
                    console.error('Verification Error:', error);
                    // 如果出错，恢复界面让用户可以重试
                    document.querySelector('.container').innerHTML = '<h1>验证失败，请刷新页面重试。</h1>';
                });
            });
        });
    </script>
</body>
</html>