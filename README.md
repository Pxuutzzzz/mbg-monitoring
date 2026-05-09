# 🥗 MBG Monitoring System — Badan Gizi Nasional

Sistem Transparansi Monitoring Program **Makan Bergizi Gratis (MBG)** berbasis Laravel 11, sesuai Juklak BGN 2026.

---

## 📋 Fitur Utama

- 🗺️ **Peta Nasional** — 38 Dapur SPPG dari Aceh sampai Papua
- 🥗 **Katalog Menu Gizi** — Per target grup (PAUD/TK, SD, SMP, SMA, Pesantren sub-jenjang, Ibu Hamil, dll)
- 💰 **Transparansi Keuangan** — Rincian biaya per komponen menu + standar BGN
- 🚚 **GPS Tracking Driver** — Pemantauan pengiriman real-time
- 🔐 **Admin Panel** — CRUD lengkap untuk SPPG, Menu, Keuangan, Pengguna

---

## 🚀 Cara Instalasi Lokal

```bash
git clone https://github.com/Pxuutzzzz/mbg-monitoring.git
cd mbg-monitoring
composer install
cp .env.example .env
php artisan key:generate
# Isi konfigurasi database di .env
php artisan migrate
php artisan db:seed
php artisan serve
```

---

## 🔐 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@bgn.go.id | password |
| Driver | driver.java@bgn.go.id | password |

---

## 🌐 Deploy ke Railway (Gratis)

1. Buka [railway.app](https://railway.app) → Login dengan GitHub
2. **New Project** → **Deploy from GitHub repo** → pilih `mbg-monitoring`
3. **Add Plugin** → **MySQL**
4. Set **Environment Variables**:
   ```
   APP_KEY=        ← generate: php artisan key:generate --show
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=        ← URL dari Railway (muncul setelah deploy)
   DB_HOST=        ← dari Railway MySQL plugin
   DB_PORT=3306
   DB_DATABASE=    ← dari Railway MySQL plugin
   DB_USERNAME=    ← dari Railway MySQL plugin
   DB_PASSWORD=    ← dari Railway MySQL plugin
   ```
5. Railway otomatis build & deploy!

---

## 📊 Standar BGN 2026

- Bahan baku: **Rp 8.000 – 10.000/porsi**
- Dana operasional: **Rp 3.000/porsi**
- Maks produksi per SPPG: **2.500 porsi/hari**

---

## 🏆 SPARK 2026

Dikembangkan untuk kompetisi **SPARK 2026** oleh tim MBG Monitoring.
