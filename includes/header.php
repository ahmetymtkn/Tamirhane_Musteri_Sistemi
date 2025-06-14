<?php
/**
 * Site Header (Üst Kısım) Bileşeni
 * 
 * Bu dosya tüm sayfalarda kullanılan üst kısmı (header) içerir.
 * Navigasyon menüsü ve temel sayfa yapısını oluşturur.
 */

// Oturum kontrolü için gerekli dosya
require_once dirname(__DIR__) . '/auth/session.php';

// Kök dizini dinamik olarak bul
$currentPath = $_SERVER['SCRIPT_NAME'];
$projectRoot = '';

// Proje kök dizinini bul (ilk parçayı al)
if (preg_match('/^\/[^\/]+/', $currentPath, $matches)) {
    $projectRoot = $matches[0];
}

// Oturum kontrolü ve yönlendirme
if (!isLoggedIn()) {
    header('Location: ' . $projectRoot . '/auth/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <!-- Meta etiketleri -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Araç Tamirhane Sistemi</title>

    <!-- CSS dosyaları -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $projectRoot; ?>/assets/css/style.css">
</head>
<body>
    <!-- Ana navigasyon menüsü -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $projectRoot; ?>/pages/dashboard.php">Tamirhane Sistemi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $projectRoot; ?>/pages/dashboard.php">Anasayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $projectRoot; ?>/pages/musteriler/liste.php">Müşteriler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $projectRoot; ?>/pages/araclar/liste.php">Araçlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $projectRoot; ?>/pages/tamirler/liste.php">Tamir İşlemleri</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $projectRoot; ?>/auth/profil.php">Profil (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $projectRoot; ?>/auth/logout.php">Çıkış Yap</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php if (!isLoggedIn()): ?>
        <div class="container mt-2">
            <a href="<?php echo $projectRoot; ?>/auth/register.php" class="btn btn-success">Kayıt Ol</a>
            <a href="<?php echo $projectRoot; ?>/auth/login.php" class="btn btn-primary">Giriş Yap</a>
        </div>
    <?php endif; ?>
