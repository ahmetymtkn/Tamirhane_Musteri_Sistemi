CREATE TABLE kullanicilar (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kullanici_adi VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    sifre VARCHAR(255) NOT NULL,
    ad_soyad VARCHAR(100) NOT NULL,
    kayit_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE musteriler (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ad_soyad VARCHAR(100) NOT NULL,
    telefon VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    adres TEXT,
    tc_no VARCHAR(11),
    kayit_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP,
    guncellenme_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE araclar (
    id INT PRIMARY KEY AUTO_INCREMENT,
    musteri_id INT NOT NULL,
    marka VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    yil YEAR,
    plaka VARCHAR(10) UNIQUE NOT NULL,
    renk VARCHAR(30),
    motor_no VARCHAR(50),
    sasi_no VARCHAR(50),
    km_bilgisi INT,
    kayit_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (musteri_id) REFERENCES musteriler(id) ON DELETE CASCADE
);

CREATE TABLE tamir_islemleri (
    id INT PRIMARY KEY AUTO_INCREMENT,
    arac_id INT NOT NULL,
    musteri_id INT NOT NULL,
    kullanici_id INT NOT NULL,
    baslik VARCHAR(200) NOT NULL,
    aciklama TEXT,
    durum ENUM('beklemede', 'devam_ediyor', 'tamamlandi') DEFAULT 'beklemede',
    maliyet DECIMAL(10,2) DEFAULT 0.00,
    kayit_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP,
    guncellenme_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (arac_id) REFERENCES araclar(id) ON DELETE CASCADE,
    FOREIGN KEY (musteri_id) REFERENCES musteriler(id) ON DELETE CASCADE,
    FOREIGN KEY (kullanici_id) REFERENCES kullanicilar(id)
);