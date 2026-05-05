# 📋 INSTRUKSI UNTUK AI JUNIOR PROGRAMMER - VolleyTrack Fix & AWS Deployment

**Date Issued**: 5 May 2026  
**Priority**: 🔴 CRITICAL  
**Deadline**: [Specify deadline]  
**Status**: Awaiting Implementation

---

## 🎯 TASK SUMMARY

Aplikasi VolleyTrack SaaS memiliki 7 critical issues yang harus diperbaiki. Setelah perbaikan, aplikasi akan di-deploy ke AWS sebagai bagian dari tugas Cloud Computing Semester 6.

---

## 📂 REFERENCE DOCUMENTS (BACA DAHULU)

**PRIORITAS BACA (dalam urutan ini):**

1. **[GITHUB_ISSUE_TESTING_RESULTS.md](GITHUB_ISSUE_TESTING_RESULTS.md)** ⭐ **MASTER ISSUE**
   - Baca ini TERLEBIH DAHULU
   - Berisi detailed explanation dari setiap issue
   - Acceptance criteria untuk fix
   - AWS deployment requirements
   - Estimated time: 30-45 menit untuk baca penuh

2. **[TESTING_SUMMARY.md](TESTING_SUMMARY.md)** ⭐ **QUICK REFERENCE**
   - Ringkasan 7 issues dalam format tabel
   - AWS architecture diagram
   - Priority order untuk fixes
   - Estimated time: 5 menit

3. **[AWS_DEPLOYMENT_GUIDE.md](AWS_DEPLOYMENT_GUIDE.md)** ✅ **UNTUK NANTI**
   - Panduan deployment ke AWS
   - Baca setelah semua local fixes selesai
   - Diperlukan untuk Phase 2
   - Estimated time: 1-2 jam untuk implementasi

4. **[SETUP_INSTRUCTIONS.md](SETUP_INSTRUCTIONS.md)** ✅ **EXISTING DOCS**
   - Sudah ada, reference untuk setup

---

## 🔴 CRITICAL ISSUES TO FIX (PRIORITAS 1-5)

### **ISSUE #1: Database Configuration** 🔴 CRITICAL - Est. 15 min

**File**: `.env`

**What to do**:
```env
# CHANGE FROM:
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

# CHANGE TO:
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=volleytrack_db
DB_USERNAME=volleytrack_user
DB_PASSWORD=volleytrack_password
```

**Test**: 
```bash
php artisan migrate:fresh --seed
```

**Acceptance**: Migrations run successfully, database populated with seed data

---

### **ISSUE #2: Missing Routes** 🔴 CRITICAL - Est. 30 min

**File**: `routes/web.php`

**Current state**: Only has welcome route

**What to add**:
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\LandingPageController;
use App\Http\Controllers\Pages\PricingController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

// Protected routes (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include auth routes
require __DIR__.'/auth.php';
```

**Test**:
```bash
php artisan route:list
# Verify all routes listed above exist
```

**Acceptance**: 
- GET / returns landing page (200)
- GET /pricing returns pricing page (200)
- GET /dashboard requires auth
- GET /profile requires auth
- All routes visible in `route:list`

---

### **ISSUE #3: User Model Missing Relationship** 🔴 CRITICAL - Est. 10 min

**File**: `app/Models/User.php`

**What to add** (add before closing brace):
```php
use Illuminate\Database\Eloquent\Relations\HasMany;

// Add this method:
public function teams(): HasMany
{
    return $this->hasMany(Team::class);
}
```

**Test**:
```bash
php artisan tinker
> $user = User::first();
> $user->teams()->count();
# Should return integer without error
```

**Acceptance**: Method exists and callable without errors

---

### **ISSUE #4: Missing API Controllers** 🔴 CRITICAL - Est. 1-1.5 hours

**File**: Create 4 controllers in `app/Http/Controllers/Api/`

#### 4a. `ScheduleController.php`
```php
<?php

namespace App\Http\Controllers\Api;

use App\Models\Schedule;
use Illuminate\Http\JsonResponse;

class ScheduleController
{
    public function index(): JsonResponse
    {
        $schedules = Schedule::all();
        return response()->json(['data' => $schedules]);
    }
}
```

#### 4b. `StatisticController.php`
```php
<?php

namespace App\Http\Controllers\Api;

use App\Models\PlayerStatistic;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StatisticController
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'spike' => 'integer',
            'block' => 'integer',
            'ace' => 'integer',
        ]);

        $stat = PlayerStatistic::create($validated);
        return response()->json(['data' => $stat], 201);
    }
}
```

#### 4c. `LeaderboardController.php`
```php
<?php

namespace App\Http\Controllers\Api;

use App\Models\Leaderboard;
use Illuminate\Http\JsonResponse;

class LeaderboardController
{
    public function index(): JsonResponse
    {
        $leaderboard = Leaderboard::orderBy('rank')->get();
        return response()->json(['data' => $leaderboard]);
    }
}
```

#### 4d. `WorkoutController.php`
```php
<?php

namespace App\Http\Controllers\Api;

use App\Models\Workout;
use Illuminate\Http\JsonResponse;

class WorkoutController
{
    public function index(): JsonResponse
    {
        $workouts = Workout::all();
        return response()->json(['data' => $workouts]);
    }
}
```

**Test**:
```bash
php artisan tinker
> $response = app('Illuminate\Http\Request')->get('/api/schedules');
# Or use Postman to test endpoints

# Also run:
php artisan route:list | grep api
```

**Acceptance**: 
- All 4 controller files exist
- API routes return 200 with JSON response (when authenticated)
- No 500 errors

---

### **ISSUE #5: Doc Block Errors** 🟡 MEDIUM - Est. 10 min

**File 1**: `app/Models/Team.php` (line 16)

**CHANGE FROM**:
```php
 * @property timestamps
```

**CHANGE TO**:
```php
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
```

**File 2**: `app/Models/Schedule.php` (line 17)

**CHANGE FROM**:
```php
 * @property timestamps
```

**CHANGE TO**:
```php
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
```

**Test**:
```bash
# IDE should not show red errors in these files
# Or run PHPStan if available
./vendor/bin/phpstan analyze app/Models/Team.php
./vendor/bin/phpstan analyze app/Models/Schedule.php
```

**Acceptance**: No PHPDoc errors in IDE

---

### **ISSUE #6: Implement PricingController** 🟡 MEDIUM - Est. 20 min

**File**: `app/Http/Controllers/Pages/PricingController.php`

**Implementation**:
```php
<?php

namespace App\Http\Controllers\Pages;

use Illuminate\View\View;
use Illuminate\Support\Facades\Config;

class PricingController
{
    /**
     * Show the pricing page
     */
    public function index(): View
    {
        $plans = [
            'basic' => [
                'name' => 'Basic Plan',
                'price' => Config::get('pricing.basic_price', 29900),
                'period' => 'monthly',
                'description' => 'For individuals',
                'features' => [
                    'Individual player tracking',
                    'Schedule management',
                    'Basic statistics',
                    'Email support',
                ]
            ],
            'pro' => [
                'name' => 'Pro Plan',
                'price' => Config::get('pricing.pro_price', 99900),
                'period' => 'monthly',
                'description' => 'For teams',
                'features' => [
                    'Team management (unlimited members)',
                    'Advanced statistics',
                    'Leaderboard',
                    'Workout recommendations',
                    'Priority support',
                    'API access',
                ]
            ]
        ];

        return view('pages.pricing', ['plans' => $plans]);
    }
}
```

**Test**:
```bash
php artisan route:list | grep pricing
curl http://localhost:8000/pricing
```

**Acceptance**: GET /pricing returns 200 with pricing page view

---

### **ISSUE #7: Test Compatibility** 🔴 CRITICAL - Est. 15 min

**What to test**:
```bash
php artisan test

# Expected output: All tests PASS
# If ProfileTest fails, it means routes are not working
```

**Acceptance**: `php artisan test` returns all tests passing (PASS status)

---

## ✅ PHASE 1 ACCEPTANCE CRITERIA

### Before marking as COMPLETE:

- [ ] **Database**: 
  - [ ] .env has MySQL config
  - [ ] `php artisan migrate:fresh --seed` runs without errors
  - [ ] Database populated with seed data

- [ ] **Routes**: 
  - [ ] `php artisan route:list` shows all 5+ routes
  - [ ] GET / returns 200
  - [ ] GET /pricing returns 200
  - [ ] GET /dashboard redirects to login (302)

- [ ] **Models**: 
  - [ ] User::teams() relationship exists
  - [ ] No doc block errors in IDE

- [ ] **API Controllers**: 
  - [ ] 4 controllers created in Api/
  - [ ] API routes work without 500 errors

- [ ] **Tests**: 
  - [ ] `php artisan test` passes 100%
  - [ ] No test failures

- [ ] **Docker**: 
  - [ ] `docker-compose up -d` works
  - [ ] http://localhost:8000 accessible
  - [ ] Application responsive

---

## 🔍 TESTING CHECKLIST (Wajib Dilakukan)

Sebelum declare "DONE", jalankan:

```bash
# 1. Database
php artisan migrate:fresh --seed
echo "✓ Migrations and seeding successful"

# 2. Routes
php artisan route:list | grep -E "GET|POST|PATCH|DELETE"
echo "✓ All routes visible"

# 3. Models
php artisan tinker
# $user = User::first(); $user->teams()->count();
echo "✓ User relationship works"

# 4. Tests
php artisan test
echo "✓ All tests passing"

# 5. Docker
docker-compose ps
echo "✓ Containers running"

# 6. Application
curl http://localhost:8000
echo "✓ Application accessible"
```

---

## 📊 TIME ESTIMATE

| Issue | Time | Status |
|-------|------|--------|
| #1: Database Config | 15 min | |
| #2: Missing Routes | 30 min | |
| #3: User Relationship | 10 min | |
| #4: API Controllers | 60 min | |
| #5: Doc Blocks | 10 min | |
| #6: PricingController | 20 min | |
| #7: Test Compat | 15 min | |
| **Testing & QA** | **30 min** | |
| **TOTAL** | **2.5-3 hours** | |

---

## 🚀 PHASE 2: AWS DEPLOYMENT (SETELAH PHASE 1 SELESAI)

**Jangan mulai Phase 2 sampai Phase 1 100% selesai!**

Setelah Phase 1 complete, reference file:
- **[AWS_DEPLOYMENT_GUIDE.md](AWS_DEPLOYMENT_GUIDE.md)**

Phase 2 includes:
- AWS account setup
- RDS MySQL creation
- EC2 instance configuration
- Application deployment
- CloudWatch monitoring

---

## 📞 QUESTIONS? 

Jika ada yang tidak jelas:
1. Baca [GITHUB_ISSUE_TESTING_RESULTS.md](GITHUB_ISSUE_TESTING_RESULTS.md) untuk detail lengkap
2. Lihat [TESTING_SUMMARY.md](TESTING_SUMMARY.md) untuk quick reference
3. Check specific issue section di atas untuk implementation details

---

## ✨ DELIVERABLES EXPECTED

Setelah selesai, siapkan:
- [ ] Code changes committed ke Git
- [ ] All tests passing
- [ ] Documentation updated (if any)
- [ ] Ready for AWS deployment
- [ ] Brief summary of changes made

---

**GOOD LUCK! 🎯**

**Mulai dari**: [GITHUB_ISSUE_TESTING_RESULTS.md](GITHUB_ISSUE_TESTING_RESULTS.md)  
**Priority**: 🔴 CRITICAL - Start dengan Issue #1-#4  
**Target Completion**: Same day if possible

