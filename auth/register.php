<?php
/**
 * Kullanıcı Kayıt Sayfası
 * 
 * Bu dosya yeni kullanıcıların sisteme kaydolmasını sağlar.
 * Kullanıcı bilgileri alınır, doğrulanır ve veritabanına kaydedilir.
 */

// Gerekli dosyaların dahil edilmesi
require_once '../config/database.php';
require_once 'session.php';

// Kullanıcı zaten giriş yapmışsa dashboard'a yönlendir
if (isLoggedIn()) {
    header('Location: ../pages/dashboard.php');
    exit;
}

$errors = [];
$success = '';

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form verilerinin alınması ve filtrelenmesi
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $password_repeat = $_POST['password_repeat'] ?? '';

    // Form validasyonu
    if (empty($username) || empty($email) || empty($password) || empty($name) || empty($password_repeat)) {
        $errors[] = 'Tüm alanlar zorunludur.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Şifre en az 6 karakter olmalıdır.';
    } elseif ($password !== $password_repeat) {
        $errors[] = 'Şifreler eşleşmiyor.';
    } else {
        // Kullanıcı adı ve email kontrolü
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM kullanicilar WHERE kullanici_adi = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'Kullanıcı adı veya e-posta zaten kayıtlı.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO kullanicilar (kullanici_adi, email, sifre, ad_soyad) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashed_password, $name])) {
                $success = 'Kayıt başarılı! Şimdi giriş yapabilirsiniz.';
                header('Location: login.php?success=' . urlencode($success));
                exit;
            } else {
                $errors[] = 'Kayıt sırasında bir hata oluştu.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Kayıt Ol</h2>
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors as $error): ?>
                                    <p><?php echo htmlspecialchars($error); ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-posta</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Şifre</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_repeat" class="form-label">Şifre Tekrar</label>
                                <input type="password" class="form-control" id="password_repeat" name="password_repeat" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Ad Soyad</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kayıt Ol</button>
                        </form>
                        <p class="mt-3 text-center">Hesabınız var mı? <a href="login.php">Giriş yap</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>