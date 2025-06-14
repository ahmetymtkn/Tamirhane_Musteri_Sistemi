<?php
/**
 * Oturum Yönetimi
 * 
 * Bu dosya oturum yönetimi için gerekli fonksiyonları içerir.
 * Kullanıcının oturum durumunu kontrol etmek için kullanılır.
 */

// Oturum başlatma
session_start();

/**
 * Kullanıcının giriş yapmış olup olmadığını kontrol eder
 * 
 * @return bool Kullanıcı giriş yapmışsa true, yapmamışsa false döner
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>
