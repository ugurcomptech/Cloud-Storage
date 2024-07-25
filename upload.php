<?php
$servername = "";
$username = "";  // Yeni kullanıcı adı
$password = "??"; // Yeni şifre
$dbname = "";  // Veritabanı adı
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Dosya boyutunu kontrol et (örn. 10GB'ı geçmesin)
    if ($_FILES["file"]["size"] > 10737418240) {
        echo "Üzgünüz, dosya boyutu çok büyük.";
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        echo "Üzgünz, dosya zaten var.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Üzgünüz, dosyanız yüklenemedi.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "Dosya ". htmlspecialchars(basename($_FILES["file"]["name"])) . " başarıyla yüklendi.";

            $file_size = $_FILES["file"]["size"]; // Dosya boyutunu al
            $stmt = $conn->prepare("INSERT INTO files (file_name, file_size) VALUES (?, ?)");
            $stmt->bind_param("si", $target_file, $file_size);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Üzgnüz, dosyanız yüklenirken bir hata oluştu.";
        }
    }
}

$conn->close();
header("Location: index.php");
exit();
?>
