<?php
/**
 * Çıkış İşlemi
 * 
 * Bu dosya kullanıcının sistemden çıkış yapmasını sağlar.
 * Oturum sonlandırılır ve kullanıcı giriş sayfasına yönlendirilir.
 */

// Oturum dosyasının dahil edilmesi
require_once 'session.php';

// Oturumu sonlandır ve giriş sayfasına yönlendir
session_destroy();
header('Location: login.php');
exit;
?>