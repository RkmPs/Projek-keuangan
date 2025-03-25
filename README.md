# Projek Keuangan

Projek ini dikerjakan untuk memenuhi tugas sekolah.
Pada tugas ini, kelompok kami memilih untuk membuat web laporan keuangan. Kami menggunakan Laravel, Vue dan Inertia dalam pembuatannya.
[Link video demo (Masih kosong)](http://handlebarsjs.com/)


# Anggota Kelompok

- M. Razzaq Athallah K.M.P sebagai Backend Dev (Laravel dan vue script setup)
- M. Farel Atqiya sebagai Project Manager
- Rafan Jaris Adytia  sebagai Frontend Dev (Perancangan UI/UX dan pembuatan laman)

## Cara menjalankan projek

1. ### Clone repositori

    - Lakukan Git clone
       ```bash
       git clone https://github.com/RkmPs/Projek-keuangan.git      
        ```
        > Pastikan terminal sedang di directory xampp\htdocs

2. ### Set up project
	
    - Change Directory
      ```bash
      cd Projek-keuangan
       ```
    - Install dependency laravel yang dibutuhkan
      ```bash
      composer install
       ```
    - Install dependency node yang dibutuhkan
       ```bash
       npm install
       ```

3. ### Setting database
    - Salin file env.txt ke .env
       ```bash
       cp env.txt .env
       ```
     - Migrate
	     ```bash
       php artisan migrate
       ```
     - Jalankan seeder DB
       ```bash
       php artisan db:seed
       ```
     

4. ### Generate app key
   ```bash
   php artisan key:generate
   ```

5. ### Jalankan aplikasi
   ```bash
   php artisan serve
   ```
      ```bash
   npm run dev
   ```
> Pastikan server apache dan mysql Xampp sudah menyala

6. #### Jika ingin mencoba akun yang sudah memiliki data transaksi, login dengan:
| Email                          |Password                         |
|------------------------------- |-----------------------------|
| user@user.com                  |testestes          

