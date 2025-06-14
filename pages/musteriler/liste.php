<?php
/**
 * Müşteri Listesi Sayfası
 * 
 * Bu dosya sistemdeki tüm müşterilerin listelenmesini sağlar.
 * Müşteriler arasında arama yapılabilir ve yeni müşteri ekleme sayfasına yönlendirme bulunur.
 */

// Gerekli dosyaların dahil edilmesi
require_once '../../config/database.php';
require_once '../../auth/session.php';

// Oturum kontrolü
if (!isLoggedIn()) {
    header('Location: ../../auth/login.php');
    exit;
}

// Arama parametresinin alınması ve müşterilerin veritabanından çekilmesi
$search = $_GET['search'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM musteriler WHERE ad_soyad LIKE ? OR telefon LIKE ? OR email LIKE ?");
$stmt->execute(["%$search%", "%$search%", "%$search%"]);
$customers = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Müşteri Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <div class="container mt-4">
        <h2>Müşteri Listesi</h2>
        <div class="row mb-3">
            <div class="col-md-6">
                <form class="d-flex" method="GET">
                    <input type="text" class="form-control me-2" name="search" placeholder="Ad, telefon veya e-posta ara" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary">Ara</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="ekle.php" class="btn btn-success">Yeni Müşteri Ekle</a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ad Soyad</th>
                    <th>Telefon</th>
                    <th>E-posta</th>
                    <th>Adres</th>
                    <th>TC No</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($customer['id']); ?></td>
                        <td><?php echo htmlspecialchars($customer['ad_soyad']); ?></td>
                        <td><?php echo htmlspecialchars($customer['telefon']); ?></td>
                        <td><?php echo htmlspecialchars($customer['email'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($customer['adres'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($customer['tc_no'] ?? '-'); ?></td>
                        <td>
                            <a href="duzenle.php?id=<?php echo $customer['id']; ?>" class="btn btn-sm btn-warning">Düzenle</a>
                            <a href="sil.php?id=<?php echo $customer['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete();">Sil</a>
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