<?php
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

// Проверка, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $improvement = $_POST['improvement'];

    // Подготовка SQL запроса для вставки данных в таблицу
    $sql = "INSERT INTO applications (phone_number, email, improvement) VALUES (?, ?, ?)";

    // Создание подготовленного выражения
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $phone_number, $email, $improvement);

    // Выполнение запроса
    if ($stmt->execute()) {
        // Заявка успешно отправлена, показываем сообщение
        echo "Заявка успешно отправлена!";
        // JavaScript код для перенаправления через 2 секунды
        echo "<script>setTimeout(function(){window.location.href='index.php';}, 2000);</script>";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    // Закрытие подготовленного выражения
    $stmt->close();
}

// Закрытие соединения
$conn->close();
