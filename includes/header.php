<?php
/**
 * Site Header (Üst Kısım) Bileşeni
 * 
 * Bu dosya tüm sayfalarda kullanılan üst kısmı (header) içerir.
 * İçeriğinde:
 * - Oturum kontrolü
 * - Kök dizin yolu hesaplama
 * - Genel sayfa yapısı (DOCTYPE, meta etiketleri)
 * - CSS dosyaları
 * - Navigasyon menüsü
 */

// Oturum dosyasının dahil edilmesi
require_once dirname(__DIR__) . '/auth/session.php';

// Kök dizini bul
$scriptPath = $_SERVER['SCRIPT_NAME'];
$rootPath = '';

// pages dizininde olup olmadığımızı kontrol et
if (strpos($scriptPath, '/pages/') !== false) {
    // /pages/ konumuna kadar olan kısmı al
    $rootPath = substr($scriptPath, 0, strpos($scriptPath, '/pages/'));
}

// Oturum kontrolü ve yönlendirme
if (!isLoggedIn()) {
    header('Location: ' . $rootPath . '/auth/login.php');
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
    <link rel="stylesheet" href="<?php echo $rootPath; ?>/assets/css/style.css">
</head>
<body>
    <!-- Ana navigasyon menüsü -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $rootPath; ?>/pages/dashboard.php">Tamirhane Sistemi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $rootPath; ?>/pages/dashboard.php">Anasayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $rootPath; ?>/pages/musteriler/liste.php">Müşteriler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $rootPath; ?>/pages/araclar/liste.php">Araçlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $rootPath; ?>/pages/tamirler/liste.php">Tamir İşlemleri</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $rootPath; ?>/auth/profil.php">Profil (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $rootPath; ?>/auth/logout.php">Çıkış Yap</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php if (!isLoggedIn()): ?>
        <div class="container mt-2">
            <a href="<?php echo $rootPath; ?>/auth/register.php" class="btn btn-success">Kayıt Ol</a>
            <a href="<?php echo $rootPath; ?>/auth/login.php" class="btn btn-primary">Giriş Yap</a>
        </div>
    <?php endif; ?>
