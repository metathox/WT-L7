<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="uk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Жартівник</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <nav>
            <a href="index.php" class="link-active">Жарти</a>
            <a href="table.php">Таблиця</a>
        </nav>

        <div class="box-wrapper">
            <div class="box">
                <h1>Випадковий жарт</h1>
                <div id="joke-area">Натисніть кнопку...</div>
                <button onclick="loadJoke()" id="btn-joke">Отримати жарт</button>
            </div>
        </div>

        <script>

            function loadJoke() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'jokes.txt?t=' + new Date().getTime(), true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var lines = xhr.responseText.split('\n').filter(el => el.trim() !== "");
                        var randomJoke = lines[Math.floor(Math.random() * lines.length)];
                        document.getElementById('joke-area').innerText = randomJoke;
                    }
                };
                xhr.send();
            }

        </script>

    </body>
</html>
