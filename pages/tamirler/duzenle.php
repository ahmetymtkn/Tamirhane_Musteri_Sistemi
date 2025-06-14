<?php
/**
 * Tamir İşlemi Düzenleme Sayfası
 * 
 * Bu dosya, sistemde kayıtlı tamir işlemlerinin düzenlenmesini sağlar.
 * Yetkili kullanıcılar tamir işlemi bilgilerini güncelleyebilir.
 */

// Gerekli dosyaların dahil edilmesi
require_once '../../config/database.php';
require_once '../../auth/session.php';

// Oturum kontrolü
if (!isLoggedIn()) {
    header('Location: ../../auth/login.php');
    exit;
}

// Araç ve müşteri bilgilerinin çekilmesi
$stmt_vehicles = $pdo->query("SELECT a.id, a.plaka, m.ad_soyad, m.id AS musteri_id FROM araclar a JOIN musteriler m ON a.musteri_id = m.id");
$vehicles = $stmt_vehicles->fetchAll(PDO::FETCH_ASSOC);

$error = '';
$success = '';
$repair = null;

// Düzenlenecek tamir işleminin ID'sinin alınması
$repair_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$repair_id) {
    header('Location: liste.php');
    exit;
}

// Mevcut tamir işlemi verilerinin çekilmesi
$stmt_repair = $pdo->prepare("SELECT * FROM tamir_islemleri WHERE id = ?");
$stmt_repair->execute([$repair_id]);
$repair = $stmt_repair->fetch(PDO::FETCH_ASSOC);

// Tamir işlemi bulunamazsa liste sayfasına yönlendirme
if (!$repair) {
    header('Location: liste.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $arac_id = filter_input(INPUT_POST, 'arac_id', FILTER_VALIDATE_INT) ?: 0;
    $musteri_id = filter_input(INPUT_POST, 'musteri_id', FILTER_VALIDATE_INT) ?: 0;
    $baslik = trim($_POST['baslik'] ?? '');
    $aciklama = trim($_POST['aciklama'] ?? '');
    $durum = $_POST['durum'] ?? 'beklemede';
    $maliyet = filter_input(INPUT_POST, 'maliyet', FILTER_VALIDATE_FLOAT) ?: null;

    // Validate inputs
    if (empty($arac_id) || empty($baslik)) {
        $error = 'Araç ve Başlık zorunludur.';
    } elseif (!in_array($durum, ['beklemede', 'devam_ediyor', 'tamamlandi'])) {
        $error = 'Geçersiz durum seçimi.';
    } else {
        try {
            $stmt = $pdo->prepare("
                UPDATE tamir_islemleri 
                SET arac_id = ?, musteri_id = ?, baslik = ?, aciklama = ?, durum = ?, maliyet = ?
                WHERE id = ?
            ");
            if ($stmt->execute([$arac_id, $musteri_id, $baslik, $aciklama ?: null, $durum, $maliyet, $repair_id])) {
                $success = 'Tamir işlemi başarıyla güncellendi.';
                // Refresh repair data after update
                $stmt_repair->execute([$repair_id]);
                $repair = $stmt_repair->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = 'Güncelleme sırasında bir hata oluştu.';
            }
        } catch (PDOException $e) {
            $error = 'Veritabanı hatası: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamir İşlemini Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <div class="container mt-4">
        <h2>Tamir İşlemini Düzenle</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if ($repair): ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="arac_id" class="form-label">Araç</label>
                    <select class="form-select" id="arac_id" name="arac_id" required onchange="updateMusteriId(this)">
                        <option value="">Araç Seçin</option>
                        <?php foreach ($vehicles as $vehicle): ?>
                            <option value="<?php echo $vehicle['id']; ?>" data-musteri-id="<?php echo $vehicle['musteri_id']; ?>" 
                                    <?php echo $vehicle['id'] == $repair['arac_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($vehicle['plaka'] . ' - ' . $vehicle['ad_soyad']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" id="musteri_id" name="musteri_id" value="<?php echo htmlspecialchars($repair['musteri_id']); ?>">
                </div>
                <div class="mb-3">
                    <label for="baslik" class="form-label">Başlık</label>
                    <input type="text" class="form-control" id="baslik" name="baslik" value="<?php echo htmlspecialchars($repair['baslik']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="aciklama" class="form-label">Açıklama</label>
                    <textarea class="form-control" id="aciklama" name="aciklama"><?php echo htmlspecialchars($repair['aciklama'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="durum" class="form-label">Durum</label>
                    <select class="form-select" id="durum" name="durum">
                        <option value="beklemede" <?php echo $repair['durum'] === 'beklemede' ? 'selected' : ''; ?>>Beklemede</option>
                        <option value="devam_ediyor" <?php echo $repair['durum'] === 'devam_ediyor' ? 'selected' : ''; ?>>Devam Ediyor</option>
                        <option value="tamamlandi" <?php echo $repair['durum'] === 'tamamlandi' ? 'selected' : ''; ?>>Tamamlandı</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="maliyet" class="form-label">Maliyet (TL)</label>
                    <input type="number" class="form-control" id="maliyet" name="maliyet" step="0.01" min="0" value="<?php echo htmlspecialchars($repair['maliyet'] ?? '0.00'); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Güncelle</button>
                <a href="liste.php" class="btn btn-secondary">İptal</a>
            </form>
        <?php endif; ?>
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