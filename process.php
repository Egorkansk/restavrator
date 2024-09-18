<?php
// Папка для загрузки файлов
$targetDir = "uploads/";

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем, есть ли файл в массиве $_FILES
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Получаем информацию о файле
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];

        // Генерируем уникальное имя файла
        $newFileName = uniqid() . '-' . basename($fileName);
        $targetFilePath = $targetDir . $fileName;
      // if( isset($_POST['email'])) echo json_encode(['status' => 'error', 'message' => ' emaol. ok']);
        $email=$_POST['email'];
        // Перемещаем файл в папку uploads
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            echo json_encode(['status' => 'success', 'message' => 'Файл загружен успешно!', 'filename' => $newFileName]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ошибка при перемещении файла.']);
        }
        
        
        
        if (isset($_POST['opisanie'])) {
        // Получаем данные из поля opisanie
        $opisanie = $_POST['opisanie'];
           // Генерируем уникальное имя для текстового файла
        $fileName = $fileName.$email.'.txt';
        $filePath = $targetDir . $fileName;

        // Записываем данные в текстовый файл
        if (file_put_contents($filePath, $opisanie.PHP_EOL, FILE_APPEND) !== false) {
            echo json_encode(['status' => 'success', 'message' => 'Файл создан успешно!', 'filename' => $fileName]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ошибка при создании файла.']);
        }
file_put_contents($filePath, $email, FILE_APPEND);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Неверный метод запроса.']);
        }
       
        
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка загрузки файла.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Неверный метод запроса.']);
}
?>
