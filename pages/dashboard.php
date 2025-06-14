<?php
require_once '../config/database.php';
require_once '../auth/session.php';

if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit;
}

// Statistics
$stmt = $pdo->query("SELECT COUNT(*) as count FROM musteriler");
$total_customers = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM araclar");
$total_vehicles = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM tamir_islemleri WHERE durum = 'beklemede'");
$pending_repairs = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM tamir_islemleri WHERE durum = 'tamamlandi'");
$completed_repairs = $stmt->fetch()['count'];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Hoş Geldiniz, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                <p class="text-muted mb-0">Bugün: <?php echo date('d.m.Y'); ?></p>
            </div>
            <div>
                <a href="tamirler/ekle.php" class="btn btn-primary me-2">
                    <i class="bi bi-plus-lg"></i> Yeni Tamir
                </a>
            </div>
        </div>
        
        <div class="row g-4 mt-2">
            <div class="col-md-3">
                <div class="card stat-card text-center">
                    <div class="card-body position-relative">
                        <div class="stat-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">Toplam Müşteri</h6>
                        <h2 class="card-title mb-0"><?php echo $total_customers; ?></h2>
                        <a href="musteriler/liste.php" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card text-center">
                    <div class="card-body position-relative">
                        <div class="stat-icon">
                            <i class="bi bi-car-front"></i>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">Toplam Araç</h6>
                        <h2 class="card-title mb-0"><?php echo $total_vehicles; ?></h2>
                        <a href="araclar/liste.php" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card text-center">
                    <div class="card-body position-relative">
                        <div class="stat-icon">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">Bekleyen Tamirler</h6>
                        <h2 class="card-title mb-0"><?php echo $pending_repairs; ?></h2>
                        <a href="tamirler/liste.php?durum=beklemede" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card text-center">
                    <div class="card-body position-relative">
                        <div class="stat-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">Tamamlanan Tamirler</h6>
                        <h2 class="card-title mb-0"><?php echo $completed_repairs; ?></h2>
                        <a href="tamirler/liste.php?durum=tamamlandi" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Son Tamir İşlemleri</h3>
                    <a href="tamirler/liste.php" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-list"></i> Tümünü Gör
                    </a>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Başlık</th>
                                        <th>Araç</th>
                                        <th>Müşteri</th>
                                        <th>Durum</th>
                                        <th>Kayıt Tarihi</th>
                                        <th class="text-end">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->query("SELECT t.*, a.plaka, m.ad_soyad FROM tamir_islemleri t JOIN araclar a ON t.arac_id = a.id JOIN musteriler m ON t.musteri_id = m.id ORDER BY t.kayit_tarihi DESC LIMIT 5");                                    while ($row = $stmt->fetch()): ?>                                        <tr>
                                            <td>
                                                <a href="tamirler/duzenle.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-tools me-2 text-muted"></i>
                                                        <?php echo htmlspecialchars($row['baslik']); ?>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-car-front me-2 text-muted"></i>
                                                    <?php echo htmlspecialchars($row['plaka']); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-person me-2 text-muted"></i>
                                                    <?php echo htmlspecialchars($row['ad_soyad']); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                $durum = htmlspecialchars($row['durum']);
                                                $renk = match($durum) {
                                                    'beklemede' => 'secondary',
                                                    'devam_ediyor' => 'warning',
                                                    'tamamlandi' => 'success',
                                                    default => 'secondary'
                                                };
                                                $icon = match($durum) {
                                                    'beklemede' => 'hourglass',
                                                    'devam_ediyor' => 'arrow-repeat',
                                                    'tamamlandi' => 'check2-circle',
                                                    default => 'question-circle'
                                                };
                                                echo "<span class='badge bg-{$renk}'><i class='bi bi-{$icon} me-1'></i>{$durum}</span>";
                                                ?>
                                            </td>
                                            <td><?php echo date('d.m.Y H:i', strtotime($row['kayit_tarihi'])); ?></td>
                                            <td class="text-end">
                                                <a href="tamirler/duzenle.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i> Düzenle
                                                </a>
                                            </td>
                                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>