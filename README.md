# 🚗 Tamirhane Yönetim Sistemi

Tamirhane Yönetim Sistemi, araç servis ve tamiratlarının yönetimi için tasarlanmış kapsamlı bir web uygulamasıdır. Bu sistem, tamirhanelerin günlük operasyonlarını dijitalleştirerek iş süreçlerini optimize etmeyi amaçlamaktadır.

*[UYGULAMA DEMO VİDEO](https://drive.google.com/file/d/19QJAqNoNaJxXBfFEJb5AR02QlkSYk9At/view?usp=sharing)*

*[SİTE LİNK](http://95.130.171.20/~st22360859056)*


## 🌟 Özellikler

### 👥 Kullanıcı Yönetimi
- Güvenli kullanıcı kaydı ve girişi
- Şifrelerin güvenli bir şekilde hash'lenerek saklanması
- Oturum yönetimi (Session based authentication)
- Kullanıcı profil yönetimi

### 👨‍👩‍👦 Müşteri Yönetimi
- Yeni müşteri kaydı oluşturma
- Müşteri bilgilerini güncelleme
- Müşteri listeleme ve arama
- Müşteri silme işlemleri
- Müşteri iletişim bilgileri takibi

### 🚙 Araç Yönetimi
- Araç kayıt sistemi
- Detaylı araç bilgileri (marka, model, yıl, plaka, vb.)
- Araç geçmişi takibi
- Araç-müşteri ilişkilendirme
- Kilometre takibi

### 🔧 Tamir İşlemleri
- Yeni tamir kaydı oluşturma
- Tamir durumu takibi (beklemede, devam ediyor, tamamlandı)
- Maliyet hesaplama
- Tamir geçmişi görüntüleme
- Tamir detayları ve açıklamalar

## 💻 Teknolojik Altyapı

### Backend
- PHP 8.x (Framework kullanılmadan, saf PHP)
- MySQL Veritabanı
- PDO Database Connection
- Session Based Authentication

### Frontend
- HTML5
- CSS3
- Bootstrap 5.3.3
- JavaScript
- Responsive Tasarım

### Güvenlik
- Password Hashing (password_hash)
- Session Management
- Input Validation
- Prepared Statements (SQL Injection Prevention)

## 📁 Proje Yapısı

```
tamirhane/
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── images/
│
├── auth/
│   ├── login.php
│   ├── logout.php
│   ├── register.php
│   ├── profil.php
│   └── session.php
│
├── config/
│   └── database.php
│
├── includes/
│   ├── header.php
│   └── footer.php
│
└── pages/
    ├── dashboard.php
    ├── araclar/
    │   ├── ekle.php
    │   ├── duzenle.php
    │   ├── liste.php
    │   └── sil.php
    ├── musteriler/
    │   ├── ekle.php
    │   ├── duzenle.php
    │   ├── liste.php
    │   └── sil.php
    └── tamirler/
        ├── ekle.php
        ├── duzenle.php
        ├── liste.php
        └── sil.php
```

## 📊 Veritabanı Yapısı

### kullanicilar
```sql
CREATE TABLE kullanicilar (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kullanici_adi VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    sifre VARCHAR(255) NOT NULL,
    ad_soyad VARCHAR(100) NOT NULL,
    kayit_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### musteriler
```sql
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
```

### araclar
```sql
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
```

### tamir_islemleri
```sql
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
```

## 🔄 Veritabanı İlişkileri

- **Müşteri - Araç İlişkisi**: Bir müşterinin birden fazla aracı olabilir (1:N)
- **Araç - Tamir İlişkisi**: Bir araca ait birden fazla tamir kaydı olabilir (1:N)
- **Kullanıcı - Tamir İlişkisi**: Bir kullanıcı birden fazla tamir kaydı oluşturabilir (1:N)
- **Müşteri - Tamir İlişkisi**: Bir müşteriye ait birden fazla tamir kaydı olabilir (1:N)

## 🚀 Kurulum

1. Projeyi XAMPP'ın htdocs klasörüne klonlayın
2. MySQL veritabanını oluşturun
3. `database/tamirhane.sql` dosyasını import edin
4. `config/database.php` dosyasındaki veritabanı bilgilerini düzenleyin
5. Tarayıcıdan `http://localhost/tamirhane` adresine gidin

## 👥 Kullanım

1. İlk kullanımda kayıt olun
2. Giriş yapın
3. Dashboard üzerinden işlemlerinizi yönetin:
   - Müşteri ekle/düzenle/sil
   - Araç ekle/düzenle/sil
   - Tamir işlemi oluştur/düzenle/sil

## 🔒 Güvenlik Özellikleri

- Şifreler veritabanında hash'lenerek saklanır
- SQL injection koruması için prepared statements kullanılır(SQL saldırılarına karşı önlem)
- Session bazlı güvenli oturum yönetimi
- Input validation ile güvenli veri girişi

## 🎯 Hedef Kitle

- Küçük ve orta ölçekli tamirhaneler
- Servis istasyonları
- Araç bakım merkezleri
- Oto tamirciler


## 📸 Ekran Görüntüleri

![Görsel1](https://github.com/ahmetymtkn/Tamirhane_Musteri_Sistemi/blob/main/assets/images/image1.png)

**_(Görsel 1- Anasayfa)_**

![Görsel2](https://github.com/ahmetymtkn/Tamirhane_Musteri_Sistemi/blob/main/assets/images/image2.png)

**_(Görsel 2- Araç Düzenle Sayfası)_**

![Görsel3](https://github.com/ahmetymtkn/Tamirhane_Musteri_Sistemi/blob/main/assets/images/image3.png)

**_(Görsel 3- Tamir İşlemi Ekle Sayfaso)_**

![Görsel4](https://github.com/ahmetymtkn/Tamirhane_Musteri_Sistemi/blob/main/assets/images/image4.png)

**_(Görsel 4- Kayıt Sayfası)_**
