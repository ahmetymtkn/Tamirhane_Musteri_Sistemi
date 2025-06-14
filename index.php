<?php
/**
 * Ana Sayfa Yönlendirme
 * 
 * Bu dosya sistemin ana giriş noktasıdır.
 * Kullanıcı durumuna göre giriş sayfasına veya dashboard'a yönlendirme yapar.
 */

// Gerekli dosyaların dahil edilmesi
require_once 'config/database.php';
require_once 'auth/session.php';

// Oturum kontrolü ve yönlendirme
if (!isLoggedIn()) {
    header('Location: auth/login.php');
    exit;
}

// Giriş yapmış kullanıcıyı dashboard'a yönlendir
header('Location: pages/dashboard.php');
?>