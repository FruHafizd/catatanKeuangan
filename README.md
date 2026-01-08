# 💰 Personal Finance Tracker

Aplikasi web untuk mencatat dan mengelola keuangan pribadi Anda dengan mudah dan terstruktur. Pantau pemasukan, pengeluaran, dan saldo bersih Anda secara real-time dengan antarmuka yang intuitif.

## ✨ Fitur Utama

### 📊 Dashboard Summary
Dashboard utama menampilkan ringkasan keuangan Anda untuk bulan berjalan (contoh: Januari 2025):
- **Total Pemasukan** - Jumlah seluruh pendapatan bulan ini
- **Total Pengeluaran** - Jumlah seluruh pengeluaran bulan ini
- **Saldo Bersih** - Selisih antara pemasukan dan pengeluaran

![Dashboard Summary](<img width="1464" height="600" alt="image" src="https://github.com/user-attachments/assets/ee9c3393-184a-4ddd-8dce-505cb416905d" />)

### 📝 Riwayat Transaksi
Catat dan pantau semua transaksi keuangan Anda dengan fitur:
- Pencatatan transaksi pemasukan dan pengeluaran
- Filter berdasarkan **Tahun**
- Filter berdasarkan **Bulan**
- Filter berdasarkan **Tipe Transaksi** (Pemasukan/Pengeluaran)
- Riwayat lengkap semua transaksi Anda

![Riwayat Transaksi](<img width="1431" height="682" alt="image" src="https://github.com/user-attachments/assets/a5e9f10d-f9f3-44ff-b8c9-bb0363a7f156" />)

### 🔄 Transaksi Berulang (Recurring)
Atur transaksi yang terjadi secara berulang otomatis:
- Gaji bulanan
- Tagihan rutin (listrik, internet, dll)
- Cicilan atau pembayaran berkala
- Kustomisasi frekuensi pengulangan

![Transaksi Berulang](<img width="1491" height="449" alt="image" src="https://github.com/user-attachments/assets/8d87d692-953b-459b-bc5e-626da767ce68" />)

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL/PostgreSQL/SQLite
- Node.js & NPM

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/FruHafizd/catatanKeuangan.git
   cd catatanKeuangan
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**
   
   Copy file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   
   Edit file `.env`:
   ```env
   APP_NAME="Personal Finance Tracker"
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost
   APP_TIMEZONE=Asia/Jakarta
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=catatan_keuangan
   DB_USERNAME=root
   DB_PASSWORD=
   
   ADMIN_EMAIL=admin@example.com
   ADMIN_NAME="Admin Name"
   ADMIN_PASSWORD=password123
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Setup Database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Compile Assets**
   ```bash
   npm run dev
   ```

7. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

8. Akses aplikasi di `http://localhost:8000`

9. **Login** menggunakan kredensial dari `.env`:
   - Email: sesuai `ADMIN_EMAIL`
   - Password: sesuai `ADMIN_PASSWORD`

## ⚙️ Konfigurasi

### Timezone

Setting timezone penting untuk fitur transaksi berulang. Edit di `.env`:
```env
APP_TIMEZONE=Asia/Jakarta
```

**Pilihan Timezone Indonesia:**
- `Asia/Jakarta` - WIB (Waktu Indonesia Barat)
- `Asia/Makassar` - WITA (Waktu Indonesia Tengah)
- `Asia/Jayapura` - WIT (Waktu Indonesia Timur)

### Login Admin

Karena ini aplikasi pribadi, atur kredensial login di `.env`:
```env
ADMIN_EMAIL=email_anda@example.com
ADMIN_NAME="Nama Lengkap Anda"
ADMIN_PASSWORD=password_yang_kuat
```

## ⏰ Setup Transaksi Berulang Otomatis

Aplikasi menggunakan Laravel Scheduler untuk menjalankan transaksi berulang otomatis setiap hari melalui command:
```php
Schedule::command('recurring:generate')->daily();
```

### Development (Local)

**Opsi 1: Schedule Work (Recommended)**
```bash
php artisan schedule:work
```

**Opsi 2: Manual Trigger**
```bash
php artisan recurring:generate
```

**Opsi 3: Test Schedule**
```bash
php artisan schedule:list
```

### Production (Server)

Tambahkan cron job di server:

1. Buka crontab:
   ```bash
   crontab -e
   ```

2. Tambahkan baris ini:
   ```bash
   * * * * * cd /path/to/catatanKeuangan && php artisan schedule:run >> /dev/null 2>&1
   ```

3. Ganti `/path/to/catatanKeuangan` dengan path project Anda

**Untuk Shared Hosting:**
```bash
* * * * * /usr/bin/php /home/username/public_html/catatanKeuangan/artisan schedule:run >> /dev/null 2>&1
```

### Verifikasi Scheduler

Cek apakah scheduler berjalan:
```bash
# Lihat log
tail -f storage/logs/laravel.log

# Test command
php artisan recurring:generate

# Debug mode
php artisan schedule:run -v
```

## 📖 Cara Penggunaan

1. **Login** dengan kredensial admin dari `.env`
2. **Dashboard** - Lihat ringkasan keuangan bulan berjalan
3. **Tambah Transaksi** - Klik tombol tambah dan isi detail transaksi
4. **Filter Riwayat** - Gunakan filter tahun, bulan, dan tipe transaksi
5. **Setup Recurring** - Buat transaksi berulang untuk tagihan rutin

## 🛠️ Teknologi

- Laravel 12
- MySQL / PostgreSQL / SQLite
- Blade Template
- Tailwind CSS / Bootstrap
- Laravel Scheduler

## 🔐 Tips Keamanan

1. Gunakan password kuat untuk `ADMIN_PASSWORD`
2. Jangan commit file `.env` ke repository
3. Ganti password default saat deploy production
4. Backup database secara berkala

## 📝 Lisensi

[MIT License](LICENSE)

## 👨‍💻 Kontributor

Dibuat dengan ❤️ oleh [FruHafizd](https://github.com/FruHafizd)

## 🤝 Kontribusi

Issues dan feature requests sangat diterima di [issues page](https://github.com/FruHafizd/catatanKeuangan/issues).
