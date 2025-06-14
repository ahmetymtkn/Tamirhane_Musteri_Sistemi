<?php
/**
 * Kullanıcı Giriş Sayfası
 * 
 * Bu dosya kullanıcıların sisteme giriş yapmasını sağlar.
 * Kullanıcı adı ve şifre kontrolü yapılarak oturum başlatılır.
 */

// Gerekli dosyaların dahil edilmesi
require_once '../config/database.php';
require_once 'session.php';

// Kullanıcı zaten giriş yapmışsa dashboard'a yönlendir
if (isLoggedIn()) {
    header('Location: ../pages/dashboard.php');
    exit;
}

$error = '';

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form verilerinin alınması ve filtrelenmesi
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Form validasyonu
    if (empty($username) || empty($password)) {
        $error = 'Tüm alanlar zorunludur.';
    } else {
        // Kullanıcı bilgilerinin veritabanından kontrolü
        $stmt = $pdo->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Şifre kontrolü ve oturum başlatma
        if ($user && password_verify($password, $user['sifre'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['kullanici_adi'];
            header('Location: ../pages/dashboard.php');
            exit;
        } else {
            $error = 'Geçersiz kullanıcı adı veya şifre.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Giriş Yap</h2>
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Şifre</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                        </form>
                        <p class="mt-3 text-center">Hesabınız yok mu? <a href="register.php">Kayıt Ol</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>