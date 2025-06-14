<?php
/**
 * Tamir İşlemi Ekleme Sayfası
 * 
 * Bu dosya, sisteme yeni tamir işlemi eklenmesini sağlar.
 * Tamir işlemi bilgileri form aracılığıyla alınıp veritabanına kaydedilir.
 */

// Gerekli dosyaların dahil edilmesi
require_once '../../config/database.php';
require_once '../../auth/session.php';

// Oturum kontrolü
if (!isLoggedIn()) {
    header('Location: ../../auth/login.php');
    exit;
}

// Araç ve müşteri bilgilerinin veritabanından çekilmesi
$stmt = $pdo->query("SELECT a.id, a.plaka, m.ad_soyad, m.id AS musteri_id FROM araclar a JOIN musteriler m ON a.musteri_id = m.id");
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$error = '';
$success = '';

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form verilerinin alınması ve filtrelenmesi
    $arac_id = filter_input(INPUT_POST, 'arac_id', FILTER_VALIDATE_INT) ?: 0;
    $musteri_id = filter_input(INPUT_POST, 'musteri_id', FILTER_VALIDATE_INT) ?: 0;
    $baslik = trim($_POST['baslik'] ?? '');
    $aciklama = trim($_POST['aciklama'] ?? '');
    $durum = $_POST['durum'] ?? 'beklemede';
    $maliyet = filter_input(INPUT_POST, 'maliyet', FILTER_VALIDATE_FLOAT) ?: 0.00;
    $kullanici_id = $_SESSION['user_id'];

    // Form validasyonu
    if (empty($arac_id) || empty($baslik)) {
        $error = 'Araç ve Başlık zorunludur.';
    } elseif (!in_array($durum, ['beklemede', 'devam_ediyor', 'tamamlandi'])) {
        $error = 'Geçersiz durum seçimi.';
    } elseif ($maliyet < 0) {
        $error = 'Maliyet negatif olamaz.';
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO tamir_islemleri (arac_id, musteri_id, kullanici_id, baslik, aciklama, durum, maliyet)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            if ($stmt->execute([$arac_id, $musteri_id, $kullanici_id, $baslik, $aciklama ?: null, $durum, $maliyet])) {
                $success = 'Tamir işlemi başarıyla eklendi.';
            } else {
                $error = 'Ekleme sırasında bir hata oluştu.';
            }
        } catch (PDOException $e) {
            $error = 'Veritabanı hatası: ' . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamir İşlemi Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <div class="container mt-4">
        <h2>Tamir İşlemi Ekle</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="arac_id" class="form-label">Araç</label>
                <select class="form-select" id="arac_id" name="arac_id" required onchange="updateMusteriId(this)">
                    <option value="">Araç Seçin</option>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <option value="<?php echo $vehicle['id']; ?>" data-musteri-id="<?php echo $vehicle['musteri_id']; ?>">
                            <?php echo htmlspecialchars($vehicle['plaka'] . ' - ' . $vehicle['ad_soyad']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" id="musteri_id" name="musteri_id">
            </div>
            <div class="mb-3">
                <label for="baslik" class="form-label">Başlık</label>
                <input type="text" class="form-control" id="baslik" name="baslik" required>
            </div>
            <div class="mb-3">
                <label for="aciklama" class="form-label">Açıklama</label>
                <textarea class="form-control" id="aciklama" name="aciklama"></textarea>
            </div>
            <div class="mb-3">
                <label for="durum" class="form-label">Durum</label>
                <select class="form-select" id="durum" name="durum">
                    <option value="beklemede">Beklemede</option>
                    <option value="devam_ediyor">Devam Ediyor</option>
                    <option value="tamamlandi">Tamamlandı</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="maliyet" class="form-label">Maliyet (TL)</label>
                <input type="number" class="form-control" id="maliyet" name="maliyet" step="0.01" min="0" placeholder="0.00">
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
            <a href="liste.php" class="btn btn-secondary">İptal</a>
        </form>
    </div>
    <?php include '../../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/script.js"></script>
    <script>
        function updateMusteriId(select) {
            const musteriId = select.options[select.selectedIndex].dataset.musteriId;
            document.getElementById('musteri_id').value = musteriId || '';
        }
    </script>
</body>
</html>