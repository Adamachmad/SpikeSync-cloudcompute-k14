# 🏐 GitHub Issue: Build VolleyTrack SaaS Application (Laravel 12 + MySQL + Docker)

---

## 📌 Judul Issue
**Build VolleyTrack SaaS Application - Full Stack Development dengan Laravel 12, MySQL, dan Docker**

---

## 📋 Tipe Issue
- **Priority**: 🔴 High
- **Complexity**: 🟠 Medium-High
- **Estimated Time**: 2-3 Minggu
- **Assigned To**: Junior Programmer AI
- **Labels**: `enhancement`, `saas`, `laravel`, `docker`, `feature`

---

## 📝 Konteks & Tujuan (Description)

### 🎯 Objective
Membangun aplikasi **VolleyTrack** - sebuah SaaS (Software as a Service) yang komprehensif untuk komunitas pencinta bola voli. Aplikasi ini dirancang untuk membantu pengguna mengelola jadwal latihan, mendapatkan rekomendasi workout, melacak statistik pemain, dan melihat leaderboard global. Aplikasi ini merupakan tugas untuk mata kuliah **Cloud Computing** Semester 6.

### 📌 Konteks Aplikasi (VolleyTrack)
VolleyTrack adalah platform SaaS yang menyediakan fitur-fitur berikut:
- **Manajemen Jadwal Latihan**: Pengguna dapat membuat, mengubah, dan melihat jadwal latihan tim
- **Rekomendasi Workout**: Terintegrasi dengan API pihak ketiga untuk memberikan saran latihan fisik spesifik bola voli
- **Tracking Statistik Pemain**: Mencatat performa pemain (Spike, Block, Ace, dll)
- **Leaderboard Global**: Menampilkan ranking pemain atau tim berdasarkan statistik
- **Sistem Langganan (Subscription)**: Menawarkan paket Basic (perorangan) dan Pro (manajemen tim)

### 🎓 Persyaratan Akademik (Cloud Computing Course)
Aplikasi harus memenuhi 5 aspek utama:

#### 1. **Landing Page & Pricing SaaS** 
   - Buat landing page yang sporty, modern, dan fully responsive (Mobile-first approach)
   - Menampilkan value proposition aplikasi dengan jelas
   - Bagian pricing dengan minimal 2 paket: **Basic** (untuk individual/perorangan) dan **Pro** (untuk team management)
   - Setiap paket menampilkan fitur-fitur yang included
   - Button CTA (Call To Action) untuk trial gratis atau sign up

#### 2. **Integrasi REST API Pihak Ketiga**
   - Integrasikan dengan minimal 1 REST API eksternal:
     - **ExerciseDB API** (untuk panduan latihan fisik) - https://rapidapi.com/api-sports/api/api-sports
     - Atau **Sports API** (untuk berita voli real-time) - https://rapidapi.com/daverogers/api/exercise-database
   - Fitur: Aplikasi harus bisa **fetch data** dari API eksternal dan **menampilkan** di dashboard pengguna
   - Implementasi error handling & caching untuk optimasi performa

#### 3. **Fitur CLI (Command Line Interface)**
   - Buat custom Laravel Artisan command:
     - Nama command: `php artisan volley:fetch-workout`
     - Fungsi: Mengambil data workout dari REST API pihak ketiga dan menyimpan ke database
     - Command ini bisa dijadwalkan menggunakan Laravel Scheduler (task scheduling)
   - Buat minimal 1 custom command tambahan sesuai kebutuhan (contoh: `php artisan volley:generate-leaderboard`)

#### 4. **Manajemen Environment yang Aman**
   - Setup file `.env` untuk konfigurasi database dan API Keys
   - File `.env` harus di-ignore dari GitHub melalui `.gitignore`
   - Sediakan file `.env.example` sebagai template untuk developer lain
   - Konfigurasi untuk 3 environment berbeda:
     - **Development** (.env.development)
     - **Staging** (.env.staging)  
     - **Production** (.env.production)
   - Semua instalasi dependensi PHP menggunakan `composer install`
   - Implementasi `.gitignore` yang benar (harus mengabaikan: vendor/, node_modules/, .env, dll)

#### 5. **Konfigurasi Docker**
   - Siapkan `Dockerfile` untuk aplikasi Laravel
   - Siapkan `docker-compose.yml` untuk orchestration Laravel + MySQL
   - Docker compose harus mengatur:
     - **Service Laravel**: Dengan port 8000 (atau sesuai kebutuhan)
     - **Service MySQL**: Dengan volume persistence untuk database
     - **Network**: Komunikasi antar service
   - Setup bisa dijalankan dengan command sederhana: `docker-compose up -d`
   - Implementasi build optimization (multi-stage build untuk ukuran image yang lebih kecil)

---

## ✅ Kriteria Penerimaan (Acceptance Criteria)

### A. Functional Requirements
- [ ] **Landing Page**
  - [ ] Halaman landing responsif dengan design yang sporty dan modern
  - [ ] Navigation bar yang user-friendly dengan link ke fitur utama
  - [ ] Hero section dengan clear value proposition
  - [ ] Pricing section menampilkan minimal 2 paket (Basic & Pro) dengan detail fitur
  - [ ] Button CTA untuk sign up / trial yang berfungsi
  - [ ] Footer dengan contact info dan social media links

- [ ] **Authentication & User Management**
  - [ ] Sign up & login functionality menggunakan Laravel Breeze atau Fortify
  - [ ] User roles (Individual, Team Admin, Member)
  - [ ] Password reset & email verification
  - [ ] Dashboard sesuai dengan role pengguna

- [ ] **REST API Integration**
  - [ ] Aplikasi berhasil fetch data dari minimal 1 third-party API
  - [ ] Data dari API ditampilkan di user dashboard dengan format yang menarik
  - [ ] Error handling ketika API down atau timeout
  - [ ] Implementasi caching untuk improve performance (menggunakan Redis atau file cache)

- [ ] **CLI Commands**
  - [ ] Command `php artisan volley:fetch-workout` berfungsi dengan baik
  - [ ] Command dapat dijalankan manual dari terminal
  - [ ] Command tersimpan dalam scheduler untuk automatic execution
  - [ ] Output command menunjukkan status (success/failed)
  - [ ] Minimal 1 custom command tambahan berfungsi

- [ ] **Core Features**
  - [ ] Manajemen jadwal latihan (Create, Read, Update, Delete)
  - [ ] Tracking statistik pemain (Spike, Block, Ace, Pass, dll)
  - [ ] Leaderboard menampilkan top players/teams
  - [ ] Dashboard dengan summary data penting

### B. Technical Requirements
- [ ] **Database**
  - [ ] MySQL database ter-setup dengan proper schema
  - [ ] Minimal 5 tables: users, teams, players, schedules, statistics, leaderboard
  - [ ] Relationship antar table dengan foreign keys yang proper

- [ ] **.env & Environment Management**
  - [ ] File `.env` tidak ter-commit ke Git (verified via .gitignore)
  - [ ] File `.env.example` ada dan menunjukkan required variables
  - [ ] Aplikasi support multiple environments (dev/staging/prod)
  - [ ] Database credentials sesuai environment masing-masing

- [ ] **Docker Setup**
  - [ ] `Dockerfile` ter-setup dengan instruksi yang benar untuk Laravel
  - [ ] `docker-compose.yml` ter-setup dengan service Laravel + MySQL
  - [ ] Command `docker-compose up -d` berfungsi tanpa error
  - [ ] Laravel accessible di `http://localhost:8000` (atau port yang dikonfigurasi)
  - [ ] MySQL accessible dari Laravel container dengan benar
  - [ ] Database persistence terjamin dengan volume mounting

- [ ] **Code Quality & Best Practices**
  - [ ] Menggunakan MVC pattern dengan proper separation of concerns
  - [ ] Route grouping dan controller organization yang rapi
  - [ ] Request validation menggunakan Form Request atau validation middleware
  - [ ] Error handling & logging yang proper
  - [ ] Code comments & documentation yang jelas

- [ ] **Dependency Management**
  - [ ] Semua PHP dependencies ter-list di `composer.json`
  - [ ] `composer install` berfungsi untuk menginstall semua dependencies
  - [ ] Frontend dependencies (jika ada) ter-manage dengan npm/yarn
  - [ ] `node_modules/` dan `vendor/` di-ignore dari Git

- [ ] **.gitignore Configuration**
  - [ ] File `.gitignore` ter-setup dengan benar mencakup:
    - `/vendor`
    - `/node_modules`
    - `/.env`
    - `/.env.*` (kecuali .env.example)
    - `/storage/logs/*`
    - `/bootstrap/cache/*`
    - `.DS_Store`, `Thumbs.db`
    - IDE files (`.vscode/`, `.idea/`)

### C. Testing & Documentation
- [ ] Aplikasi bisa run tanpa error pada environment yang fresh (clean installation)
- [ ] Semua custom commands berjalan tanpa error
- [ ] API integration berfungsi dan menampilkan data dengan benar
- [ ] README.md ter-update dengan:
  - [ ] Setup instructions (Docker & Manual)
  - [ ] Environment variables explanation
  - [ ] Custom CLI commands documentation
  - [ ] Database schema overview
  - [ ] API integration documentation

---

## 📋 Daftar Tugas (Task List / To-Do)

### **PHASE 1: Project Setup & Infrastructure** (Est. 2-3 hari)

#### Task 1.1: Inisialisasi Project Laravel 12
- [ ] Install Laravel 12 menggunakan composer create-project
- [ ] Setup struktur folder project yang rapi
- [ ] Install Laravel Breeze untuk authentication
- [ ] Konfigurasi `.env.example` dengan template awal
- [ ] Konfigurasi `.gitignore` dengan benar
- [ ] Inisialisasi Git repository dan commit awal

#### Task 1.2: Setup Database MySQL & Schema
- [ ] Buat 5+ migration files untuk tables: users, teams, players, schedules, statistics, leaderboard
- [ ] Definisikan relationship antar tables dengan proper foreign keys
- [ ] Buat seeders untuk sample data (contoh: 10 players, 5 teams, 20 statistics entries)
- [ ] Jalankan migration dan seeder untuk test
- [ ] Dokumentasikan database schema di README

#### Task 1.3: Setup Docker & docker-compose
- [ ] Buat `Dockerfile` untuk Laravel 12 dengan:
  - [ ] Base image PHP 8.2+
  - [ ] Install composer, npm
  - [ ] Copy application files
  - [ ] Setup entrypoint script untuk running migrations
- [ ] Buat `docker-compose.yml` dengan:
  - [ ] Service Laravel (port mapping, volume mounting)
  - [ ] Service MySQL (environment variables, volume persistence)
  - [ ] Network untuk inter-service communication
- [ ] Test docker-compose up dan verify aplikasi accessible
- [ ] Dokumentasikan Docker setup di README

#### Task 1.4: Environment Management Setup
- [ ] Buat `.env.example` template lengkap
- [ ] Setup 3 environment configuration:
  - [ ] .env.development (local dev dengan DB lokal)
  - [ ] .env.staging (staging server credentials)
  - [ ] .env.production (production credentials)
- [ ] Implementasi logic untuk load correct .env based on APP_ENV
- [ ] Verify .env tidak ter-commit via git status

---

### **PHASE 2: Frontend - Landing Page & Pricing** (Est. 2-3 hari)

#### Task 2.1: Landing Page Design & Development
- [ ] Buat landing page view/blade template
- [ ] Implementasi responsive design (mobile-first approach) menggunakan:
  - [ ] Bootstrap 5 atau Tailwind CSS
  - [ ] atau custom CSS media queries
- [ ] Design elements utama:
  - [ ] Navigation bar dengan logo & links
  - [ ] Hero section dengan background image/gradient
  - [ ] Features section menampilkan 4-6 fitur utama VolleyTrack
  - [ ] Call-to-action section
  - [ ] Footer dengan contact & social links
- [ ] Gunakan icon/images yang sporty dan relevan bola voli
- [ ] Test responsive design di mobile, tablet, desktop

#### Task 2.2: Pricing Page & Subscription Plans
- [ ] Buat pricing page view dengan 2 paket minimum:
  - [ ] **Basic Plan**: untuk individual
    - [ ] Fitur-fitur: Schedule Management, Personal Stats
    - [ ] Price: example Rp 29.900/bulan
  - [ ] **Pro Plan**: untuk team management
    - [ ] Fitur-fitur: All Basic + Team Management, Leaderboard, API Access
    - [ ] Price: example Rp 99.900/bulan
- [ ] Setiap paket card menampilkan:
  - [ ] Nama paket dan harga
  - [ ] List fitur dengan checkmark
  - [ ] Button "Get Started" / "Try Free"
- [ ] Implementasi pricing comparison table untuk clarity
- [ ] Add "Popular" badge untuk Pro plan
- [ ] Test layout responsiveness

#### Task 2.3: CTA & Sign Up Flow
- [ ] Buat "Get Started" button yang link ke sign up form
- [ ] Sign up form menampilkan pilihan paket (Basic/Pro)
- [ ] Implementasi form validation di frontend & backend
- [ ] Setelah sign up, user diredirect ke dashboard sesuai paket yang dipilih
- [ ] Tambahkan trial period logic (contoh: 7 hari trial gratis untuk Pro plan)

---

### **PHASE 3: Backend - Core Features & REST API Integration** (Est. 3-4 hari)

#### Task 3.1: Authentication & User Management
- [ ] Setup user roles (Individual, Team Admin, Team Member)
- [ ] Buat role-based middleware untuk access control
- [ ] Buat user profile page dengan bisa edit profile
- [ ] Setup email verification pada sign up
- [ ] Implementasi password reset functionality

#### Task 3.2: Schedule Management Features
- [ ] Buat Schedule model dengan relations ke User/Team
- [ ] Buat CRUD operations:
  - [ ] Create schedule (form validation)
  - [ ] Read schedules (list & detail view)
  - [ ] Update schedule
  - [ ] Delete schedule
- [ ] Fitur filter schedules by date range / team
- [ ] Fitur reminder/notification untuk upcoming schedules
- [ ] Implementasi Schedule seeding untuk sample data

#### Task 3.3: Player Statistics & Tracking
- [ ] Buat PlayerStatistic model dengan fields:
  - [ ] Player ID, Match ID
  - [ ] Spike count, Block count, Ace count, Pass accuracy, etc.
- [ ] Buat CRUD untuk input statistik pemain per match
- [ ] Buat PlayerStats dashboard menampilkan:
  - [ ] Total stats per player
  - [ ] Stats trend (graph/chart)
  - [ ] Performance comparison vs team average
- [ ] Implementasi form untuk input stats per match

#### Task 3.4: Leaderboard Feature
- [ ] Buat leaderboard query yang menghitung:
  - [ ] Total points based on stats (spike, block, ace, dll)
  - [ ] Ranking calculation
- [ ] Leaderboard view menampilkan:
  - [ ] Rank, Player Name, Team, Total Points, Recent Stats
  - [ ] Filter by timeframe (Week, Month, All Time)
- [ ] Implement pagination untuk handle banyak players
- [ ] Add search functionality untuk find specific player

#### Task 3.5: Third-Party REST API Integration
- [ ] **Pilih 1 API eksternal** dari opsi:
  - [ ] ExerciseDB API - untuk workout recommendations
  - [ ] Sports API - untuk volleyball news & updates
  - [ ] Atau alternative API sesuai preferensi
  
- [ ] Setup API integration di Laravel:
  - [ ] Setup API credentials di .env (`API_KEY`, `API_BASE_URL`, dll)
  - [ ] Buat API client class untuk handle requests
  - [ ] Implementasi HTTP client (Guzzle atau Laravel HTTP Client)
  - [ ] Error handling untuk API failures

- [ ] **Fitur Fetch & Display**:
  - [ ] Buat feature untuk fetch workout recommendations dari API
  - [ ] Display hasil fetch di user dashboard dengan format menarik
  - [ ] Implementasi caching (5 jam) untuk reduce API calls
  - [ ] Add refresh button untuk manual fetch data terbaru

- [ ] **Integrations contoh**:
  - [ ] Jika ExerciseDB: Fetch latihan spesifik untuk pemain voli, display dengan video/description
  - [ ] Jika Sports API: Fetch news voli, display di dashboard

#### Task 3.6: Database Models & Relationships
- [ ] Define all models dengan relationships:
  - [ ] User hasMany Teams, hasMany PlayerStats
  - [ ] Team belongsTo User, hasMany Players
  - [ ] Player belongsTo Team, hasMany PlayerStats
  - [ ] PlayerStat belongsTo Player, belongsTo Match
  - [ ] Schedule belongsTo Team
- [ ] Setup proper cascading deletes & updates
- [ ] Create resource classes untuk API responses (jika diperlukan)

---

### **PHASE 4: CLI Commands & Automation** (Est. 1-2 hari)

#### Task 4.1: Custom Artisan Command - fetch-workout
- [ ] Buat custom command: `php artisan volley:fetch-workout`
- [ ] Implementasi:
  - [ ] Call third-party API (lihat Task 3.5)
  - [ ] Fetch latest workouts/exercises untuk voli
  - [ ] Save data ke database table (create `workouts` table jika belum ada)
  - [ ] Show progress & status di console output
  - [ ] Error handling dengan clear messages
- [ ] Command support optional parameters:
  - [ ] `--force` untuk force refresh cache
  - [ ] `--limit=10` untuk limit data fetched
- [ ] Test command bisa dijalankan: `php artisan volley:fetch-workout`

#### Task 4.2: Custom Artisan Command - generate-leaderboard
- [ ] Buat custom command: `php artisan volley:generate-leaderboard`
- [ ] Implementasi:
  - [ ] Query all players dari database
  - [ ] Calculate ranking based on statistics
  - [ ] Update leaderboard table dengan ranking terbaru
  - [ ] Show output berapa banyak players yang di-update
- [ ] Add command description & documentation

#### Task 4.3: Task Scheduling Setup
- [ ] Buat Laravel Scheduler di `app/Console/Kernel.php`
- [ ] Schedule `volley:fetch-workout` untuk run daily (contoh: jam 2 pagi)
- [ ] Schedule `volley:generate-leaderboard` untuk run setiap jam
- [ ] Setup cron job untuk trigger Laravel Scheduler (di production/docker)
- [ ] Dokumentasikan scheduling logic di README

#### Task 4.4: Testing CLI Commands
- [ ] Manual test setiap command untuk verify output
- [ ] Test error scenarios (API down, invalid params, etc.)
- [ ] Verify database updated correctly after command execution
- [ ] Document command usage di README dengan examples

---

### **PHASE 5: Configuration, Optimization & Documentation** (Est. 1-2 hari)

#### Task 5.1: Security & Environment Configuration
- [ ] Review & configure security settings:
  - [ ] Setup CORS jika ada API endpoints
  - [ ] Configure CSRF protection untuk forms
  - [ ] Setup rate limiting untuk API endpoints
  - [ ] Hash passwords & sensitive data properly
- [ ] Verify .env & .gitignore setup correctly
- [ ] Implement environment-specific configurations
- [ ] Audit sensitive data tidak ter-commit ke Git

#### Task 5.2: Performance Optimization
- [ ] Setup database indexing untuk frequently queried columns
- [ ] Implement eager loading (with()) untuk prevent N+1 queries
- [ ] Setup caching strategy untuk API responses
- [ ] Optimize queries di heavy operations (leaderboard, stats)
- [ ] Setup pagination untuk large data sets

#### Task 5.3: Comprehensive Documentation
- [ ] Update/Create README.md mencakup:
  - [ ] Project overview & features
  - [ ] **Installation Guide**:
    - [ ] Option 1: Manual setup (composer, npm, MySQL)
    - [ ] Option 2: Docker setup (docker-compose up)
  - [ ] Environment variables explanation (.env.example breakdown)
  - [ ] Database schema overview / ER diagram
  - [ ] **CLI Commands Documentation**:
    - [ ] `php artisan volley:fetch-workout` - usage & parameters
    - [ ] `php artisan volley:generate-leaderboard` - usage
    - [ ] Scheduling information
  - [ ] **API Integration Documentation**:
    - [ ] Which API digunakan
    - [ ] Cara setup API key
    - [ ] Caching strategy
  - [ ] **Deployment Instructions**:
    - [ ] Docker deployment steps
    - [ ] Environment configuration untuk production
  - [ ] Troubleshooting section
- [ ] Add code comments untuk complex logic
- [ ] Generate API documentation (jika ada custom API endpoints)

#### Task 5.4: Quality Assurance & Testing
- [ ] Jalankan seluruh aplikasi dari clean installation:
  - [ ] Remove vendor & node_modules
  - [ ] `composer install`
  - [ ] `npm install` (jika ada)
  - [ ] Setup database & run migrations
  - [ ] Verify aplikasi berjalan
- [ ] Manual testing semua fitur:
  - [ ] Sign up, login, logout flows
  - [ ] Create/read/update/delete schedules
  - [ ] Input & view player statistics
  - [ ] View leaderboard
  - [ ] REST API integration fetching data
  - [ ] CLI commands execution
- [ ] Test responsiveness di mobile/tablet/desktop
- [ ] Verify Docker setup berfungsi: `docker-compose up -d`
- [ ] Check for PHP errors & warnings di logs

#### Task 5.5: Final Code Cleanup
- [ ] Remove debug code & console.log statements
- [ ] Cleanup commented-out code
- [ ] Fix any code style inconsistencies
- [ ] Verify no hardcoded credentials atau sensitive data
- [ ] Final git commit dengan meaningful message

---

### **PHASE 6: Deployment Preparation** (Est. 1 hari)

#### Task 6.1: Production Configuration
- [ ] Setup `.env.production` template dengan:
  - [ ] APP_ENV=production
  - [ ] APP_DEBUG=false
  - [ ] Production database credentials
  - [ ] Production API keys
- [ ] Configure production database
- [ ] Setup logging untuk production (daily/single file)
- [ ] Configure cache driver (redis recommended)

#### Task 6.2: Docker Production Build
- [ ] Optimize Dockerfile untuk production:
  - [ ] Multi-stage build untuk reduce image size
  - [ ] Remove development dependencies
  - [ ] Proper health checks
- [ ] Test `docker-compose build` berfungsi
- [ ] Verify production image size reasonable

#### Task 6.3: Deployment Documentation
- [ ] Dokumentasikan deployment steps:
  - [ ] Prerequisites (Docker, Docker Compose)
  - [ ] Steps untuk deploy ke server
  - [ ] Environment setup di server
  - [ ] Database migration on production
  - [ ] SSL/HTTPS setup (jika applicable)
  - [ ] Monitoring & logging setup

---

## 🔧 Technical Stack

| Component | Technology |
|-----------|-----------|
| **Framework** | Laravel 12 |
| **Database** | MySQL 8.0+ |
| **Backend Language** | PHP 8.2+ |
| **Frontend** | Blade Templates + Bootstrap 5 / Tailwind CSS |
| **Containerization** | Docker + Docker Compose |
| **Package Manager (PHP)** | Composer |
| **Package Manager (Frontend)** | NPM / Yarn (if needed) |
| **Authentication** | Laravel Breeze / Fortify |
| **HTTP Client** | Laravel HTTP Client / Guzzle |
| **Caching** | File Cache / Redis (optional) |
| **Task Scheduling** | Laravel Scheduler |
| **Version Control** | Git + GitHub |

---

## 💡 Resources & References

### Documentation
- [Laravel 12 Official Docs](https://laravel.com/docs/12.x)
- [Laravel Breeze Authentication](https://laravel.com/docs/12.x/starter-kits#breeze-and-blade)
- [Docker Official Docs](https://docs.docker.com/)
- [MySQL Official Docs](https://dev.mysql.com/doc/)

### Recommended APIs (untuk Task 3.5)
- [ExerciseDB API](https://rapidapi.com/api-sports/api/api-sports)
- [Sports API](https://rapidapi.com/daverogers/api/exercise-database)
- [Rapid API Hub](https://rapidapi.com/) - untuk pilihan API lainnya

### Tools & Libraries
- [Guzzle HTTP Client](http://docs.guzzlephp.org/)
- [Laravel HTTP Client](https://laravel.com/docs/12.x/http-client)
- [Laravel Artisan Console](https://laravel.com/docs/12.x/artisan)
- [Bootstrap 5](https://getbootstrap.com/docs/5.0)
- [Tailwind CSS](https://tailwindcss.com/docs)

---

## 📊 Deliverables Checklist

- [ ] GitHub Repository dengan proper commit history
- [ ] Source code ter-organize dengan MVC pattern
- [ ] `.env.example` file dengan semua required variables
- [ ] Dockerfile dan docker-compose.yml yang working
- [ ] Database migrations dan seeders
- [ ] Custom Laravel CLI commands (2 minimum)
- [ ] Landing page dan pricing page responsif
- [ ] REST API integration working dan data displaying
- [ ] README.md dengan comprehensive documentation
- [ ] All features tested dan working tanpa error

---

## 🎯 Success Criteria (Final Evaluation)

1. **Aplikasi dapat dijalankan dengan:** `docker-compose up -d` tanpa error
2. **CLI commands berfungsi:** `php artisan volley:fetch-workout` berhasil fetch & save data
3. **REST API integration working:** Data dari API tampil di dashboard user
4. **Database properly configured:** Semua tables, relationships, indices ter-setup
5. **Environment management aman:** .env file di-ignore, credentials tidak ter-leak
6. **Documentation lengkap:** README mencakup setup, CLI, API, deployment
7. **Code quality:** Clean code, proper error handling, comments untuk complex logic
8. **Responsive design:** Landing page & app UI responsive di semua devices

---

## 📞 Communication & Feedback

- **Status Updates**: Weekly standup meetings
- **Blockers**: Report immediately di team channel
- **Questions**: Clarify requirements sebelum mulai task
- **Code Review**: Submit PR untuk review sebelum merge ke main branch
- **Test Scenarios**: Dokumentasikan test cases untuk setiap feature

---

**Created by**: Senior Programmer AI  
**Date**: May 1, 2026  
**Version**: 1.0

---

*Issue ini dirancang untuk memberikan guidance lengkap kepada Junior Programmer AI dalam mengembangkan VolleyTrack SaaS application dengan standar enterprise-grade dan best practices industry.*
