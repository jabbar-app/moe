# Aplikasi Presensi dengan Fitur Emoticon

## Deskripsi Aplikasi

Aplikasi ini adalah sistem presensi berbasis web yang memungkinkan pengguna (peserta acara/kegiatan) untuk melakukan check-in kehadiran melalui tautan unik atau kode QR. Aplikasi ini dilengkapi dengan fitur penentuan status kehadiran berdasarkan waktu check-in relatif terhadap waktu target, dan menampilkan emoticon yang sesuai dengan status tersebut. Administrator dapat membuat dan mengelola daftar hadir, menghasilkan tautan dan kode QR untuk presensi, serta melihat data kehadiran.

## Fitur Utama

-   **Check-in Peserta:** Peserta dapat melakukan check-in melalui tautan unik atau kode QR yang disediakan.
-   **Selfie Check-in:** Proses check-in memerlukan peserta untuk mengambil foto selfie sebagai bukti kehadiran.
-   **Status Kehadiran Berbasis Waktu:** Aplikasi menentukan status kehadiran (misalnya: Sangat Awal, Tepat Waktu, Terlambat) berdasarkan waktu check-in relatif terhadap waktu target yang ditentukan oleh administrator.
-   **Emoticon Dinamis:** Emoticon yang ditampilkan saat check-in dipilih secara acak berdasarkan status kehadiran dan aturan yang dikonfigurasi oleh administrator.
-   **Manajemen Daftar Hadir (Admin):**
    -   Membuat daftar hadir baru dengan nama acara, deskripsi, tanggal, dan waktu acara.
    -   Mengatur waktu buka dan tutup check-in, serta waktu target tepat waktu.
    -   Mengelola aturan emoticon berdasarkan offset waktu relatif terhadap waktu target.
    -   Menampilkan daftar hadir yang telah dibuat.
    -   Mengedit dan memperbarui informasi daftar hadir.
    -   Menghapus daftar hadir.
    -   Melihat detail daftar hadir, termasuk daftar peserta yang telah check-in.
    -   Menghasilkan dan menampilkan kode QR untuk tautan presensi.
    -   Meregenerasi tautan unik dan kode QR untuk daftar hadir.
-   **Autentikasi Admin:** Sistem dilengkapi dengan autentikasi untuk administrator.
-   **Dashboard Admin:** Halaman dashboard yang menyediakan ringkasan dan akses cepat ke fitur-fitur manajemen daftar hadir dan profil.
-   **Validasi Input:** Validasi data yang ketat untuk memastikan integritas data.
-   **Penyimpanan Gambar Selfie:** Gambar selfie peserta disimpan dengan aman.
-   **Responsif:** Tampilan aplikasi dirancang responsif untuk berbagai ukuran layar.
-   **Dark Mode:** Dukungan tampilan dark mode untuk kenyamanan pengguna.

## Teknologi yang Digunakan

-   **PHP:** Bahasa pemrograman server-side.
-   **Laravel:** Framework PHP yang digunakan untuk membangun aplikasi.
-   **Blade:** Templating engine Laravel untuk tampilan antarmuka pengguna.
-   **Tailwind CSS:** Framework CSS utility-first untuk styling yang cepat dan responsif.
-   **Carbon:** Library PHP untuk manipulasi tanggal dan waktu.
-   **Illuminate\Support\Str:** Utilitas string dari Laravel.
-   **Illuminate\Support\Facades\Storage:** Abstraksi sistem file Laravel.
-   **SimpleSoftwareIO\QrCode:** Package Laravel untuk menghasilkan kode QR.

## Instalasi

1.  **Clone Repository:**

    ```bash
    git clone <repository_url>
    cd <nama_aplikasi>
    ```

2.  **Install Composer Dependencies:**

    ```bash
    composer install
    ```

3.  **Copy Environment File:**

    ```bash
    cp .env.example .env
    ```

4.  **Configure Environment Variables (.env):**

    -   Atur `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai dengan konfigurasi database Anda.
    -   Atur `APP_URL` sesuai dengan URL aplikasi Anda.
    -   Konfigurasi variabel lain sesuai kebutuhan.

5.  **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

6.  **Run Migrations:**

    ```bash
    php artisan migrate --seed
    ```

    -   Perintah ini akan menjalankan semua migrasi database dan juga menjalankan seeder untuk data awal (termasuk pembuatan user admin pertama).

7.  **Set Storage Link:**

    ```bash
    php artisan storage:link
    ```

8.  **Serve the Application:**
    ```bash
    php artisan serve
    ```
    -   Aplikasi akan berjalan pada `http://localhost:8000` secara default.

## Konfigurasi Awal

-   Setelah instalasi, Anda dapat mengakses halaman login admin melalui URL `/login`.
-   User admin pertama akan dibuat oleh seeder. Anda dapat mencari detail kredensial admin di file `DatabaseSeeder.php` atau output dari perintah `php artisan migrate --seed`.
-   Setelah login sebagai admin, Anda dapat membuat daftar hadir baru melalui menu "Buat Daftar Hadir Baru" di dashboard atau halaman "Daftar Hadir".

## Penggunaan

### Peserta

1.  Akses tautan unik atau pindai kode QR yang diberikan oleh administrator.
2.  Isi nama dan tim (jika ada).
3.  Ambil foto selfie Anda.
4.  Status kehadiran dan emoticon akan ditampilkan berdasarkan waktu check-in.
5.  Klik tombol "Kirim Presensi" untuk mencatat kehadiran.

### Administrator

1.  Akses halaman login admin (`/login`) dan login menggunakan kredensial Anda.
2.  **Dashboard:** Lihat ringkasan dan akses cepat ke fitur-fitur utama.
3.  **Daftar Hadir:**
    -   Klik "Buat Daftar Hadir Baru" untuk membuat daftar hadir baru. Isi detail acara, waktu check-in, dan aturan emoticon.
    -   Lihat daftar hadir yang telah dibuat, edit, hapus, dan lihat detailnya.
    -   Pada halaman detail daftar hadir, Anda dapat melihat kode QR, tautan unik, dan daftar peserta yang telah check-in.
    -   Gunakan tombol "Perbaharui Link & QR Code" untuk meregenerasi tautan dan kode QR (link lama akan menjadi tidak valid).

## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan fork repository dan kirimkan pull request dengan perubahan yang Anda buat.

## Lisensi

[MIT](LICENSE)
