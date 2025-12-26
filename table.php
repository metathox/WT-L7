<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="uk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Таблиця даних з API</title>
        <link rel="stylesheet" href="styles.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>
        <nav>
            <a href="index.php">Жарти</a>
            <a href="table.php" class="link-active">Таблиця</a>
        </nav>

        <div class="container">
            <h1>Реєстр героїв</h1>
            
            <div class="controls">
                <button id="update-data">Оновити</button>
                <input type="text" id="filter-name" placeholder="Пошук за іменем">

                <div class="affil-sect">
                    <label for="filter-aff">Фракція:</label>
                    <select id="filter-aff">
                        <option value="all">Усі</option>
                        <option value="empire">Імперія</option>
                        <option value="alliance">Альянс</option>
                    </select>
                </div>
            </div>

            <table id="data-table">
                <thead>
                    <tr>
                        <th>Ім'я</th>
                        <th>Фракція</th>
                        <th>Ранг</th>
                        <th>Локація</th> </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <script>
            let cachedData = [];

            const displayData = data => {
                const tbody = $('#data-table tbody').empty();
                $.each(data, (i, item) => {
                    tbody.append(`
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.affiliation}</td>
                            <td>${item.rank}</td>
                            <td>${item.location}</td>
                        </tr>
                    `);
                });
            };

            // Завантаження даних з API через proxy.php
            const loadFromAPI = () => {
                $.getJSON('proxy.php', data => {
                    cachedData = data;
                    $('#filter-aff').val('all');
                    displayData(cachedData);
                }).fail(() => alert("Помилка API."));
            };

            $(document).ready(() => {
                loadFromAPI();

                $('#update-data').click(loadFromAPI);

                // Фільтрація за фракцією
                const applyFilters = () => {
                    const searchTerm = $('#filter-name').val().toLowerCase();
                    const selectedAff = $('#filter-aff').val();

                    const filtered = cachedData.filter(item => {
                        const matchesName = item.name.toLowerCase().includes(searchTerm);
                        const matchesAff = (selectedAff === 'all') || (item.affiliation.toLowerCase() === selectedAff);
                        return matchesName && matchesAff; // Рядок залишиться, тільки якщо обидві умови TRUE
                    });

                    displayData(filtered);
                };

                $(document).ready(() => {
                    $('#filter-name').on('input', applyFilters);
                    $('#filter-aff').change(applyFilters);
                    
                    $('#data-table th:first-child').css('cursor', 'pointer').click(() => {
                        cachedData.sort((a, b) => a.name.localeCompare(b.name));
                        applyFilters();
                    });
                });
            });
        </script>

    </body>
</html>
