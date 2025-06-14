<?php
/**
 * Site Başlık Bölümü
 * 
 * Bu dosya sitenin üst kısmında yer alan header bölümünü içerir.
 * Navigasyon menüsü ve temel sayfa yapısı burada oluşturulur.
 */

// Oturum kontrolü
require_once dirname(__DIR__) . '/auth/session.php';
if (!isLoggedIn()) {
    header('Location: /tamirhane/auth/login.php');
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
    <link rel="stylesheet" href="/tamirhane/assets/css/style.css">
</head>
<body>
    <!-- Ana navigasyon menüsü -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/tamirhane/pages/dashboard.php">Tamirhane Sistemi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/tamirhane/pages/dashboard.php">Anasayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tamirhane/pages/musteriler/liste.php">Müşteriler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tamirhane/pages/araclar/liste.php">Araçlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tamirhane/pages/tamirler/liste.php">Tamir İşlemleri</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/tamirhane/auth/profil.php">Profil (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tamirhane/auth/logout.php">Çıkış Yap</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php if (!isLoggedIn()): ?>
        <div class="container mt-2">
            <a href="/tamirhane/auth/register.php" class="btn btn-success">Kayıt Ol</a>
            <a href="/tamirhane/auth/login.php" class="btn btn-primary">Giriş Yap</a>
        </div>
    <?php endif; ?>