<?php
/**
 * Araç Ekleme Sayfası
 * 
 * Bu dosya, sisteme yeni araç eklenmesini sağlar.
 * Araç bilgileri form aracılığıyla alınıp veritabanına kaydedilir.
 */

// Gerekli dosyaların dahil edilmesi
require_once '../../config/database.php';
require_once '../../auth/session.php';

// Oturum kontrolü
if (!isLoggedIn()) {
    header('Location: ../../auth/login.php');
    exit;
}

// Müşteri listesinin çekilmesi
$stmt = $pdo->query("SELECT id, ad_soyad FROM musteriler");
$customers = $stmt->fetchAll();

$error = '';
$success = '';

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form verilerinin alınması ve filtrelenmesi
    $musteri_id = filter_input(INPUT_POST, 'musteri_id', FILTER_VALIDATE_INT) ?: 0;
    $marka = trim($_POST['marka'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $yil = filter_input(INPUT_POST, 'yil', FILTER_VALIDATE_INT) ?: null;
    $plaka = trim($_POST['plaka'] ?? '');
    $renk = trim($_POST['renk'] ?? '');
    $motor_no = trim($_POST['motor_no'] ?? '');
    $sasi_no = trim($_POST['sasi_no'] ?? '');
    $km_bilgisi = filter_input(INPUT_POST, 'km_bilgisi', FILTER_VALIDATE_INT) ?: null;

    // Form validasyonu
    if (empty($musteri_id) || empty($marka) || empty($model) || empty($plaka)) {
        $error = 'Müşteri, Marka, Model ve Plaka zorunludur.';
    } else {
        // Veritabanına ekleme işlemi
        $stmt = $pdo->prepare("INSERT INTO araclar (musteri_id, marka, model, yil, plaka, renk, motor_no, sasi_no, km_bilgisi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$musteri_id, $marka, $model, $yil ?: null, $plaka, $renk ?: null, $motor_no ?: null, $sasi_no ?: null, $km_bilgisi ?: null])) {
            $success = 'Araç başarıyla eklendi.';
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
    <title>Araç Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <div class="container mt-4">
        <h2>Araç Ekle</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" action="">

            <div class="mb-3">
                <label for="musteri_id" class="form-label">Müşteri</label>
                <select class="form-select" id="musteri_id" name="musteri_id" required>
                    <option value="">Müşteri Seçin</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?php echo $customer['id']; ?>"><?php echo htmlspecialchars($customer['ad_soyad']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="marka" class="form-label">Marka</label>
                <input type="text" class="form-control" id="marka" name="marka" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="mb-3">
                <label for="yil" class="form-label">Yıl</label>
                <input type="number" class="form-control" id="yil" name="yil" min="1900" max="<?php echo date('Y'); ?>">
            </div>
            <div class="mb-3">
                <label for="plaka" class="form-label">Plaka</label>
                <input type="text" class="form-control" id="plaka" name="plaka" required>
            </div>
            <div class="mb-3">
                <label for="renk" class="form-label">Renk</label>
                <input type="text" class="form-control" id="renk" name="renk">
            </div>
            <div class="mb-3">
                <label for="motor_no" class="form-label">Motor No</label>
                <input type="text" class="form-control" id="motor_no" name="motor_no">
            </div>
            <div class="mb-3">
                <label for="sasi_no" class="form-label">Şasi No</label>
                <input type="text" class="form-control" id="sasi_no" name="sasi_no">
            </div>
            <div class="mb-3">
                <label for="km_bilgisi" class="form-label">KM Bilgisi</label>
                <input type="number" class="form-control" id="km_bilgisi" name="km_bilgisi" min="0">
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