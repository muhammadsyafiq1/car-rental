1. Clone project
git clone https://github.com/username/car-rental.git
cd car-rental
2. Install dependencies
bash
Always show details

Copy
composer install
3. Setup .env
Copy .env.example → .env, lalu sesuaikan:


Copy
DB_DATABASE=car_rental
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_user
MAIL_PASSWORD=your_mailtrap_pass
MAIL_FROM_ADDRESS=no-reply@carrental.test
MAIL_FROM_NAME="Car Rental App"

4. Jalankan database migration & seeder
php artisan migrate:fresh --seed
Seeder akan membuat:

1000 cars

500 users

2000 bookings

ara Menggunakan Aplikasi Car Rental
Menjalankan Aplikasi

php artisan serve
Akses di browser:
http://localhost:8000/
Jalankan Queue Redis

php artisan queue:work
Cek Email Notifikasi (via Mailtrap)
Login ke https://mailtrap.io/

Buka Inbox

Email booking akan muncul setelah queue diproses

Alur Penggunaan Web (Frontend Blade)
Halaman Utama: Daftar mobil + filter

Booking Mobil: Pilih mobil, isi tanggal

Halaman Konfirmasi: Detail booking & email masuk

Jalankan Testing
php artisan test
Ringkasan Booking Harian (Artisan Command)

php artisan booking:summary
Output:

Total bookings

Bookings per status

Revenue completed bookings

Artisan & Cache Command Lengkap

Fungsi	Command
Menjalankan server	php artisan serve
Menjalankan queue Redis	php artisan queue:work
Generate ringkasan booking	php artisan booking:summary
Jalankan ulang seeder	php artisan migrate:fresh --seed
Clear config cache	php artisan config:clear
Clear Redis cache	php artisan cache:clear
Clear compiled routes & views	php artisan route:clear && php artisan view:clear

Login Pengguna (sementara / yang melakukan booking)

<input type="hidden" name="user_id" value="1">
