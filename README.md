Berikut adalah contoh **`README.md` lengkap dan profesional** untuk proyek Laravel kamu: **Kalkulator Pajak dengan fitur Riwayat & Ekspor PDF**, menggunakan **database `pajakkalk.sql`**.

---

````markdown
# 🧮 Kalkulator Pajak Laravel

Aplikasi web kalkulator pajak berbasis Laravel dengan fitur:
- Perhitungan pajak otomatis
- Penyimpanan riwayat perhitungan
- Ekspor hasil ke PDF
- Tanpa perlu login atau autentikasi

Cocok untuk simulasi PPN, PKB, atau pajak lainnya.

---

## ✨ Fitur

- 💸 Kalkulasi pajak berdasarkan input pengguna
- 🗂 Menyimpan riwayat perhitungan secara otomatis
- 📄 Ekspor hasil perhitungan ke PDF
- 📱 Antarmuka sederhana dan responsif
- 🧾 Riwayat ditampilkan dalam bentuk tabel
- 🔐 Tidak memerlukan login

---

## 🧰 Teknologi yang Digunakan

- [Laravel](https://laravel.com/) 10+
- [MySQL](https://www.mysql.com/) / phpMyAdmin
- [DOMPDF](https://github.com/dompdf/dompdf) untuk PDF generation
- Blade Templating Engine
- HTML/CSS

---

## 🚀 Cara Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/kalkulator-pajak.git
cd kalkulator-pajak
````

### 2. Install Dependency Laravel

```bash
composer install
```

### 3. Buat File `.env`

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi `.env`

Edit file `.env` kamu:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pajakkalk
DB_USERNAME=root
DB_PASSWORD=  // ganti sesuai password MySQL kamu
```

---

## 🗃️ Import Database (via phpMyAdmin)

1. Buka [phpMyAdmin](http://localhost/phpmyadmin)
2. Buat database baru dengan nama: `pajakkalk`
3. Masuk ke tab **Import**
4. Pilih file `database/pajakkalk.sql` dari folder project
5. Klik **Go**

✅ Setelah sukses, database akan terpasang dan siap digunakan.

📥 [Download pajakkalk.sql](database/pajakkalk.sql)

---

## 💡 Menjalankan Proyek

```bash
php artisan serve
```

Lalu akses di browser: [http://localhost:8000](http://localhost:8000)

---

## 📄 Struktur Folder Penting

```
kalkulator-pajak/
├── app/
│   └── Http/Controllers/PajakController.php
├── resources/
│   └── views/
│       ├── kalkulator.blade.php
│       ├── hasil_pdf.blade.php
├── database/
│   └── pajakkalk.sql
├── routes/
│   └── web.php
└── README.md
```

---

## 📄 Ekspor PDF

Setelah menghitung pajak, tombol **"Export to PDF"** akan muncul. Hasil PDF dihasilkan dari view Blade dan diunduh langsung.

---

## 🤝 Kontribusi

Pull request sangat terbuka!
Silakan fork, buat branch baru, dan kirim PR.

---

## 📜 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

## 🙋‍♂️ Developer

Created by me
GitHub: [@Sw4nhilde](https://github.com/Sw4nhilde)

```
