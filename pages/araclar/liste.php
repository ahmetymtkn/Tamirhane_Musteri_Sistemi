<?php
/**
 * Araç Listesi Sayfası
 * 
 * Bu dosya, sistemde kayıtlı tüm araçların listelenmesini sağlar.
 * Araçlar arasında arama yapılabilir ve yeni araç ekleme sayfasına yönlendirme bulunur.
 */

// Gerekli dosyaların dahil edilmesi
require_once '../../config/database.php';
require_once '../../auth/session.php';

// Oturum kontrolü
if (!isLoggedIn()) {
    header('Location: ../../auth/login.php');
    exit;
}

// Arama parametresinin alınması ve araçların veritabanından çekilmesi
$search = $_GET['search'] ?? '';
$stmt = $pdo->prepare("SELECT a.*, m.ad_soyad FROM araclar a JOIN musteriler m ON a.musteri_id = m.id WHERE a.plaka LIKE ? OR a.marka LIKE ? OR a.model LIKE ?");
$stmt->execute(["%$search%", "%$search%", "%$search%"]);
$vehicles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Araç Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <div class="container mt-4">
        <h2>Araç Listesi</h2>
        <div class="row mb-3">
            <div class="col-md-6">
                <form class="d-flex" method="GET">
                    <input type="text" class="form-control me-2" name="search" placeholder="Plaka, marka veya model ara" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary">Ara</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="ekle.php" class="btn btn-success">Yeni Araç Ekle</a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Müşteri</th>
                    <th>Plaka</th>
                    <th>Marka</th>
                    <th>Model</th>
                    <th>Yıl</th>
                    <th>Renk</th>
                    <th>KM</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($vehicle['id']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['ad_soyad']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['plaka']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['marka']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['model']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['yil'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['renk'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['km_bilgisi'] ?? '-'); ?></td>
                        <td>
                            <a href="duzenle.php?id=<?php echo $vehicle['id']; ?>" class="btn btn-sm btn-warning">Düzenle</a>
                            <a href="sil.php?id=<?php echo $vehicle['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete();">Sil</a>
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