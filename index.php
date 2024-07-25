<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$servername = "";
$username = "";  // Yeni kullanıcı adı
$password = ""; // Yeni şifre
$dbname = "";  // Veritabanı adı

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatas: " . $conn->connect_error);
}

// Toplam dosya boyutunu hesaplama
$sql = "SELECT SUM(file_size) as total_size FROM files";
$result = $conn->query($sql);
$total_size = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_size = $row['total_size'];
}

$total_size_mb = $total_size / (1024 * 1024);
$total_size_gb = $total_size / (1024 * 1024 * 1024);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosya Yükleme ve Listeleme</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="/photo/android-chrome-192x192.png" type="image/x-icon">
    <style>
        .custom-file-input ~ .custom-file-label::after {
            content: "Gözat";
        }
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }
        .dark-mode .card {
            background-color: #1e1e1e;
        }
        .dark-mode .list-group-item {
            background-color: #1e1e1e;
            color: #ffffff;
        }
        .dark-mode .btn-primary {
            background-color: #6200ea;
            border-color: #6200ea;
        }
    </style>
</head>
<body class="light-mode">
    <div class="container mt-5">
        <h1 class="text-center">Bulut Depolama</h1>
        
        <div class="form-group text-right">
            <label class="switch">
                <input type="checkbox" id="darkModeToggle">
                <span class="slider round"></span>
            </label>
            <label for="darkModeToggle">Dark Mode</label>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Dosya Yükleme</h5>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file" required>
                            <label class="custom-file-label" for="file">Dosya Seçin</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Yükle</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Yüklenen Dosyalar</h5>
                <div id="fileList">
                    <?php include 'file_list.php'; ?>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Toplam Yklenen Dosya Boyutu</h5>
                <p>
                    Toplam: 
                    <span class="<?php echo ($total_size_gb > 10) ? 'text-danger' : ''; ?>">
                        <?php echo number_format($total_size_mb, 2) . " MB (" . number_format($total_size_gb, 2) . " GB)"; ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Dosya adı seçildiğinde etiketin güncellenmesini sağlar
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        // Dark mode toggle
        document.getElementById('darkModeToggle').addEventListener('change', function() {
            document.body.classList.toggle('dark-mode');
        });
    </script>
</body>
</html>
