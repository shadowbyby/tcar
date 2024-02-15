<?php
session_start();

// Проверка, был ли выполнен вход администратора
if (isset($_POST['login']) && isset($_POST['password'])) {
    if ($_POST['login'] === 'admin' && $_POST['password'] === 'admin') {
        // Установка метки сессии для администратора
        $_SESSION['login'] = 'admin';
    } else {
        echo "Неверный логин или пароль";
    }
}

// Проверка, авторизован ли пользователь
if (isset($_SESSION['login']) && $_SESSION['login'] === 'admin') {
    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tcar";

    // Создание соединения
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Удаление заявки, если получен запрос на удаление
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $sql_delete = "DELETE FROM applications WHERE id=$delete_id";
        if ($conn->query($sql_delete) === TRUE) {
            echo "Заявка успешно удалена<br>";
        } else {
            echo "Ошибка удаления заявки: " . $conn->error;
        }
    }

    // Получение всех заявок
    $sql = "SELECT * FROM applications";
    $result = $conn->query($sql);

    // Вывод заявок
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Номер телефона: " . $row["phone_number"] . " - Email: " . $row["email"] . " - Улучшение: " . $row["improvement"] . " <a href='?delete=" . $row['id'] . "'>Удалить</a><br>";
        }
    } else {
        echo "Нет заявок";
    }

    // Закрытие соединения
    $conn->close();
} else {
    // Если администратор не авторизован, показываем форму входа
    echo '
    <h2>Вход для администратора</h2>
    <form method="post" action="">
        <input type="text" name="login" placeholder="Логин"><br>
        <input type="password" name="password" placeholder="Пароль"><br>
        <button type="submit">Войти</button>
    </form>';
}
