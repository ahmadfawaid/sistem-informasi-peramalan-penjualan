# Skripsweet

> Projek skripsi menggunakan metode peramalan "Adaptive Responsive Rate Single Exponential Smoothing"

## Instalasi

## Sebelum Proses Instalasi
- pastikan komputer anda sudah terinstall `composer` dan `npm`

## Sudah? Ok Lanjut
- jalankan `git clone https://github.com/ahmadfawaid/Skripsweet.git`
- masuk ke direktori app
- jalankan `composer install`
- jalankan `php artisan key:generate`
- buat database MySQL untuk app-nya
- perbarui file `.env` sesuaikan dengan nama database yg telah dibuat
- jalankan `composer dump-autoload`
- jalankan `php artisan migrate`
- jalankan `php artisan db:seed`
- jalankan `npm install`
- jalankan `php artisan serv` 

## Penggunaan

### Kebutuhan Pengembangan (Dev)

```bash
# build and watch
npm run watch

# serve with hot reloading
npm run hot
```

### Data User

admin
username: admin
password: 1324

apoteker
username: apoteker
password: 1324

## Semoga Bermanfaat

