<?php
/**
 * Araç Silme Sayfası
 * 
 * Bu dosya, sistemden araç silinmesini sağlar.
 * Yalnızca yetkili kullanıcılar araç silebilir.
 */

// Gerekli dosyaların dahil edilmesi
require_once '../../config/database.php';
require_once '../../auth/session.php';

// Oturum kontrolü
if (!isLoggedIn()) {
    header('Location: ../../auth/login.php');
    exit;
}

// Silinecek aracın ID'sinin alınması ve silme işleminin gerçekleştirilmesi
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("DELETE FROM araclar WHERE id = ?");
if ($stmt->execute([$id])) {
    header('Location: liste.php');
    exit;
} else {
    echo "Silme işlemi sırasında bir hata oluştu.";
}
?>