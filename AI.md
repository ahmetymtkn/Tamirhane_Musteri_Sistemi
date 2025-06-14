# Tamirhane Müşteri Sistemi - Yapay Zeka Destekli Geliştirme Süreci



**Soru:** Aşağıdaki SQL tablolarım için her birine 50’şer veri ekler misiniz?
> 
> ```sql
> CREATE TABLE kullanicilar (
>     id INT PRIMARY KEY AUTO_INCREMENT,
>     kullanici_adi VARCHAR(50) UNIQUE NOT NULL,
>     email VARCHAR(100) UNIQUE NOT NULL,
>     sifre VARCHAR(255) NOT NULL,
>     ad_soyad VARCHAR(100) NOT NULL,
>     kayit_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP
> );
> 
> CREATE TABLE musteriler (
>     id INT PRIMARY KEY AUTO_INCREMENT,
>     ad_soyad VARCHAR(100) NOT NULL,
>     telefon VARCHAR(15) NOT NULL,
>     email VARCHAR(100),
>     adres TEXT,
>     tc_no VARCHAR(11),
>     kayit_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP,
>     guncellenme_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
> );
> 
> CREATE TABLE araclar (
>     id INT PRIMARY KEY AUTO_INCREMENT,
>     musteri_id INT NOT NULL,
>     marka VARCHAR(50) NOT NULL,
>     model VARCHAR(50) NOT NULL,
>     yil YEAR,
>     plaka VARCHAR(10) UNIQUE NOT NULL,
>     renk VARCHAR(30),
>     motor_no VARCHAR(50),
>     sasi_no VARCHAR(50),
>     km_bilgisi INT,
>     kayit_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP,
>     FOREIGN KEY (musteri_id) REFERENCES musteriler(id) ON DELETE CASCADE
> );
> 
> CREATE TABLE tamir_islemleri (
>     id INT PRIMARY KEY AUTO_INCREMENT,
>     arac_id INT NOT NULL,
>     musteri_id INT NOT NULL,
>     kullanici_id INT NOT NULL,
>     baslik VARCHAR(200) NOT NULL,
>     aciklama TEXT,
>     durum ENUM('beklemede', 'devam_ediyor', 'tamamlandi') DEFAULT 'beklemede',
>     maliyet DECIMAL(10,2) DEFAULT 0.00,
>     kayit_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP,
>     guncellenme_tarihi DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
>     FOREIGN KEY (arac_id) REFERENCES araclar(id) ON DELETE CASCADE,
>     FOREIGN KEY (musteri_id) REFERENCES musteriler(id) ON DELETE CASCADE,
>     FOREIGN KEY (kullanici_id) REFERENCES kullanicilar(id)
> );
> ```

**Cevap:**

Aşağıda, verdiğiniz dört tabloya (`kullanicilar`, `musteriler`, `araclar`, `tamir_islemleri`) her biri için 50 örnek veri eklemek için SQL `INSERT` sorguları hazırladım. Veriler, tablo şemalarına uygun olarak gerçekçi ve Türkçe formatta oluşturuldu. Veriler rastgele ancak mantıklı olacak şekilde tasarlandı (örneğin, Türkiye’deki plaka formatları, TC kimlik numaraları, telefon numaraları). Ancak, bu veriler tamamen test amaçlıdır ve gerçek verilerle değiştirilmelidir.

### Önemli Notlar
- **TC Kimlik Numaraları**: Rastgele 11 haneli sayılar kullanıldı, ancak gerçek TC kimlik numarası algoritmasına uygun değil. Gerçek bir sistemde, geçerli TC kimlik numaraları kullanılmalı.
- **Telefon Numaraları**: Türkiye formatında (ör. 05XX XXX XX XX) rastgele numaralar üretildi.
- **Plakalar**: Türkiye plaka formatına uygun rastgele plakalar (ör. 34 ABC 123) oluşturuldu.
- **Foreign Key Kısıtlamaları**: `araclar` tablosunda `musteri_id`, `tamir_islemleri` tablosunda `arac_id`, `musteri_id` ve `kullanici_id` için geçerli ID’ler kullanıldı.
- **Veri Üretimi**: Her tablo için 50 veri eklendi, ancak `tamir_islemleri` tablosunda `durum` ve `maliyet` gibi alanlar için çeşitlilik sağlandı.
- **SQL Injection**: Veriler sabit ve güvenli bir şekilde yazıldı, ancak üretim ortamında prepared statements kullanmaya devam et.

### SQL Veri Ekleme Sorguları

#### 1. `kullanicilar` Tablosu (50 Veri)
```sql
INSERT INTO kullanicilar (kullanici_adi, email, sifre, ad_soyad, kayit_tarihi) VALUES
('ahmetyilmaz', 'ahmet.yilmaz@example.com', '$2y$10$examplehash1', 'Ahmet Yılmaz', '2025-01-01 10:00:00'),
('aysekaya', 'ayse.kaya@example.com', '$2y$10$examplehash2', 'Ayşe Kaya', '2025-01-02 11:00:00'),
('mehmetoz', 'mehmet.oz@example.com', '$2y$10$examplehash3', 'Mehmet Öz', '2025-01-03 12:00:00'),
('fatmacelik', 'fatma.celik@example.com', '$2y$10$examplehash4', 'Fatma Çelik', '2025-01-04 13:00:00'),
('mustafaerdem', 'mustafa.erdem@example.com', '$2y$10$examplehash5', 'Mustafa Erdem', '2025-01-05 14:00:00'),
('elifdemir', 'elif.demir@example.com', '$2y$10$examplehash6', 'Elif Demir', '2025-01-06 15:00:00'),
('canaksoy', 'can.aksoy@example.com', '$2y$10$examplehash7', 'Can Aksoy', '2025-01-07 16:00:00'),
('zeynepyildiz', 'zeynep.yildiz@example.com', '$2y$10$examplehash8', 'Zeynep Yıldız', '2025-01-08 17:00:00'),
('emreyilmaz', 'emre.yilmaz@example.com', '$2y$10$examplehash9', 'Emre Yılmaz', '2025-01-09 18:00:00'),
('selinyuce', 'selin.yuce@example.com', '$2y$10$examplehash10', 'Selin Yüce', '2025-01-10 19:00:00'),
('burakcetin', 'burak.cetin@example.com', '$2y$10$examplehash11', 'Burak Çetin', '2025-01-11 10:00:00'),
('nurcankara', 'nurcan.kara@example.com', '$2y$10$examplehash12', 'Nurcan Kara', '2025-01-12 11:00:00'),
('hasankoc', 'hasan.koc@example.com', '$2y$10$examplehash13', 'Hasan Koç', '2025-01-13 12:00:00'),
('esrayilmaz', 'esra.yilmaz@example.com', '$2y$10$examplehash14', 'Esra Yılmaz', '2025-01-14 13:00:00'),
('omerfaruk', 'omer.faruk@example.com', '$2y$10$examplehash15', 'Ömer Faruk', '2025-01-15 14:00:00'),
('aylinacar', 'aylin.acar@example.com', '$2y$10$examplehash16', 'Aylin Acar', '2025-01-16 15:00:00'),
('kemalozturk', 'kemal.ozturk@example.com', '$2y$10$examplehash17', 'Kemal Öztürk', '2025-01-17 16:00:00'),
('sibelkilic', 'sibel.kilic@example.com', '$2y$10$examplehash18', 'Sibel Kılıç', '2025-01-18 17:00:00'),
('yusufdemir', 'yusuf.demir@example.com', '$2y$10$examplehash19', 'Yusuf Demir', '2025-01-19 18:00:00'),
('eceaydin', 'ece.aydin@example.com', '$2y$10$examplehash20', 'Ece Aydın', '2025-01-20 19:00:00'),
('aliozturk', 'ali.ozturk@example.com', '$2y$10$examplehash21', 'Ali Öztürk', '2025-01-21 10:00:00'),
('meltemkaya', 'meltem.kaya@example.com', '$2y$10$examplehash22', 'Meltem Kaya', '2025-01-22 11:00:00'),
('bariserdogan', 'baris.erdogan@example.com', '$2y$10$examplehash23', 'Barış Erdoğan', '2025-01-23 12:00:00'),
('sevilayyilmaz', 'sevilay.yilmaz@example.com', '$2y$10$examplehash24', 'Sevilay Yılmaz', '2025-01-24 13:00:00'),
('muratcetin', 'murat.cetin@example.com', '$2y$10$examplehash25', 'Murat Çetin', '2025-01-25 14:00:00'),
('gulayoz', 'gulay.oz@example.com', '$2y$10$examplehash26', 'Gülay Öz', '2025-01-26 15:00:00'),
('tunckoc', 'tunc.koc@example.com', '$2y$10$examplehash27', 'Tunç Koç', '2025-01-27 16:00:00'),
('seymaaydin', 'seyma.aydin@example.com', '$2y$10$examplehash28', 'Şeyma Aydın', '2025-01-28 17:00:00'),
('erkansoyadı', 'erkan.soyadı@example.com', '$2y$10$examplehash29', 'Erkan Soyadı', '2025-01-29 18:00:00'),
('hulyakara', 'hulya.kara@example.com', '$2y$10$examplehash30', 'Hülya Kara', '2025-01-30 19:00:00'),
('cemalyilmaz', 'cemal.yilmaz@example.com', '$2y$10$examplehash31', 'Cemal Yılmaz', '2025-01-31 10:00:00'),
('aslihanacar', 'aslihan.acar@example.com', '$2y$10$examplehash32', 'Aslıhan Acar', '2025-02-01 11:00:00'),
('serkankilic', 'serkan.kilic@example.com', '$2y$10$examplehash33', 'Serkan Kılıç', '2025-02-02 12:00:00'),
('busedemir', 'buse.demir@example.com', '$2y$10$examplehash34', 'Buse Demir', '2025-02-03 13:00:00'),
('onurozturk', 'onur.ozturk@example.com', '$2y$10$examplehash35', 'Onur Öztürk', '2025-02-04 14:00:00'),
('sukrankaya', 'sukran.kaya@example.com', '$2y$10$examplehash36', 'Şükran Kaya', '2025-02-05 15:00:00'),
('halilyilmaz', 'halil.yilmaz@example.com', '$2y$10$examplehash37', 'Halil Yılmaz', '2025-02-06 16:00:00'),
('zuhalcetin', 'zuhal.cetin@example.com', '$2y$10$examplehash38', 'Zühal Çetin', '2025-02-07 17:00:00'),
('fatihoz', 'fatih.oz@example.com', '$2y$10$examplehash39', 'Fatih Öz', '2025-02-08 18:00:00'),
('gizemkoc', 'gizem.koc@example.com', '$2y$10$examplehash40', 'Gizem Koç', '2025-02-09 19:00:00'),
('alperaydin', 'alper.aydin@example.com', '$2y$10$examplehash41', 'Alper Aydın', '2025-02-10 10:00:00'),
('selmayilmaz', 'selma.yilmaz@example.com', '$2y$10$examplehash42', 'Selma Yılmaz', '2025-02-11 11:00:00'),
('yunusdemir', 'yunus.demir@example.com', '$2y$10$examplehash43', 'Yunus Demir', '2025-02-12 12:00:00'),
('esinkara', 'esin.kara@example.com', '$2y$10$examplehash44', 'Esin Kara', '2025-02-13 13:00:00'),
('metinacar', 'metin.acar@example.com', '$2y$10$examplehash45', 'Metin Acar', '2025-02-14 14:00:00'),
('aycaozturk', 'ayca.ozturk@example.com', '$2y$10$examplehash46', 'Ayça Öztürk', '2025-02-15 15:00:00'),
('hakanerdogan', 'hakan.erdogan@example.com', '$2y$10$examplehash47', 'Hakan Erdoğan', '2025-02-16 16:00:00'),
('nuriyilmaz', 'nuri.yilmaz@example.com', '$2y$10$examplehash48', 'Nuri Yılmaz', '2025-02-17 17:00:00'),
('seherkilic', 'seher.kilic@example.com', '$2y$10$examplehash49', 'Seher Kılıç', '2025-02-18 18:00:00'),
('vedatcetin', 'vedat.cetin@example.com', '$2y$10$examplehash50', 'Vedat Çetin', '2025-02-19 19:00:00');
```

**Not**: `sifre` için `$2y$10$examplehashX` kullanıldı. Gerçek bir uygulamada, `password_hash()` ile gerçek şifreler hash’lenmeli.

#### 2. `musteriler` Tablosu (50 Veri)
```sql
INSERT INTO musteriler (ad_soyad, telefon, email, adres, tc_no, kayit_tarihi) VALUES
('Ali Veli', '05321234567', 'ali.veli@example.com', 'İstanbul, Kadıköy', '12345678901', '2025-01-01 10:00:00'),
('Ayşe Fatma', '05431234567', 'ayse.fatma@example.com', 'Ankara, Çankaya', '23456789012', '2025-01-02 11:00:00'),
('Mehmet Can', '05551234567', 'mehmet.can@example.com', 'İzmir, Bornova', '34567890123', '2025-01-03 12:00:00'),
('Fatma Nur', '05331234567', 'fatma.nur@example.com', 'Bursa, Nilüfer', '45678901234', '2025-01-04 13:00:00'),
('Mustafa Kemal', '05441234567', 'mustafa.kemal@example.com', 'Antalya, Muratpaşa', '56789012345', '2025-01-05 14:00:00'),
('Elif Su', '05561234567', 'elif.su@example.com', 'Adana, Seyhan', '67890123456', '2025-01-06 15:00:00'),
('Can Efe', '05341234567', 'can.efe@example.com', 'Eskişehir, Odunpazarı', '78901234567', '2025-01-07 16:00:00'),
('Zeynep Ada', '05451234567', 'zeynep.ada@example.com', 'Konya, Selçuklu', '89012345678', '2025-01-08 17:00:00'),
('Emre Mert', '05571234567', 'emre.mert@example.com', 'İzmir, Karşıyaka', '90123456789', '2025-01-09 18:00:00'),
('Selin Duru', '05351234567', 'selin.duru@example.com', 'Ankara, Keçiören', '01234567890', '2025-01-10 19:00:00'),
('Burak Deniz', '05461234567', 'burak.deniz@example.com', 'İstanbul, Beşiktaş', '12345678902', '2025-01-11 10:00:00'),
('Nurcan Ece', '05581234567', 'nurcan.ece@example.com', 'Bursa, Osmangazi', '23456789013', '2025-01-12 11:00:00'),
('Hasan Hüseyin', '05361234567', 'hasan.huseyin@example.com', 'Antalya, Konyaaltı', '34567890124', '2025-01-13 12:00:00'),
('Esra Naz', '05471234567', 'esra.naz@example.com', 'İzmir, Buca', '45678901235', '2025-01-14 13:00:00'),
('Ömer Faruk', '05591234567', 'omer.faruk@example.com', 'Ankara, Yenimahalle', '56789012346', '2025-01-15 14:00:00'),
('Aylin Beren', '05371234567', 'aylin.beren@example.com', 'İstanbul, Şişli', '67890123457', '2025-01-16 15:00:00'),
('Kemal Bora', '05481234567', 'kemal.bora@example.com', 'Adana, Çukurova', '78901234568', '2025-01-17 16:00:00'),
('Sibel Arda', '05501234567', 'sibel.arda@example.com', 'Bursa, Yıldırım', '89012345679', '2025-01-18 17:00:00'),
('Yusuf Efe', '05381234567', 'yusuf.efe@example.com', 'Konya, Meram', '90123456780', '2025-01-19 18:00:00'),
('Ece Duru', '05491234567', 'ece.duru@example.com', 'İstanbul, Bakırköy', '01234567891', '2025-01-20 19:00:00'),
('Ali Mert', '05511234567', 'ali.mert@example.com', 'Ankara, Mamak', '12345678903', '2025-01-21 10:00:00'),
('Meltem Su', '05391234567', 'meltem.su@example.com', 'İzmir, Konak', '23456789014', '2025-01-22 11:00:00'),
('Barış Can', '05401234567', 'baris.can@example.com', 'Bursa, Gürsu', '34567890125', '2025-01-23 12:00:00'),
('Sevilay Naz', '05521234567', 'sevilay.naz@example.com', 'Antalya, Kepez', '45678901236', '2025-01-24 13:00:00'),
('Murat Efe', '05301234567', 'murat.efe@example.com', 'Adana, Yüreğir', '56789012347', '2025-01-25 14:00:00'),
('Gülay Ada', '05411234567', 'gulay.ada@example.com', 'Eskişehir, Tepebaşı', '67890123458', '2025-01-26 15:00:00'),
('Tunç Mert', '05531234567', 'tunc.mert@example.com', 'Konya, Karatay', '78901234569', '2025-01-27 16:00:00'),
('Şeyma Beren', '05311234567', 'seyma.beren@example.com', 'İstanbul, Üsküdar', '89012345670', '2025-01-28 17:00:00'),
('Erkan Bora', '05421234567', 'erkan.bora@example.com', 'Ankara, Etimesgut', '90123456781', '2025-01-29 18:00:00'),
('Hülya Arda', '05541234567', 'hulya.arda@example.com', 'İzmir, Bayraklı', '01234567892', '2025-01-30 19:00:00'),
('Cemal Efe', '05321234568', 'cemal.efe@example.com', 'Bursa, Kestel', '12345678904', '2025-01-31 10:00:00'),
('Aslıhan Su', '05431234568', 'aslihan.su@example.com', 'Antalya, Döşemealtı', '23456789015', '2025-02-01 11:00:00'),
('Serkan Can', '05551234568', 'serkan.can@example.com', 'Adana, Kozan', '34567890126', '2025-02-02 12:00:00'),
('Buse Naz', '05331234568', 'buse.naz@example.com', 'İstanbul, Beyoğlu', '45678901237', '2025-02-03 13:00:00'),
('Onur Mert', '05441234568', 'onur.mert@example.com', 'Ankara, Sincan', '56789012348', '2025-02-04 14:00:00'),
('Şükran Ada', '05561234568', 'sukran.ada@example.com', 'İzmir, Çiğli', '67890123459', '2025-02-05 15:00:00'),
('Halil Efe', '05341234568', 'halil.efe@example.com', 'Bursa, Mudanya', '78901234560', '2025-02-06 16:00:00'),
('Zühal Su', '05451234568', 'zuhal.su@example.com', 'Antalya, Aksu', '89012345671', '2025-02-07 17:00:00'),
('Fatih Can', '05571234568', 'fatih.can@example.com', 'Adana, Sarıçam', '90123456782', '2025-02-08 18:00:00'),
('Gizem Naz', '05351234568', 'gizem.naz@example.com', 'İstanbul, Ataşehir', '01234567893', '2025-02-09 19:00:00'),
('Alper Mert', '05461234568', 'alper.mert@example.com', 'Ankara, Gölbaşı', '12345678905', '2025-02-10 10:00:00'),
('Selma Ada', '05581234568', 'selma.ada@example.com', 'İzmir, Menemen', '23456789016', '2025-02-11 11:00:00'),
('Yunus Efe', '05361234568', 'yunus.efe@example.com', 'Bursa, İnegöl', '34567890127', '2025-02-12 12:00:00'),
('Esin Su', '05471234568', 'esin.su@example.com', 'Antalya, Manavgat', '45678901238', '2025-02-13 13:00:00'),
('Metin Can', '05591234568', 'metin.can@example.com', 'Adana, Ceyhan', '56789012349', '2025-02-14 14:00:00'),
('Ayça Naz', '05371234568', 'ayca.naz@example.com', 'İstanbul, Maltepe', '67890123450', '2025-02-15 15:00:00'),
('Hakan Mert', '05481234568', 'hakan.mert@example.com', 'Ankara, Pursaklar', '78901234561', '2025-02-16 16:00:00'),
('Nuri Ada', '05501234568', 'nuri.ada@example.com', 'İzmir, Torbalı', '89012345672', '2025-02-17 17:00:00'),
('Seher Efe', '05381234568', 'seher.efe@example.com', 'Bursa, Gemlik', '90123456783', '2025-02-18 18:00:00'),
('Vedat Can', '05491234568', 'vedat.can@example.com', 'Antalya, Alanya', '01234567894', '2025-02-19 19:00:00');
```

#### 3. `araclar` Tablosu (50 Veri)
```sql
INSERT INTO araclar (musteri_id, marka, model, yil, plaka, renk, motor_no, sasi_no, km_bilgisi, kayit_tarihi) VALUES
(1, 'Toyota', 'Corolla', 2018, '34 ABC 123', 'Beyaz', 'MTR123456', 'SASI123456', 120000, '2025-01-01 10:00:00'),
(2, 'Honda', 'Civic', 2020, '06 DEF 456', 'Siyah', 'MTR234567', 'SASI234567', 80000, '2025-01-02 11:00:00'),
(3, 'Ford', 'Focus', 2019, '35 GHI 789', 'Gri', 'MTR345678', 'SASI345678', 95000, '2025-01-03 12:00:00'),
(4, 'Renault', 'Megane', 2017, '16 JKL 012', 'Kırmızı', 'MTR456789', 'SASI456789', 140000, '2025-01-04 13:00:00'),
(5, 'Volkswagen', 'Passat', 2021, '07 MNO 345', 'Mavi', 'MTR567890', 'SASI567890', 60000, '2025-01-05 14:00:00'),
(6, 'Hyundai', 'Tucson', 2016, '34 PQR 678', 'Siyah', 'MTR678901', 'SASI678901', 160000, '2025-01-06 15:00:00'),
(7, 'BMW', '3 Serisi', 2022, '06 STU 901', 'Beyaz', 'MTR789012', 'SASI789012', 45000, '2025-01-07 16:00:00'),
(8, 'Mercedes', 'C Serisi', 2020, '35 VWX 234', 'Gri', 'MTR890123', 'SASI890123', 70000, '2025-01-08 17:00:00'),
(9, 'Audi', 'A3', 2019, '16 YZA 567', 'Kırmızı', 'MTR901234', 'SASI901234', 85000, '2025-01-09 18:00:00'),
(10, 'Fiat', 'Egea', 2018, '34 BCD 890', 'Mavi', 'MTR012345', 'SASI012345', 110000, '2025-01-10 19:00:00'),
(11, 'Opel', 'Astra', 2017, '06 EFG 123', 'Beyaz', 'MTR123457', 'SASI123457', 130000, '2025-01-11 10:00:00'),
(12, 'Peugeot', '308', 2021, '35 HIJ 456', 'Siyah', 'MTR234568', 'SASI234568', 55000, '2025-01-12 11:00:00'),
(13, 'Citroen', 'C3', 2019, '16 KLM 789', 'Gri', 'MTR345679', 'SASI345679', 90000, '2025-01-13 12:00:00'),
(14, 'Skoda', 'Octavia', 2020, '07 NOP 012', 'Kırmızı', 'MTR456780', 'SASI456780', 75000, '2025-01-14 13:00:00'),
(15, 'Seat', 'Leon', 2018, '34 QRS 345', 'Mavi', 'MTR567891', 'SASI567891', 100000, '2025-01-15 14:00:00'),
(16, 'Kia', 'Sportage', 2016, '06 TUV 678', 'Beyaz', 'MTR678902', 'SASI678902', 150000, '2025-01-16 15:00:00'),
(17, 'Nissan', 'Qashqai', 2022, '35 WXY 901', 'Siyah', 'MTR789013', 'SASI789013', 40000, '2025-01-17 16:00:00'),
(18, 'Dacia', 'Duster', 2019, '16 ZAB 234', 'Gri', 'MTR890124', 'SASI890124', 95000, '2025-01-18 17:00:00'),
(19, 'Mazda', 'CX-5', 2020, '34 CDE 567', 'Kırmızı', 'MTR901235', 'SASI901235', 70000, '2025-01-19 18:00:00'),
(20, 'Suzuki', 'Vitara', 2018, '06 FGH 890', 'Mavi', 'MTR012346', 'SASI012346', 110000, '2025-01-20 19:00:00'),
(21, 'Toyota', 'Yaris', 2017, '35 IJK 123', 'Beyaz', 'MTR123458', 'SASI123458', 120000, '2025-01-21 10:00:00'),
(22, 'Honda', 'CR-V', 2021, '16 LMN 456', 'Siyah', 'MTR234569', 'SASI234569', 60000, '2025-01-22 11:00:00'),
(23, 'Ford', 'Fiesta', 2019, '07 OPQ 789', 'Gri', 'MTR345680', 'SASI345680', 85000, '2025-01-23 12:00:00'),
(24, 'Renault', 'Clio', 2018, '34 RST 012', 'Kırmızı', 'MTR456781', 'SASI456781', 100000, '2025-01-24 13:00:00'),
(25, 'Volkswagen', 'Golf', 2020, '06 UVW 345', 'Mavi', 'MTR567892', 'SASI567892', 75000, '2025-01-25 14:00:00'),
(26, 'Hyundai', 'i20', 2016, '35 XYZ 678', 'Beyaz', 'MTR678903', 'SASI678903', 140000, '2025-01-26 15:00:00'),
(27, 'BMW', '5 Serisi', 2022, '16 ABC 901', 'Siyah', 'MTR789014', 'SASI789014', 45000, '2025-01-27 16:00:00'),
(28, 'Mercedes', 'E Serisi', 2020, '34 DEF 234', 'Gri', 'MTR890125', 'SASI890125', 70000, '2025-01-28 17:00:00'),
(29, 'Audi', 'A4', 2019, '06 GHI 567', 'Kırmızı', 'MTR901236', 'SASI901236', 85000, '2025-01-29 18:00:00'),
(30, 'Fiat', 'Panda', 2018, '35 JKL 890', 'Mavi', 'MTR012347', 'SASI012347', 110000, '2025-01-30 19:00:00'),
(31, 'Opel', 'Corsa', 2017, '16 MNO 123', 'Beyaz', 'MTR123459', 'SASI123459', 120000, '2025-01-31 10:00:00'),
(32, 'Peugeot', '208', 2021, '07 PQR 456', 'Siyah', 'MTR234570', 'SASI234570', 60000, '2025-02-01 11:00:00'),
(33, 'Citroen', 'C4', 2019, '34 STU 789', 'Gri', 'MTR345681', 'SASI345681', 85000, '2025-02-02 12:00:00'),
(34, 'Skoda', 'Superb', 2020, '06 VWX 012', 'Kırmızı', 'MTR456782', 'SASI456782', 75000, '2025-02-03 13:00:00'),
(35, 'Seat', 'Ibiza', 2018, '35 YZA 345', 'Mavi', 'MTR567893', 'SASI567893', 100000, '2025-02-04 14:00:00'),
(36, 'Kia', 'Rio', 2016, '16 BCD 678', 'Beyaz', 'MTR678904', 'SASI678904', 140000, '2025-02-05 15:00:00'),
(37, 'Nissan', 'Juke', 2022, '34 EFG 901', 'Siyah', 'MTR789015', 'SASI789015', 45000, '2025-02-06 16:00:00'),
(38, 'Dacia', 'Sandero', 2019, '06 HIJ 234', 'Gri', 'MTR890126', 'SASI890126', 85000, '2025-02-07 17:00:00'),
(39, 'Mazda', '3', 2020, '35 KLM 567', 'Kırmızı', 'MTR901237', 'SASI901237', 70000, '2025-02-08 18:00:00'),
(40, 'Suzuki', 'Swift', 2018, '16 NOP 890', 'Mavi', 'MTR012348', 'SASI012348', 110000, '2025-02-09 19:00:00'),
(41, 'Toyota', 'RAV4', 2017, '34 QRS 123', 'Beyaz', 'MTR123460', 'SASI123460', 120000, '2025-02-10 10:00:00'),
(42, 'Honda', 'HR-V', 2021, '06 TUV 456', 'Siyah', 'MTR234571', 'SASI234571', 60000, '2025-02-11 11:00:00'),
(43, 'Ford', 'Kuga', 2019, '35 WXY 789', 'Gri', 'MTR345682', 'SASI345682', 85000, '2025-02-12 12:00:00'),
(44, 'Renault', 'Captur', 2018, '16 ZAB 012', 'Kırmızı', 'MTR456783', 'SASI456783', 100000, '2025-02-13 13:00:00'),
(45, 'Volkswagen', 'Tiguan', 2020, '34 CDE 345', 'Mavi', 'MTR567894', 'SASI567894', 75000, '2025-02-14 14:00:00'),
(46, 'Hyundai', 'Santa Fe', 2016, '06 FGH 678', 'Beyaz', 'MTR678905', 'SASI678905', 140000, '2025-02-15 15:00:00'),
(47, 'BMW', 'X5', 2022, '35 IJK 901', 'Siyah', 'MTR789016', 'SASI789016', 45000, '2025-02-16 16:00:00'),
(48, 'Mercedes', 'GLC', 2020, '16 LMN 234', 'Gri', 'MTR890127', 'SASI890127', 70000, '2025-02-17 17:00:00'),
(49, 'Audi', 'Q5', 2019, '34 OPQ 567', 'Kırmızı', 'MTR901238', 'SASI901238', 85000, '2025-02-18 18:00:00'),
(50, 'Fiat', '500', 2018, '06 RST 890', 'Mavi', 'MTR012349', 'SASI012349', 110000, '2025-02-19 19:00:00');
```

#### 4. `tamir_islemleri` Tablosu (50 Veri)
```sql
INSERT INTO tamir_islemleri (arac_id, musteri_id, kullanici_id, baslik, aciklama, durum, maliyet, kayit_tarihi) VALUES
(1, 1, 1, 'Fren Balatası Değişimi', 'Ön fren balataları değiştirildi.', 'tamamlandi', 1500.00, '2025-01-01 10:00:00'),
(2, 2, 2, 'Yağ Değişimi', 'Motor yağı ve filtre değişimi yapıldı.', 'tamamlandi', 800.00, '2025-01-02 11:00:00'),
(3, 3, 3, 'Lastik Değişimi', 'Dört lastik yenilendi.', 'devam_ediyor', 3000.00, '2025-01-03 12:00:00'),
(4, 4, 4, 'Akü Değişimi', 'Akü arızalı, yeni akü takıldı.', 'tamamlandi', 1200.00, '2025-01-04 13:00:00'),
(5, 5, 5, 'Triger Kayışı Değişimi', 'Triger kayışı ve gergi seti değiştirildi.', 'beklemede', 2500.00, '2025-01-05 14:00:00'),
(6, 6, 6, 'Debriyaj Tamiri', 'Debriyaj balatası değiştirildi.', 'tamamlandi', 4000.00, '2025-01-06 15:00:00'),
(7, 7, 7, 'Egzoz Tamiri', 'Egzoz borusu değiştirildi.', 'devam_ediyor', 1800.00, '2025-01-07 16:00:00'),
(8, 8, 8, 'Far Ayarı', 'Ön farlar ayarlandı.', 'tamamlandi', 500.00, '2025-01-08 17:00:00'),
(9, 9, 9, 'Klima Gazı Dolumu', 'Klima gazı dolduruldu.', 'tamamlandi', 600.00, '2025-01-09 18:00:00'),
(10, 10, 10, 'Rot Balans Ayarı', 'Rot ve balans ayarı yapıldı.', 'tamamlandi', 400.00, '2025-01-10 19:00:00'),
(11, 11, 11, 'Süspansiyon Tamiri', 'Ön süspansiyon tamir edildi.', 'devam_ediyor', 2200.00, '2025-01-11 10:00:00'),
(12, 12, 12, 'Motor Temizliği', 'Motor temizliği yapıldı.', 'tamamlandi', 700.00, '2025-01-12 11:00:00'),
(13, 13, 13, 'Buji Değişimi', 'Bujiler yenilendi.', 'tamamlandi', 900.00, '2025-01-13 12:00:00'),
(14, 14, 14, 'Radyatör Tamiri', 'Radyatör sızıntısı giderildi.', 'beklemede', 1500.00, '2025-01-14 13:00:00'),
(15, 15, 15, 'Direksiyon Kutusu Tamiri', 'Direksiyon kutusu tamir edildi.', 'tamamlandi', 3000.00, '2025-01-15 14:00:00'),
(16, 16, 16, 'Fren Diski Değişimi', 'Ön fren diskleri değiştirildi.', 'devam_ediyor', 2000.00, '2025-01-16 15:00:00'),
(17, 17, 17, 'Yağ Filtresi Değişimi', 'Yağ filtresi yenilendi.', 'tamamlandi', 300.00, '2025-01-17 16:00:00'),
(18, 18, 18, 'Kaporta Onarımı', 'Sol kapıdaki çizik onarıldı.', 'tamamlandi', 2500.00, '2025-01-18 17:00:00'),
(19, 19, 19, 'Boyama', 'Arka tampon boyandı.', 'devam_ediyor', 2000.00, '2025-01-19 18:00:00'),
(20, 20, 20, 'Cam Değişimi', 'Ön cam değiştirildi.', 'tamamlandi', 1800.00, '2025-01-20 19:00:00'),
(21, 21, 21, 'Fren Hidroliği Değişimi', 'Fren hidroliği yenilendi.', 'tamamlandi', 600.00, '2025-01-21 10:00:00'),
(22, 22, 22, 'Vites Kutusu Tamiri', 'Vites kutusu onarıldı.', 'beklemede', 3500.00, '2025-01-22 11:00:00'),
(23, 23, 23, 'Turbo Tamiri', 'Turbo sistemi tamir edildi.', 'devam_ediyor', 4500.00, '2025-01-23 12:00:00'),
(24, 24, 24, 'Hava Filtresi Değişimi', 'Hava filtresi yenilendi.', 'tamamlandi', 400.00, '2025-01-24 13:00:00'),
(25, 25, 25, 'Yakıt Pompası Değişimi', 'Yakıt pompası değiştirildi.', 'tamamlandi', 2000.00, '2025-01-25 14:00:00'),
(26, 26, 26, 'Soğutma Sistemi Tamiri', 'Soğutma sistemi onarıldı.', 'devam_ediyor', 1500.00, '2025-01-26 15:00:00'),
(27, 27, 27, 'Elektronik Arıza Tespiti', 'Elektronik sistem kontrol edildi.', 'tamamlandi', 800.00, '2025-01-27 16:00:00'),
(28, 28, 28, 'Şanzıman Yağı Değişimi', 'Şanzıman yağı yenilendi.', 'tamamlandi', 1200.00, '2025-01-28 17:00:00'),
(29, 29, 29, 'Katalitik Konvertör Tamiri', 'Katalitik konvertör onarıldı.', 'beklemede', 3000.00, '2025-01-29 18:00:00'),
(30, 30, 30, 'Fren Kaliperi Tamiri', 'Fren kaliperi tamir edildi.', 'tamamlandi', 1800.00, '2025-01-30 19:00:00'),
(31, 31, 31, 'Silecek Değişimi', 'Silecekler yenilendi.', 'tamamlandi', 300.00, '2025-01-31 10:00:00'),
(32, 32, 32, 'Amortisör Değişimi', 'Ön amortisörler değiştirildi.', 'devam_ediyor', 2500.00, '2025-02-01 11:00:00'),
(33, 33, 33, 'Yağ Kaçağı Onarımı', 'Yağ kaçağı giderildi.', 'tamamlandi', 1000.00, '2025-02-02 12:00:00'),
(34, 34, 34, 'Koltuk Döşeme Onarımı', 'Sürücü koltuğu döşemesi tamir edildi.', 'tamamlandi', 1500.00, '2025-02-03 13:00:00'),
(35, 35, 35, 'Direksiyon Simidi Değişimi', 'Direksiyon simidi yenilendi.', 'beklemede', 2000.00, '2025-02-04 14:00:00'),
(36, 36, 36, 'Egzoz Susturucu Değişimi', 'Susturucu değiştirildi.', 'tamamlandi', 1200.00, '2025-02-05 15:00:00'),
(37, 37, 37, 'Far Temizliği', 'Farlar temizlendi.', 'tamamlandi', 500.00, '2025-02-06 16:00:00'),
(38, 38, 38, 'Klima Kompresörü Tamiri', 'Klima kompresörü onarıldı.', 'devam_ediyor', 2500.00, '2025-02-07 17:00:00'),
(39, 39, 39, 'Rotil Değişimi', 'Ön rotiller değiştirildi.', 'tamamlandi', 800.00, '2025-02-08 18:00:00'),
(40, 40, 40, 'Yakıt Filtresi Değişimi', 'Yakıt filtresi yenilendi.', 'tamamlandi', 600.00, '2025-02-09 19:00:00'),
(41, 41, 41, 'Kapı Kolu Tamiri', 'Sağ kapı kolu tamir edildi.', 'tamamlandi', 700.00, '2025-02-10 10:00:00'),
(42, 42, 42, 'Motor Kontrolü', 'Motor genel kontrolü yapıldı.', 'beklemede', 1000.00, '2025-02-11 11:00:00'),
(43, 43, 43, 'Fren Hortumu Değişimi', 'Fren hortumları yenilendi.', 'tamamlandi', 900.00, '2025-02-12 12:00:00'),
(44, 44, 44, 'Cam Suyu Motoru Tamiri', 'Cam suyu motoru onarıldı.', 'tamamlandi', 400.00, '2025-02-13 13:00:00'),
(45, 45, 45, 'V Kayışı Değişimi', 'V kayışı yenilendi.', 'tamamlandi', 600.00, '2025-02-14 14:00:00'),
(46, 46, 46, 'Radyo Anteni Değişimi', 'Radyo anteni değiştirildi.', 'tamamlandi', 300.00, '2025-02-15 15:00:00'),
(47, 47, 47, 'Egzoz Manifoldu Tamiri', 'Egzoz manifoldu onarıldı.', 'devam_ediyor', 2000.00, '2025-02-16 16:00:00'),
(48, 48, 48, 'Fren Sensörü Değişimi', 'Fren sensörü yenilendi.', 'tamamlandi', 800.00, '2025-02-17 17:00:00'),
(49, 49, 49, 'Kaporta Boyama', 'Ön kaput boyandı.', 'tamamlandi', 2500.00, '2025-02-18 18:00:00'),
(50, 50, 50, 'Ayna Değişimi', 'Sağ ayna değiştirildi.', 'tamamlandi', 600.00, '2025-02-19 19:00:00');
```

### Uygulama Talimatları
1. **Veritabanına Ekleme**:
   - Yukarıdaki SQL sorgularını bir SQL istemcisinde (ör. phpMyAdmin, MySQL Workbench) veya PHP kodu ile çalıştırabilirsiniz.
   - Tabloları sırayla ekleyin: önce `kullanicilar`, sonra `musteriler`, ardından `araclar`, ve son olarak `tamir_islemleri`. Bu sırayı takip etmek, foreign key kısıtlamaları nedeniyle önemlidir.

2. **PHP ile Çalıştırma (Örnek)**:
   ```php
   <?php
   require_once '../../config/database.php';

   $sql = "INSERT INTO kullanicilar ..."; // Yukarıdaki SQL'leri buraya yapıştırın
   $pdo->exec($sql);
   echo "Veriler eklendi!";
   ?>
   ```

3. **Dikkat Edilmesi Gerekenler**:
   - `sifre` alanları için gerçek uygulamada `password_hash()` ile şifreleri hash’leyin.
   - Veritabanında aynı `plaka` veya `email` gibi UNIQUE alanlar zaten varsa, ekleme işlemi hata verebilir. Veritabanını sıfırlamak için önce `TRUNCATE TABLE` veya `DROP TABLE` komutlarını kullanabilirsiniz.
   - Tarihler test amaçlı geçmiş tarihler (Ocak-Şubat 2025) olarak ayarlandı. İsterseniz `CURRENT_TIMESTAMP` kullanabilirsiniz.



**Soru:** Veritabanındaki tamir_islemleri tablosunda musteri_id ve arac_id ilişkileri var. Bu yapı doğru mu, yoksa sadece arac_id yeterli olur muydu?

**Cevap:** Her tamir işleminde musteri_id'nin de tutulması, aşağıdaki avantajları sağlar:
1. Hızlı müşteri sorgulaması (join işlemi azalır)
2. Veri bütünlüğü kontrolü
3. Araç satışı durumunda geçmiş tamir kayıtlarının korunması
4. Raporlama işlemlerinde kolaylık

Örnek sorgu:
```sql
SELECT t.*, m.ad_soyad, a.plaka 
FROM tamir_islemleri t
JOIN musteriler m ON t.musteri_id = m.id
JOIN araclar a ON t.arac_id = a.id
WHERE t.musteri_id = ?
```


**Soru:** Sistemde kullanıcı rollerinin olmaması bir eksiklik mi? Örneğin yönetici ve teknisyen rolleri eklemeli miyim?

**Cevap:** Evet, rol yapısı eklenebilir. Örnek implementasyon:

```sql
ALTER TABLE kullanicilar
ADD COLUMN rol ENUM('admin', 'teknisyen') DEFAULT 'teknisyen';
```

Ve PHP tarafında:
```php
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Sayfalarda kullanımı
if (!isAdmin()) {
    header('Location: unauthorized.php');
    exit;
}
```


**Soru:** Tamir işlemlerinin durumunu gösteren kartlarda renk kodlaması nasıl yapılabilir?

**Cevap:** Bootstrap renk sınıflarıyla durum gösterimi:

```php
<?php
$durum_renkleri = [
    'beklemede' => 'bg-warning',
    'devam_ediyor' => 'bg-info',
    'tamamlandi' => 'bg-success'
];
?>

<div class="card <?php echo $durum_renkleri[$tamir['durum']]; ?>">
    <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($tamir['baslik']); ?></h5>
        <p class="card-text">Durum: <?php echo ucfirst($tamir['durum']); ?></p>
    </div>
</div>
```



**Soru:** Araç plakası için Türkiye standartlarına uygun validasyon nasıl yapılabilir?

**Cevap:** Regex ile plaka kontrolü:

```php
function validateTurkishPlate($plaka) {
    // 34ABC123, 34AB123, 34A1234 formatları için
    $pattern = '/^(0[1-9]|[1-7][0-9]|8[0-1])(([A-Z])(\d{4,5})|([A-Z]{2})(\d{3,4})|([A-Z]{3})(\d{2,3}))$/';
    return preg_match($pattern, str_replace(' ', '', strtoupper($plaka)));
}

// Kullanımı
if (!validateTurkishPlate($plaka)) {
    $error = 'Geçersiz plaka formatı';
}
```



**Soru:** Dashboard için aylık tamir istatistikleri nasıl gösterebilirim?

**Cevap:** Aylık istatistikler için SQL sorgusu:

```php
// SQL Sorgusu
$sql = "SELECT 
    DATE_FORMAT(kayit_tarihi, '%Y-%m') as ay,
    COUNT(*) as toplam_tamir,
    SUM(CASE WHEN durum = 'tamamlandi' THEN 1 ELSE 0 END) as tamamlanan,
    AVG(maliyet) as ortalama_maliyet
FROM tamir_islemleri
GROUP BY DATE_FORMAT(kayit_tarihi, '%Y-%m')
ORDER BY ay DESC
LIMIT 12";

// Sonuçları tabloda gösterme
echo "<table class='table'>";
echo "<tr><th>Ay</th><th>Toplam Tamir</th><th>Tamamlanan</th><th>Ort. Maliyet</th></tr>";
foreach ($sonuclar as $row) {
    echo "<tr>";
    echo "<td>" . date('F Y', strtotime($row['ay'] . '-01')) . "</td>";
    echo "<td>" . $row['toplam_tamir'] . "</td>";
    echo "<td>" . $row['tamamlanan'] . "</td>";
    echo "<td>₺" . number_format($row['ortalama_maliyet'], 2) . "</td>";
    echo "</tr>";
}
echo "</table>";
```


**Soru:** Tamir listesi sayfasında performans nasıl artırılabilir?

**Cevap:** Birkaç optimizasyon önerisi:

1. Sayfalama implementasyonu:
```php
$sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
$limit = 10;
$offset = ($sayfa - 1) * $limit;

$sql = "SELECT t.*, m.ad_soyad, a.plaka 
        FROM tamir_islemleri t
        JOIN musteriler m ON t.musteri_id = m.id
        JOIN araclar a ON t.arac_id = a.id
        ORDER BY t.kayit_tarihi DESC
        LIMIT ? OFFSET ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$limit, $offset]);
```

2. Index'leme önerisi:
```sql
ALTER TABLE tamir_islemleri ADD INDEX idx_tarih_durum (kayit_tarihi, durum);
```


**Soru:** Araç seçimi nasıl daha kullanıcı dostu hale getirilebilir?

**Cevap:** Select2 kütüphanesi ile gelişmiş seçim:

```html
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<select class="select2" name="arac_id">
    <?php foreach ($araclar as $arac): ?>
        <option value="<?= $arac['id'] ?>">
            <?= htmlspecialchars($arac['plaka'] . ' - ' . $arac['marka'] . ' ' . $arac['model']) ?>
        </option>
    <?php endforeach; ?>
</select>

<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: 'Araç seçiniz...',
        allowClear: true
    });
});
</script>
```

**Soru:** Dashboard sayfasındaki menü yapısını nasıl daha modern hale getirebilirim?

**Cevap:** Bootstrap 5 ile modern menü tasarımı:

```html
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-wrench"></i> Tamirhane
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo $page == 'dashboard' ? 'active' : ''; ?>" href="dashboard.php">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-car"></i> Araçlar
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="araclar/liste.php">Araç Listesi</a></li>
                        <li><a class="dropdown-item" href="araclar/ekle.php">Yeni Araç Ekle</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="auth/profil.php">
                        <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="auth/logout.php">
                        <i class="fas fa-sign-out-alt"></i> Çıkış
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
```


**Soru:** Dashboard'da istatistikleri nasıl gösterebilirim?

**Cevap:** Modern dashboard kartları:

```html
<div class="row g-4 mb-4">
    <!-- İstatistik Kartları -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-lg bg-primary-subtle">
                            <i class="fas fa-tools fa-lg text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Aktif Tamirler</h6>
                        <h3 class="mb-0"><?php echo $aktif_tamir_sayisi; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Grafik Kartı -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">Aylık Tamir İstatistikleri</h5>
            </div>
            <div class="card-body">
                <canvas id="tamirGrafigi"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
// Chart.js ile grafik
const ctx = document.getElementById('tamirGrafigi').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran'],
        datasets: [{
            label: 'Tamamlanan Tamirler',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
```

**Soru:** SQL injection koruması için prepared statements nedir, ne işe yarar?

**Cevap:**

SQL injection, kötü niyetli kullanıcıların bir web uygulamasındaki giriş alanlarına zararlı SQL kodları ekleyerek veritabanında istenmeyen işlemler yapmasına olanak tanıyan bir güvenlik açığıdır. Örneğin, bir giriş alanına `'; DROP TABLE users; --` yazıldığında, bu kod veritabanında çalışabilir ve ciddi zararlara yol açabilir.

**Prepared Statements (Hazırlanmış İfadeler)**, SQL injection saldırılarını önlemek için kullanılan bir yöntemdir. Bu teknik, SQL sorgusunu ve kullanıcıdan gelen veriyi birbirinden ayırır. Veritabanı motoru, kullanıcı girişlerini SQL kodu olarak değil, yalnızca veri olarak işler, böylece zararlı kodların çalışması engellenir. PHP'de genellikle PDO (PHP Data Objects) veya MySQLi kütüphaneleriyle kullanılır.

### Prepared Statements Nasıl Çalışır?
1. **Sorgu Şablonu Hazırlanır**: SQL sorgusu, kullanıcı verilerinin yerini tutacak yer tutucular (`?` veya isimlendirilmiş `:param`) ile oluşturulur.
2. **Veriler Bağlanır**: Kullanıcıdan gelen veriler, sorguya güvenli bir şekilde bağlanır (bind edilir).
3. **Sorgu Yürütülür**: Veritabanı, sorguyu ve verileri ayrı ayrı işleyerek güvenli bir işlem gerçekleştirir.

### Örnek Kodlar

#### PDO ile Prepared Statements
```php
<?php
$host = 'localhost';
$dbname = 'veritabani';
$username = 'kullanici';
$password = 'sifre';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sorgu şablonu
    $stmt = $pdo->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ? AND sifre = ?");
    
    // Verileri bağla
    $kullanici_adi = $_POST['kullanici_adi'];
    $sifre = $_POST['sifre'];
    $stmt->execute([$kullanici_adi, $sifre]);

    // Sonuçları al
    $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($kullanici) {
        echo "Giriş başarılı!";
    } else {
        echo "Geçersiz kullanıcı adı veya şifre.";
    }
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
```

#### İsimlendirilmiş Parametreler ile PDO
```php
<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=veritabani;charset=utf8mb4", "kullanici", "sifre");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sorgu şablonu
    $stmt = $pdo->prepare("INSERT INTO kullanicilar (kullanici_adi, email, sifre) VALUES (:kullanici_adi, :email, :sifre)");
    
    // Verileri bağla
    $stmt->execute([
        'kullanici_adi' => $_POST['kullanici_adi'],
        'email' => $_POST['email'],
        'sifre' => password_hash($_POST['sifre'], PASSWORD_DEFAULT)
    ]);

    echo "Kullanıcı eklendi!";
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
```

#### MySQLi ile Prepared Statements
```php
<?php
$mysqli = new mysqli('localhost', 'kullanici', 'sifre', 'veritabani');

if ($mysqli->connect_error) {
    die("Bağlantı hatası: " . $mysqli->connect_error);
}

// Sorgu şablonu
$stmt = $mysqli->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ? AND sifre = ?");
$stmt->bind_param("ss", $kullanici_adi, $sifre);

// Verileri bağla
$kullanici_adi = $_POST['kullanici_adi'];
$sifre = $_POST['sifre'];
$stmt->execute();

// Sonuçları al
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo "Giriş başarılı!";
} else {
    echo "Geçersiz kullanıcı adı veya şifre.";
}

$stmt->close();
$mysqli->close();
?>
```

### Avantajları
- **Güvenlik**: Kullanıcı girişleri SQL kodu olarak değerlendirilmez, böylece SQL injection önlenir.
- **Performans**: Aynı sorgu tekrar kullanıldığında veritabanı tarafından önbelleğe alınabilir.
- **Okunabilirlik**: Kod daha düzenli ve anlaşılır olur.
- **Esneklik**: Farklı veritabanı sistemleriyle (MySQL, PostgreSQL, vb.) uyumludur.

### Örnek SQL Injection Senaryosu
Kullanıcı giriş alanına şu girerse:
```
' OR '1'='1'; --
```

**Prepared Statements Olmadan** (Tehlikeli):
```php
$sql = "SELECT * FROM kullanicilar WHERE kullanici_adi = '" . $_POST['kullanici_adi'] . "'";
```
Bu, sorguyu şu hale getirir:
```sql
SELECT * FROM kullanicilar WHERE kullanici_adi = '' OR '1'='1'; --
```
Bu, tüm kullanıcıları döndürebilir ve güvenliği tehlikeye atar.

**Prepared Statements ile** (Güvenli):
```php
$stmt = $pdo->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ?");
$stmt->execute([$_POST['kullanici_adi']]);
```
Bu durumda, giriş yalnızca bir veri olarak işlenir ve zararlı kod çalışmaz.

### Öneriler
- Tüm veritabanı işlemlerinde (SELECT, INSERT, UPDATE, DELETE) prepared statements kullanın.
- Kullanıcı girişlerini ek olarak doğrulayın (ör. `filter_input` veya regex).
- Veritabanı hatalarını kullanıcıya göstermeden önce `try-catch` ile yakalayın.

Eğer başka bir konuda açıklama veya örnek istersen, söyle, hemen yardımcı olayım!

---
