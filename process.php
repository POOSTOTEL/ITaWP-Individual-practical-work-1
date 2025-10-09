<?php
require_once 'config.php';

$errors = [];

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $ad_title = clean_input($_POST['ad_title'] ?? '');
    $ad_category = clean_input($_POST['ad_category'] ?? '');
    $price = clean_input($_POST['price'] ?? '');
    $contact_email = clean_input($_POST['contact_email'] ?? '');
    $ad_text = clean_input($_POST['ad_text'] ?? '');
    
    if (empty($ad_title)) {
        $errors[] = "Заголовок объявления обязателен для заполнения";
    } elseif (strlen($ad_title) > 255) {
        $errors[] = "Заголовок не должен превышать 255 символов";
    }
    
    if (empty($ad_category)) {
        $errors[] = "Необходимо выбрать категорию";
    }
    
    if (empty($price)) {
        $errors[] = "Цена обязательна для заполнения";
    } elseif (!is_numeric($price) || $price < 0) {
        $errors[] = "Цена должна быть положительным числом";
    }
    
    if (empty($contact_email)) {
        $errors[] = "Email обязателен для заполнения";
    } elseif (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный формат email";
    }
    
    if (empty($ad_text)) {
        $errors[] = "Текст объявления обязателен для заполнения";
    }
    
    if (empty($errors)) {
        $stmt = $mysqli->prepare("INSERT INTO advertisements (ad_title, ad_category, price, contact_email, ad_text) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $ad_title, $ad_category, $price, $contact_email, $ad_text);
        
        if ($stmt->execute()) {
            $success_message = "Объявление успешно размещено!";
        } else {
            $errors[] = "Ошибка при сохранении в базу данных: " . $stmt->error;
        }
        
        $stmt->close();
    }
    
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат обработки</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .result-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h1 class="text-center mb-4">Результат обработки</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <h4>Обнаружены ошибки:</h4>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="text-center">
                <a href="form.html" class="btn btn-warning">Вернуться к форме</a>
            </div>
        <?php elseif (isset($success_message)): ?>
            <div class="alert alert-success text-center">
                <h4><?php echo $success_message; ?></h4>
                <p>Ваше объявление было успешно сохранено в базе данных.</p>
            </div>
            <div class="text-center">
                <a href="form.html" class="btn btn-primary">Разместить еще одно объявление</a>
            </div>
            
            <div class="mt-4 p-3 border rounded">
                <h5>Сохраненные данные:</h5>
                <p><strong>Заголовок:</strong> <?php echo htmlspecialchars($ad_title); ?></p>
                <p><strong>Категория:</strong> <?php echo htmlspecialchars($ad_category); ?></p>
                <p><strong>Цена:</strong> <?php echo number_format($price, 2, '.', ' '); ?> руб.</p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($contact_email); ?></p>
                <p><strong>Текст объявления:</strong><br><?php echo nl2br(htmlspecialchars($ad_text)); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>