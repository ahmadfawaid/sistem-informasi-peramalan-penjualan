# Skripsweet

> Projek skripsi menggunakan framework Laravel & Vue


## Instalasi

### Sebelum Proses Instalasi
- pastikan komputer anda sudah terinstall `composer` dan `npm`

### Sudah? Ok Lanjut
- jalankan `git clone https://github.com/ahmadfawaid/Skripsweet.git`
- masuk ke direktori app
- jalankan `composer install`
- jalankan `php artisan key:generate`
- buat database MySQL untuk app-nya
- copy file `.env.example` ke `.env`
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

|Email|Password|
|:------------|:------------|
|admin|1324|
|apoteker|1324|


## Semoga Bermanfaat

