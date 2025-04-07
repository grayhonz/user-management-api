# User Management API

Aplikasi RESTful API untuk manajemen data pengguna menggunakan Laravel.

## Fitur

- CRUD (Create, Read, Update, Delete) untuk entitas User
- Validasi input pada endpoint menggunakan middleware
- Logging untuk setiap request
- Pengujian menggunakan PHPUnit
- Dokumentasi API menggunakan Swagger
- Docker untuk menjalankan aplikasi

## Persyaratan

- PHP >= 8.0
- Composer
- MySQL/PostgreSQL/MongoDB
- (Opsional) Docker & Docker Compose

## Instalasi

### Cara 1: Instalasi Lokal

1. Clone repository
```bash
git clone https://github.com/username/user-management-api.git
cd user-management-api
```

2. Install dependencies
```bash
composer install
```

3. Salin file .env.example menjadi .env
```bash
cp .env.example .env
```

4. Buat database dan konfigurasi file .env

5. Generate application key
```bash
php artisan key:generate
```

6. Jalankan migrasi
```bash
php artisan migrate
```

7. Jalankan server
```bash
php artisan serve
```

8. Akses aplikasi di http://localhost:8000

### Cara 2: Menggunakan Docker

1. Clone repository
```bash
git clone https://github.com/username/user-management-api.git
cd user-management-api
```

2. Salin file .env.example menjadi .env
```bash
cp .env.example .env
```

3. Sesuaikan konfigurasi database di file .env
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=user_management
DB_USERNAME=root
DB_PASSWORD=your_mysql_root_password
```

4. Jalankan Docker Compose
```bash
docker-compose up -d
```

5. Masuk ke container aplikasi
```bash
docker-compose exec app bash
```

6. Install dependencies dan jalankan migrasi
```bash
composer install
php artisan key:generate
php artisan migrate
```

7. Akses aplikasi di http://localhost

## Endpoint API

- `GET /api/users`: Mendapatkan daftar semua pengguna
- `GET /api/users/{id}`: Mendapatkan data pengguna berdasarkan id
- `POST /api/users`: Menambahkan pengguna baru
- `PUT /api/users/{id}`: Memperbarui data pengguna berdasarkan id
- `DELETE /api/users/{id}`: Menghapus pengguna berdasarkan id

## Dokumentasi API

Dokumentasi API tersedia di `/api/documentation` setelah menjalankan:

```bash
php artisan l5-swagger:generate
```

## Testing

Untuk menjalankan unit test:

```bash
php artisan test
```

## Struktur Proyek

Proyek ini menggunakan pola arsitektur MVC:

- `app/Models`: Berisi model data
- `app/Http/Controllers`: Berisi controller untuk menangani request
- `app/Http/Middleware`: Berisi middleware untuk validasi dan logging
- `database/migrations`: Berisi file migrasi database
- `tests`: Berisi file pengujian
