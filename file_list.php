<?php
$servername = "localhost";
$username = "";  // Yeni kullanıcı adı
$password = ""; // Yeni şifre
$dbname = "";  // Veritabanı adı

// Veritabanı bağlantısı
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Silme işlemi
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    // Dosya bilgilerini al
    $sql = "SELECT file_name FROM files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $file = $result->fetch_assoc();
    
    if ($file) {
        // Dosya yolunu belirle
        $file_path = 'uploads/' . $file['file_name'];
        
        // Dosyayı sunucudan sil
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Dosyayı veritabanından sil
        $sql = "DELETE FROM files WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
    }
    
    $stmt->close();
}

// Dosyaları listeleme
$sql = "SELECT id, file_name, upload_date FROM files";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<ul class="list-group">';
    while($row = $result->fetch_assoc()) {
        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
        echo "Dosya Adı: " . htmlspecialchars($row["file_name"]) . " - Yükleme Tarihi: " . htmlspecialchars($row["upload_date"]);
        echo '<div class="btn-group" role="group" aria-label="Dosya İşlemleri">';
        echo '<a href="' . htmlspecialchars($row["file_name"]) . '" class="btn btn-sm btn-primary" download>İndir</a>';
        echo '<a href="?delete_id=' . htmlspecialchars($row["id"]) . '" class="btn btn-sm btn-danger ml-2" onclick="return confirm(\'Bu dosyayı silmek istediğinizden emin misiniz?\');">Sil</a>';
        echo '</div>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p class="text-muted">Hiç dosya yok.</p>';
}

$conn->close();
?>
