<?php
/**
 * Kullanıcı Profil Sayfası
 * 
 * Bu dosya kullanıcıların kendi profillerini düzenlemelerini sağlar.
 * Kullanıcı adı, e-posta, isim ve şifre güncellenebilir.
 */

// Gerekli dosyaların dahil edilmesi
require_once '../config/database.php';
require_once 'session.php';

// Oturum kontrolü
if (!isLoggedIn()) {
    header('Location: /tamirhane/auth/login.php');
    exit;
}

// Hata mesajları için dizi ve kullanıcı bilgilerinin çekilmesi
$errors = [];
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM kullanicilar WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form verilerinin alınması ve filtrelenmesi
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $password = $_POST['password'] ?? '';

    // Form validasyonu
    if (empty($username) || empty($email) || empty($name)) {
        $errors[] = 'Tüm alanlar zorunludur (şifre hariç).';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Geçersiz e-posta adresi.';
    } else {
        // Kullanıcı adı ve email benzersizlik kontrolü
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM kullanicilar WHERE (kullanici_adi = ? OR email = ?) AND id != ?");
        $stmt->execute([$username, $email, $user_id]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'Kullanıcı adı veya e-posta zaten kullanımda.';
        }
    }

    if (empty($errors)) {
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE kullanicilar SET kullanici_adi = ?, email = ?, ad_soyad = ?, sifre = ? WHERE id = ?");
            $stmt->execute([$username, $email, $name, $hashed_password, $user_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE kullanicilar SET kullanici_adi = ?, email = ?, ad_soyad = ? WHERE id = ?");
            $stmt->execute([$username, $email, $name, $user_id]);
        }
        $_SESSION['username'] = $username; // Oturum bilgisini güncelle
        header('Location: /tamirhane/pages/dashboard.php?success=Profil güncellendi');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="flex-grow-1">
        <?php include '../includes/header.php'; ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">Profil Düzenle</h2>
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <?php foreach ($errors as $error): ?>
                                        <p><?php echo htmlspecialchars($error); ?></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Kullanıcı Adı</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['kullanici_adi']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-posta</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Ad Soyad</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['ad_soyad']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Yeni Şifre (değiştirmek istemiyorsanız boş bırakın)</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Kaydet</button>
                                <a href="/tamirhane/pages/dashboard.php" class="btn btn-secondary mt-2 w-100">İptal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>