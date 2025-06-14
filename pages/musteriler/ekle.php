<?php
/**
 * Müşteri Ekleme Sayfası
 * 
 * Bu dosya sisteme yeni müşteri eklenmesini sağlar.
 * Müşteri bilgileri form aracılığıyla alınıp veritabanına kaydedilir.
 */

// Gerekli dosyaların dahil edilmesi
require_once '../../config/database.php';
require_once '../../auth/session.php';

// Oturum kontrolü
if (!isLoggedIn()) {
    header('Location: ../../auth/login.php');
    exit;
}

$error = '';
$success = '';

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form verilerinin alınması ve filtrelenmesi
    $ad_soyad = trim($_POST['ad_soyad'] ?? '');
    $telefon = trim($_POST['telefon'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $adres = trim($_POST['adres'] ?? '');
    $tc_no = trim($_POST['tc_no'] ?? '');

    // Form validasyonu
    if (empty($ad_soyad) || empty($telefon)) {
        $error = 'Ad Soyad ve Telefon zorunludur.';
    } elseif (!preg_match('/^[0-9]{10}$/', $telefon)) {
        $error = 'Telefon numarası 10 haneli olmalıdır.';
    } else {
        // Veritabanına ekleme işlemi
        $stmt = $pdo->prepare("INSERT INTO musteriler (ad_soyad, telefon, email, adres, tc_no) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$ad_soyad, $telefon, $email ?: null, $adres ?: null, $tc_no ?: null])) {
            $success = 'Müşteri başarıyla eklendi.';
        } else {
            $error = 'Ekleme sırasında bir hata oluştu.';
        }
    }
}


?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Müşteri Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <div class="container mt-4">
        <h2>Müşteri Ekle</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" action="">

            <div class="mb-3">
                <label for="ad_soyad" class="form-label">Ad Soyad</label>
                <input type="text" class="form-control" id="ad_soyad" name="ad_soyad" required>
            </div>
            <div class="mb-3">
                <label for="telefon" class="form-label">Telefon</label>
                <input type="text" class="form-control" id="telefon" name="telefon" required pattern="[0-9]{10}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-posta</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="adres" class="form-label">Adres</label>
                <textarea class="form-control" id="adres" name="adres"></textarea>
            </div>
            <div class="mb-3">
                <label for="tc_no" class="form-label">TC No</label>
                <input type="text" class="form-control" id="tc_no" name="tc_no" pattern="[0-9]{11}">
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
            <a href="liste.php" class="btn btn-secondary">İptal</a>
        </form>
    </div>
    <?php include '../../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/script.js"></script>
</body>
</html>