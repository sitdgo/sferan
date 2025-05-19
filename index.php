<?php
// /var/www/u2911633/data/www/new.sitdgo.pro/index.php
session_start();

// Подключение необходимых файлов
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Определение страницы
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$file = 'pages/' . $page . '.php';

// Обработка формы "Оформите заявку" (временная реализация)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['page']) && $_GET['page'] === 'submit_request') {
    $phone = sanitize($_POST['phone'] ?? '');
    $agreement = isset($_POST['agreement']) ? 'Да' : 'Нет';

    // Здесь можно добавить отправку email или запись в базу данных
    // Временный вывод для тестирования
    echo "<section class='section'><div class='container'><h2>Заявка отправлена</h2><p>Телефон: $phone<br>Согласие: $agreement<br>Наши специалисты свяжутся с вами в течение 15 минут.</p></div></section>";
    exit;
}

// Загрузка данных для главной страницы
$objects = [];
try {
    if (isset($db)) {
        $result = $db->query("SELECT * FROM objects WHERE status = 'available' LIMIT 6");
        if ($result) {
            $objects = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            error_log("Ошибка запроса к базе данных: " . $db->error);
        }
    } else {
        error_log("Переменная $db не определена. Проверьте includes/db.php.");
    }
} catch (Exception $e) {
    error_log("Исключение при запросе к базе данных: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="СФЕРА Н — агентство недвижимости в Дальнегорске. Продажа, покупка, обмен, аренда, срочный выкуп, приватизация, помощь с ипотекой и наследством.">
    <meta name="keywords" content="агентство недвижимости, Дальнегорск, продажа квартир, обмен, ипотека, срочный выкуп">
    <title>СФЕРА Н - Агентство недвижимости в Дальнегорске</title>
    <link rel="stylesheet" href="/assets/css/main.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Подключение AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
    <!-- Шапка -->
    <header class="header" data-aos="fade-down" data-aos-duration="1000">
        <div class="container">
            <div class="header-inner">
                <div class="logo">
    <a href="/">
        <img src="/assets/images/logo.png" alt="Логотип СФЕРА Н" class="logo-img">
        <span class="logo-text">СФЕРА Н</span>
    </a>
</div>
                <div class="header-contacts">
    <p><i class="fas fa-phone"></i> <a href="tel:+74951234567">+7 (495) 123-45-67</a></p>
    <p><i class="fas fa-envelope"></i> <a href="mailto:info@sfieran.ru">info@sfieran.ru</a></p>
</div>
                <nav class="nav">
                    <ul class="nav-list">
                        <li class="nav-item"><a href="/index.php" class="nav-link">Главная</a></li>
                        <li class="nav-item"><a href="/index.php?page=catalog" class="nav-link">Каталог</a></li>
                        <li class="nav-item"><a href="/index.php?page=contacts" class="nav-link">Контакты</a></li>
                        <li class="nav-item"><a href="/admin/" class="nav-link">Админ-панель</a></li>
                    </ul>
                    <div class="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Контент -->
    <main>
        <?php
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo '<section class="section"><div class="container"><h2>404 - Страница не найдена</h2><p>К сожалению, запрошенная страница не существует. Вернитесь на <a href="/index.php">главную страницу</a>.</p></div></section>';
        }
        ?>
    </main>

    <!-- Подвал -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- О нас -->
                <div class="footer-section">
                    <h3>О нас</h3>
                    <p>Вход в наш офис в правой части здания, 1 этаж, справа у двери размещена табличка с нашим названием и графиком работы.</p>
                    <p class="highlight">РАДЫ ВАС ВИДЕТЬ!</p>
                    <h4>График работы:</h4>
                    <p>пн-пт с 10:00 до 17:00, перерыв с 13:00 до 14:00</p>
                    <p>сб-вс: ВЫХОДНОЙ</p>
                </div>

                <!-- Контакты -->
                <div class="footer-section">
    <h3>Контакты</h3>
    <p>Приморский край, г. Дальнегорск, пр-кт 50 лет Октября, д. 68</p>
    <p><i class="fas fa-phone"></i> <a href="tel:+79241370101">+7 (924) 137-01-01</a></p>
    <p><i class="fas fa-phone"></i> <a href="tel:+79249419817">+7 (924) 941-98-17</a></p>
    <p><i class="fas fa-phone"></i> <a href="tel:+79241229595">+7 (924) 122-95-95</a></p>
    <p><i class="fas fa-envelope"></i> <a href="mailto:sphere_n2023@mail.ru">sphere_n2023@mail.ru</a></p>
</div>

                <!-- Свяжитесь с нами -->
                <div class="footer-section footer-form-section">
    <h3>Свяжитесь с нами</h3>
    <form action="/pages/contact.php" method="POST" class="footer-form">
        <div class="form-group">
            <label for="footer-name">Имя:</label>
            <input type="text" id="footer-name" name="name" placeholder="Ваше имя" required>
        </div>
        <div class="form-group">
            <label for="footer-phone">Телефон:</label>
            <input type="tel" id="footer-phone" name="phone" placeholder="Ваш телефон" required>
        </div>
        <div class="form-group">
            <label for="footer-message">Сообщение:</label>
            <textarea id="footer-message" name="message" placeholder="Ваше сообщение" required></textarea>
        </div>
        <button type="submit" class="footer-btn">Отправить</button>
    </form>
</div>
            </div>

            <!-- Копирайт -->
            <div class="footer-copyright">
                <p>Copyright © 2024 - 2025 ИП Мингалимова Надежда Александровна</p>
                <p>CMS сайта разработана <a href="http://sitdgo.pro/" target="_blank">sitdgo.pro</a></p>
            </div>
        </div>
    </footer>

    <!-- JavaScript для слайдера и мобильного меню -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Слайдер
        const slider = document.querySelector('.objects-slider');
        if (slider) {
            let scrollAmount = 0;
            const scrollStep = 270;
            setInterval(() => {
                scrollAmount += scrollStep;
                if (scrollAmount >= slider.scrollWidth - slider.clientWidth) {
                    scrollAmount = 0;
                }
                slider.scrollTo({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            }, 3000);
        }

        // Мобильное меню
        const menuToggle = document.querySelector('.menu-toggle');
        const navList = document.querySelector('.nav-list');
        menuToggle.addEventListener('click', () => {
            navList.classList.toggle('active');
        });
    });
    </script>
    <!-- Подключение и инициализация AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>