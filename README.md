# 🚀 MBG Monitoring System - SPARK 2026

Sistem Monitoring Makan Bergizi Gratis (MBG) untuk Badan Gizi Nasional (BGN).
Dibuat oleh: **Putri Indah Cahyani**

## 🛠 Teknologi
- **Backend**: Laravel 11 + MySQL
- **Frontend**: Bootstrap 5 + AdminLTE + Leaflet Maps + Chart.js
- **Real-time**: Node.js + Socket.io (Port 3000)
- **PWA**: Mobile-first, Installable

## 🎨 Branding BGN Official
- `--bgn-primary`: `#071e49` (Biru Gelap)
- `--bgn-success`: `#92d05d` (Hijau KPI)
- `--bgn-info`: `#b5e0ea` (Biru Pastel)
- `--bgn-gold`: `#d1b06c` (Emas 2045)

## 📋 Cara Menjalankan (Local XAMPP)

1. **Database Setup**:
   - Buka phpMyAdmin.
   - Buat database baru bernama `mbg_monitoring`.
   
2. **Install & Migrate**:
   ```bash
   composer install
   php artisan migrate:fresh --seed
   ```

3. **Jalankan Laravel**:
   ```bash
   php artisan serve
   ```

4. **Jalankan Real-time Server** (Membutuhkan Node.js):
   ```bash
   cd server
   npm init -y
   npm install socket.io
   node server.js
   ```

## 🎯 Skenario Demo SPARK (7 Menit)

1. **Dashboard Publik (0-2 Menit)**:
   - Tunjukkan KPI Cards dengan warna resmi BGN.
   - Jelaskan Budget Breakdown Pie Chart (Rp15k/porsi).
   - Tunjukkan Map Yogyakarta yang siap menerima update live.

2. **Driver Tracking (2-4 Menit)**:
   - Buka `/driver` di browser (simulasi HP).
   - Klik **"Mulai Tracking GPS"**.
   - (Buka Dashboard di tab lain) Lihat marker bergerak secara real-time mengikuti koordinat GPS driver.

3. **Keuangan & Nutrisi (4-6 Menit)**:
   - Tunjukkan tabel breakdown biaya harian di `/finance`.
   - Tunjukkan hasil verifikasi AKG di `/nutrition` (Kalori, Protein, Karbo).

4. **Closing (6-7 Menit)**:
   - Jelaskan dampak transparansi anggaran Rp10k bahan baku terhadap pencegahan korupsi dan kualitas gizi Generasi Emas 2045.

---
**© 2026 Badan Gizi Nasional | Generasi Emas 2045**
🏆 *Juara SPARK Technology Innovation Competition!*
