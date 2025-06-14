<?php
/**
 * Veritabanı Bağlantı Konfigürasyonu
 * 
 * Bu dosya veritabanı bağlantı parametrelerini ve PDO bağlantı nesnesini oluşturur.
 * Tüm veritabanı işlemleri için gerekli olan temel bağlantıyı sağlar.
 */

// Veritabanı bağlantı parametreleri
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'deneme789');

// PDO bağlantısının oluşturulması
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
    // Hata modunun ve fetch modunun ayarlanması
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>