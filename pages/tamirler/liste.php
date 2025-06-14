<?php
/**
 * Tamir İşlemleri Listesi Sayfası
 * 
 * Bu dosya, sistemdeki tüm tamir işlemlerinin listelenmesini sağlar.
 * Tamir işlemleri arasında arama yapılabilir ve yeni tamir işlemi ekleme sayfasına yönlendirme bulunur.
 */

// Gerekli dosyaların dahil edilmesi
require_once '../../config/database.php';
require_once '../../auth/session.php';

// Oturum kontrolü
if (!isLoggedIn()) {
    header('Location: ../../auth/login.php');
    exit;
}

// Arama parametresinin alınması ve tamir işlemlerinin veritabanından çekilmesi
$search = $_GET['search'] ?? '';
$stmt = $pdo->prepare("SELECT t.*, a.plaka, m.ad_soyad, k.kullanici_adi FROM tamir_islemleri t JOIN araclar a ON t.arac_id = a.id JOIN musteriler m ON t.musteri_id = m.id JOIN kullanicilar k ON t.kullanici_id = k.id WHERE t.baslik LIKE ? OR a.plaka LIKE ?");
$stmt->execute(["%$search%", "%$search%"]);
$repairs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamir İşlemleri Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <div class="container mt-4">
        <h2>Tamir İşlemleri Listesi</h2>
        <div class="row mb-3">
            <div class="col-md-6">
                <form class="d-flex" method="GET">
                    <input type="text" class="form-control me-2" name="search" placeholder="Başlık veya plaka ara" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary">Ara</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="ekle.php" class="btn btn-success">Yeni Tamir İşlemi Ekle</a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Başlık</th>
                    <th>Araç</th>
                    <th>Müşteri</th>
                    <th>Kullanıcı</th>
                    <th>Durum</th>
                    <th>Maliyet</th>
                    <th>Kayit Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($repairs as $repair): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($repair['id']); ?></td>
                        <td><?php echo htmlspecialchars($repair['baslik']); ?></td>
                        <td><?php echo htmlspecialchars($repair['plaka']); ?></td>
                        <td><?php echo htmlspecialchars($repair['ad_soyad']); ?></td>
                        <td><?php echo htmlspecialchars($repair['kullanici_adi']); ?></td>
                        <td><?php echo htmlspecialchars($repair['durum']); ?></td>
                        <td><?php echo htmlspecialchars($repair['maliyet'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($repair['kayit_tarihi']); ?></td>
                        <td>
                            <a href="duzenle.php?id=<?php echo $repair['id']; ?>" class="btn btn-sm btn-warning">Düzenle</a>
                            <a href="sil.php?id=<?php echo $repair['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete();">Sil</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/script.js"></script>
</body>
</html>