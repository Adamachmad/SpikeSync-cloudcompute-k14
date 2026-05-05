# 🔴 GitHub Issue: VolleyTrack Application - Critical Issues Found During Testing

---

## 📌 Judul Issue
**VolleyTrack SaaS Application - Critical Configuration & Route Issues Preventing Application Execution**

---

## 📋 Tipe Issue
- **Priority**: 🔴 CRITICAL - Application cannot run properly
- **Complexity**: 🟠 Medium  
- **Estimated Time**: 2-3 Jam untuk perbaikan
- **Status**: 🔴 BLOCKING
- **Labels**: `bug`, `critical`, `routes`, `database`, `models`

---

## 📝 Deskripsi Masalah (Description)

Selama melakukan testing pada aplikasi VolleyTrack, ditemukan beberapa **critical issues** yang menghalangi aplikasi untuk berjalan dengan baik. Masalah-masalah ini mencakup:

1. **Konfigurasi Database Tidak Sesuai**
2. **Route Penting Tidak Terdefinisi**
3. **Model Relationships Tidak Lengkap**
4. **API Controllers Tidak Ada**
5. **Doc Block Errors yang Mencegah Code Analysis**

### 🎓 Konteks Akademik & Cloud Deployment
Aplikasi ini merupakan **tugas Cloud Computing Semester 6** dengan materi **SaaS (Software as a Service)**. Aplikasi akan di-deploy ke **AWS (Amazon Web Services)** sebagai infrastructure cloud untuk production.

**Deployment Target**: AWS  
**Service Architecture**: Multi-tier SaaS Application  
**Environment**: Docker containerized untuk seamless deployment

Semua issues yang ditemukan HARUS diperbaiki sebelum deployment ke AWS production.

---

## 🐛 Issues yang Ditemukan

### ❌ Issue #1: Database Configuration Mismatch
**File**: `.env`  
**Severity**: CRITICAL

**Problem**:
```
Current .env configuration:
- DB_CONNECTION=sqlite
- DB_HOST=127.0.0.1
- DB_PORT=3306

Expected (sesuai docker-compose.yml):
- DB_CONNECTION=mysql
- DB_HOST=mysql
- DB_PORT=3306
- DB_DATABASE=volleytrack_db
- DB_USERNAME=volleytrack_user
- DB_PASSWORD=volleytrack_password
```

**Impact**: 
- Aplikasi akan mencoba menggunakan SQLite database padahal Docker compose setup untuk MySQL
- Database tidak akan tersinkronisasi dengan container MySQL
- Migrations tidak akan berjalan dengan benar
- Application akan fail saat mengakses database

**Root Cause**: 
.env file not properly configured for Docker environment. Default Laravel .env setting tidak di-override dengan konfigurasi yang sesuai.

**Solution Required**:
Update .env file dengan konfigurasi MySQL yang sesuai dengan docker-compose.yml

---

### ❌ Issue #2: Missing Routes in web.php
**File**: `routes/web.php`  
**Severity**: CRITICAL

**Problem**:
Current web.php hanya memiliki 1 route:
```php
Route::get('/', function () {
    return view('welcome');
});
```

Tetapi aplikasi memiliki beberapa controller dan views yang belum di-route:

1. **Missing Landing Page Route**
   - Controller: `App\Http\Controllers\Pages\LandingPageController`
   - Method: `index()`
   - Expected Route: `GET /`
   - View: `resources/views/pages/landing.blade.php`
   - Current: Route `/` mengarah ke `welcome` view

2. **Missing Pricing Page Route**
   - Controller: `App\Http\Controllers\Pages\PricingController`
   - Method: tidak ada (file kosong atau incomplete)
   - Expected Route: `GET /pricing`
   - View: `resources/views/pages/pricing.blade.php`

3. **Missing Dashboard Route**
   - Controller: `App\Http\Controllers\Dashboard\DashboardController`
   - Method: `index()`
   - Expected Route: `GET /dashboard` (protected with auth middleware)
   - View: `resources/views/dashboard.blade.php`
   - Current Impact: Authenticated users tidak bisa akses dashboard

4. **Missing Profile Routes**
   - Controller: `App\Http\Controllers\ProfileController`
   - Expected Routes:
     - `GET /profile` → `edit()` method → shows profile edit form
     - `PATCH /profile` → `update()` method → update user profile
     - `DELETE /profile` → `destroy()` method → delete user account
   - Views: `resources/views/profile/edit.blade.php` (exists)
   - Current Impact: Profile management tidak bisa diakses, causing ProfileTest failures

**Impact on Tests**:
- `tests/Feature/ProfileTest.php` akan fail karena routes `/profile` tidak ada
- Test `test_profile_page_is_displayed()` → 404 Not Found
- Test `test_profile_information_can_be_updated()` → 404 Not Found

**Root Cause**: 
Routes definition tidak completed. Hanya routing untuk auth tersedia, but main page routing incomplete.

**Solution Required**:
Define all missing routes dengan proper middleware dan controller methods

---

### ❌ Issue #3: User Model Missing Team Relationship
**File**: `app/Models/User.php`  
**Severity**: HIGH

**Problem**:
```php
// Current User model doesn't have:
public function teams()
{
    return $this->hasMany(Team::class);
}
```

Tetapi:
- `Team` model memiliki: `public function user(): BelongsTo`
- `DashboardController` menggunakan: `$user->teams()->get()`
- Database memiliki `user_id` foreign key di `teams` table

**Impact**:
- DashboardController akan crash dengan error: "Call to undefined method User::teams()"
- Dashboard tidak bisa diakses oleh authenticated users
- Leaderboard dan Player relationship chain akan broken

**Root Cause**: 
User model relationships tidak complete during development.

**Solution Required**:
Add `teams()` relationship method to User model

---

### ❌ Issue #4: Missing API Controllers
**File**: `routes/api.php` & `app/Http/Controllers/Api/` (folder kosong)  
**Severity**: HIGH

**Problem**:
```php
// routes/api.php references:
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/schedules', 'Api\ScheduleController@index');
    Route::post('/statistics', 'Api\StatisticController@store');
    Route::get('/leaderboard', 'Api\LeaderboardController@index');
    Route::get('/workouts', 'Api\WorkoutController@index');
});

// But app/Http/Controllers/Api/ folder is EMPTY
// These controllers don't exist:
// - Api/ScheduleController.php
// - Api/StatisticController.php
// - Api/LeaderboardController.php
// - Api/WorkoutController.php
```

**Impact**:
- API endpoints akan error 500 ketika diakses
- Frontend yang bergantung pada API akan fail
- Testing API endpoints akan fail

**Root Cause**: 
API controllers belum diimplementasikan

**Solution Required**:
Create all missing API controller files dengan proper methods and responses

---

### ❌ Issue #5: Doc Block Errors in Models
**File**: `app/Models/Team.php` (line 16) & `app/Models/Schedule.php` (line 17)  
**Severity**: MEDIUM

**Problem**:
```php
// In Team.php and Schedule.php:
/**
 * @property int $id
 * @property int $user_id
 * ...
 * @property timestamps  // ← WRONG! Should be @property \Carbon\Carbon $created_at
 */
```

Doc block error message:
```
Use of unknown class: 'App\Models\timestamps'
Missing variable name.
```

**Impact**:
- Code analysis tools (PHPStan, IDE) will show errors
- Auto-completion might not work properly
- Code quality analysis will fail

**Root Cause**: 
Incorrect doc block syntax. Should be:
```php
@property \Carbon\Carbon $created_at
@property \Carbon\Carbon $updated_at
```

**Solution Required**:
Fix doc block property declarations

---

### ❌ Issue #6: Missing PricingController Implementation
**File**: `app/Http/Controllers/Pages/PricingController.php`  
**Severity**: MEDIUM

**Problem**:
File exists tapi likely kosong atau incomplete. Pricing page harus menampilkan:
- Basic Plan (Rp 29.900 per bulan) - dari `PRICING_BASIC_PRICE` config
- Pro Plan (Rp 99.900 per bulan) - dari `PRICING_PRO_PRICE` config
- Feature list untuk setiap plan
- CTA buttons untuk sign up

**Impact**:
- `/pricing` route tidak bisa diakses
- Users tidak bisa melihat pricing information sebelum sign up

**Root Cause**: 
Controller not fully implemented

**Solution Required**:
Implement PricingController with proper view and configuration

---

### ❌ Issue #7: Incomplete Test Compatibility
**File**: Multiple test files dalam `tests/Feature/`  
**Severity**: HIGH

**Problem**:
Tests expect routes yang tidak ada:
- `ProfileTest.php` expects `GET /profile` and `PATCH /profile` routes
- Routes akan return 404, causing test failures

**Impact**:
- PHPUnit tests akan fail
- Cannot validate feature completeness through automated testing
- CI/CD pipelines akan fail

**Root Cause**: 
Routes not defined in web.php before tests were written

**Solution Required**:
Define all missing routes sebelum running tests

---

## ✅ Acceptance Criteria untuk Perbaikan

### Critical Issues (MUST FIX)
- [ ] .env database configuration diubah dari SQLite ke MySQL
- [ ] Route `/` mengarah ke LandingPageController@index (bukan welcome view)
- [ ] Route `/pricing` mengarah ke PricingController@index
- [ ] Routes `/dashboard`, `/profile`, dan profile update/delete routes didefinisikan
- [ ] User model memiliki `teams()` relationship
- [ ] All API controllers di `app/Http/Controllers/Api/` dibuat dengan basic implementation
- [ ] Web routes include auth routes properly
- [ ] Tests dapat dijalankan tanpa error

### Medium Issues (SHOULD FIX)
- [ ] Doc block errors di Team.php dan Schedule.php diperbaiki
- [ ] PricingController fully implemented
- [ ] All routes properly grouped dengan middleware
- [ ] Database migrations dapat dijalankan dengan `docker-compose exec laravel php artisan migrate`

### AWS Deployment Readiness (MUST FIX sebelum AWS deployment)
- [ ] Dockerfile dioptimasi untuk production (multi-stage build)
- [ ] Environment variables strategy untuk AWS (use AWS Secrets Manager recommendations)
- [ ] Database credentials tidak hardcoded, external configuration ready
- [ ] Session driver compatible dengan distributed environment (database/redis)
- [ ] Cache driver properly configured untuk production
- [ ] Logging configured untuk CloudWatch integration
- [ ] Error handling graceful tanpa exposing sensitive information
- [ ] CORS properly configured untuk CloudFront CDN
- [ ] Static assets path ready untuk S3/CloudFront migration
- [ ] Application stateless (no local file storage dependencies)

---

## ☁️ AWS Deployment Requirements

Aplikasi ini akan di-deploy ke AWS sebagai bagian dari tugas Cloud Computing. Sebelum deployment, pastikan aplikasi memenuhi requirements berikut:

### AWS Services yang Akan Digunakan
- **Amazon RDS** - Untuk MySQL database (replace docker-compose MySQL)
- **Amazon EC2** atau **AWS App Runner** - Untuk Laravel application hosting
- **Amazon S3** - Untuk file storage (jika diperlukan)
- **AWS CloudFront** - Untuk CDN static assets
- **AWS Route 53** - Untuk DNS management
- **AWS CloudWatch** - Untuk monitoring dan logging

### AWS-Specific Configuration Requirements
- [ ] Environment configuration untuk multiple AWS stages (development, staging, production)
- [ ] AWS IAM credentials configuration untuk S3 access (jika digunakan)
- [ ] RDS database endpoint configuration di .env.production
- [ ] AWS SES integration untuk email sending (production)
- [ ] CloudWatch logging integration
- [ ] Security groups configuration untuk RDS access
- [ ] Laravel APP_KEY harus unique untuk setiap environment
- [ ] CORS configuration untuk CloudFront CDN

### Docker & Container Requirements untuk AWS
- [ ] Dockerfile harus production-ready (multi-stage build optimized)
- [ ] docker-compose.yml berfungsi untuk local development
- [ ] Application ports dan health checks properly configured
- [ ] Environment variables tidak hardcoded dalam Docker image
- [ ] Volume management compatible dengan AWS ECS (jika menggunakan)

### SaaS Architecture Compliance
✅ **Requirements yang sudah ada**:
- Multi-tenant aware structure (team-based)
- Subscription/pricing model implementation
- User role & permission system
- REST API untuk multi-client support

⚠️ **Requirements yang perlu divalidasi**:
- [ ] Scalability readiness (stateless application)
- [ ] Database connection pooling untuk cloud
- [ ] Session management suitable untuk load-balanced environment
- [ ] Cache strategy (Redis recommended untuk production)
- [ ] Background job processing (SQS recommended)

---

## 🔍 Testing Checklist

```bash
# 1. Database Configuration
- [ ] Verify .env has correct MySQL settings
- [ ] Run migrations: php artisan migrate

# 2. Routes Testing
- [ ] GET / returns landing page (200)
- [ ] GET /pricing returns pricing page (200)
- [ ] GET /dashboard returns 302 redirect (unauthenticated)
- [ ] GET /login returns login page (200)
- [ ] GET /register returns registration page (200)

# 3. Authentication Testing
- [ ] POST /register creates user
- [ ] POST /login authenticates user
- [ ] GET /dashboard returns 200 (authenticated)
- [ ] GET /profile returns profile page (200)

# 4. API Testing
- [ ] GET /api/schedules returns 401 (unauthenticated)
- [ ] GET /api/schedules returns 200 (authenticated)

# 5. Unit Tests
- [ ] php artisan test passes all tests
- [ ] php artisan test --coverage shows >70% coverage

# 6. Docker Testing
- [ ] docker-compose up -d starts services
- [ ] http://localhost:8000 is accessible
- [ ] MySQL container is running and connected

# 7. AWS Readiness Testing
- [ ] Application works with RDS MySQL endpoint
- [ ] Environment variables properly externalized
- [ ] No hardcoded secrets in codebase
- [ ] Static assets can be served from S3/CloudFront
- [ ] Application is stateless (can scale horizontally)
- [ ] Database connections use proper pooling
- [ ] Logging properly configured for CloudWatch
- [ ] Error handling graceful in distributed environment
```

---

## 📋 File Checklist

File yang perlu dimodifikasi/dibuat:
- [ ] `.env` - Update database configuration
- [ ] `routes/web.php` - Add missing routes
- [ ] `app/Models/User.php` - Add teams() relationship
- [ ] `app/Http/Controllers/Pages/PricingController.php` - Implement controller
- [ ] `app/Http/Controllers/Api/ScheduleController.php` - Create file
- [ ] `app/Http/Controllers/Api/StatisticController.php` - Create file
- [ ] `app/Http/Controllers/Api/LeaderboardController.php` - Create file
- [ ] `app/Http/Controllers/Api/WorkoutController.php` - Create file
- [ ] `app/Models/Team.php` - Fix doc block
- [ ] `app/Models/Schedule.php` - Fix doc block

---

## 📚 Additional References

- Setup Instructions: [SETUP_INSTRUCTIONS.md](SETUP_INSTRUCTIONS.md)
- API Documentation: [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- Docker Compose Config: [docker-compose.yml](docker-compose.yml)

---

## 🚀 AWS Deployment Roadmap

Setelah semua issues diperbaiki, berikut adalah roadmap untuk deployment ke AWS:

### Phase 1: Pre-Deployment (Setelah semua issues fixed)
1. Setup AWS account dan configure IAM roles
2. Create Amazon RDS MySQL instance
3. Create security groups untuk EC2 dan RDS communication
4. Configure AWS Secrets Manager untuk credentials management
5. Setup CI/CD pipeline (GitHub Actions + AWS CodeDeploy atau AWS CodePipeline)

### Phase 2: Infrastructure Setup
1. Create Amazon EC2 instances atau use AWS App Runner
2. Configure load balancer (ALB/NLB)
3. Setup Amazon CloudFront untuk static assets
4. Configure Route 53 DNS
5. Create S3 bucket untuk file storage (jika diperlukan)

### Phase 3: Application Deployment
1. Build Docker image dengan production optimization
2. Push image ke Amazon ECR (Elastic Container Registry)
3. Deploy ke EC2/App Runner
4. Run database migrations di RDS
5. Configure environment variables via AWS Systems Manager Parameter Store atau Secrets Manager

### Phase 4: Monitoring & Optimization
1. Setup CloudWatch monitoring
2. Configure AWS Auto Scaling
3. Enable AWS WAF untuk security
4. Setup automated backups untuk RDS
5. Configure CloudWatch alarms untuk critical metrics

### AWS Cost Optimization Tips (SaaS Requirements)
- Use AWS RDS reserved instances untuk cost saving
- Configure auto-scaling berdasarkan demand
- Use CloudFront untuk reducing bandwidth costs
- Enable AWS S3 lifecycle policies untuk old data
- Monitor dengan AWS Cost Explorer dan Budgets

---

## 🎯 Next Steps

1. **Priority 1**: Fix critical database configuration issue
2. **Priority 2**: Define all missing routes
3. **Priority 3**: Implement missing relationships and controllers
4. **Priority 4**: Fix doc block errors
5. **Priority 5**: Run full test suite and validate
6. **Priority 6**: Prepare for AWS deployment (Dockerfile optimization, env strategy)
7. **Priority 7**: Deploy to AWS (development/staging environment first)

---

## 📝 Catatan Tester

**Testing dilakukan pada**: 5 May 2026
**Tester**: AI Testing Agent
**Environment**: Windows, Laravel 12, Docker Compose
**Deployment Target**: AWS (Amazon Web Services)
**Course**: Cloud Computing Semester 6 - SaaS Implementation

Aplikasi belum dapat dijalankan dengan proper state. Prioritas perbaikan adalah:
1. Database configuration (critical)
2. Routes definition (critical)
3. Model relationships (high)
4. API controllers (high)
5. Code quality fixes (medium)
6. AWS deployment readiness (critical untuk cloud deployment)

Semua issues ini MUST diperbaiki sebelum aplikasi dapat diterima untuk:
- ✅ Local development testing
- ✅ Production-level acceptance
- ✅ AWS cloud deployment

**AWS Deployment Considerations**:
- Aplikasi dirancang untuk SaaS multi-tenant architecture
- Docker containerization ready untuk AWS ECS/App Runner deployment
- MySQL database akan menggunakan Amazon RDS
- Static assets akan di-serve dari S3/CloudFront
- Logging akan diintegrasikan dengan CloudWatch
- Application harus stateless untuk horizontal scaling di AWS

---

## 🔗 Related Issues & Documentation
- Original Build Issue: [GITHUB_ISSUE_VOLLEYTRACK.md](GITHUB_ISSUE_VOLLEYTRACK.md)
- Previous Updates: [issueterbaru.md](issueterbaru.md)
- Testing Summary: [TESTING_SUMMARY.md](TESTING_SUMMARY.md)
- Setup Instructions: [SETUP_INSTRUCTIONS.md](SETUP_INSTRUCTIONS.md)
- Docker Configuration: [docker-compose.yml](docker-compose.yml)
- Dockerfile: [Dockerfile](Dockerfile)

### AWS Related Documentation to Create
- [ ] AWS_DEPLOYMENT_GUIDE.md - Step-by-step AWS deployment instructions
- [ ] AWS_ARCHITECTURE.md - Infrastructure diagram dan architecture decision records
- [ ] ENVIRONMENT_CONFIGURATION.md - Environment variable strategy untuk AWS

