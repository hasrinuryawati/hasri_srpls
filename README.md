## Note
- PHP versi 8.1 keatas (ini menggunakan PHP 8.2.7)
- Laravel Framework 10.13.5
- Database: MySQL

## Step By Step

- Duplicate file .env.example & rename jadi .env
- Sesuaikan isi DB_DATABASE=databasename, 
- run: php artisan migrate (untuk menjalankan file migrasi ke database)
- run: php artisan db:seed (untuk sample data)
