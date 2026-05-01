# ✅ VolleyTrack Project - Setup Instructions

## 🎯 Quick Start Guide

### Prerequisites
- Docker & Docker Compose installed
- Port 8000, 3306, 9000 available
- Minimum 2GB RAM for containers

### Fastest Setup (Recommended)

```bash
# 1. Clone atau cd ke project directory
cd /path/to/volleytrack

# 2. Copy environment
cp .env.example .env

# 3. Build dan jalankan Docker containers
docker-compose up -d

# 4. Run migrations dan seeder
docker-compose exec laravel php artisan migrate:fresh --seed

# 5. Access aplikasi
# Frontend: http://localhost:8000
# Dashboard: http://localhost:8000/dashboard
```

**Credentials untuk testing:**
- Email: `adam@volleytrack.test`
- Password: `password123`

---

## 📁 File Structure Created

### ✅ Models (7 files)
- `app/Models/User.php` - User dengan roles & subscription
- `app/Models/Team.php` - Team management
- `app/Models/Player.php` - Player data
- `app/Models/Schedule.php` - Jadwal latihan/pertandingan
- `app/Models/PlayerStatistic.php` - Statistik pemain
- `app/Models/Leaderboard.php` - Ranking system
- `app/Models/Workout.php` - Library latihan

### ✅ Migrations (7 files)
- `database/migrations/2024_05_01_000001_create_users_table.php`
- `database/migrations/2024_05_01_000002_create_teams_table.php`
- `database/migrations/2024_05_01_000003_create_players_table.php`
- `database/migrations/2024_05_01_000004_create_schedules_table.php`
- `database/migrations/2024_05_01_000005_create_player_statistics_table.php`
- `database/migrations/2024_05_01_000006_create_leaderboards_table.php`
- `database/migrations/2024_05_01_000007_create_workouts_table.php`

### ✅ Controllers (5 controller files)
- `app/Http/Controllers/Pages/LandingPageController.php`
- `app/Http/Controllers/Pages/PricingController.php`
- `app/Http/Controllers/Dashboard/DashboardController.php`
- `app/Http/Controllers/Schedules/ScheduleController.php`
- `app/Http/Controllers/Players/PlayerStatisticController.php`
- `app/Http/Controllers/Leaderboards/LeaderboardController.php`
- `app/Http/Controllers/Workouts/WorkoutController.php`

### ✅ CLI Commands (2 commands)
- `app/Console/Commands/FetchWorkoutCommand.php` - `php artisan volley:fetch-workout`
- `app/Console/Commands/GenerateLeaderboardCommand.php` - `php artisan volley:generate-leaderboard`
- `app/Console/Kernel.php` - Scheduler configuration

### ✅ Services
- `app/Services/ExerciseApiService.php` - API integration untuk ExerciseDB

### ✅ Views (2 page views)
- `resources/views/pages/landing.blade.php` - Landing page
- `resources/views/pages/pricing.blade.php` - Pricing page

### ✅ Configuration Files
- `.env` - Development environment
- `.env.example` - Template environment
- `.gitignore` - Git ignore rules
- `config/services.php` - External API config
- `config/pricing.php` - Pricing configuration

### ✅ Docker Files
- `Dockerfile` - Laravel container
- `docker-compose.yml` - Service orchestration
- `docker/nginx/default.conf` - Nginx configuration
- `docker/php/php.ini` - PHP configuration
- `docker/mysql/init.sql` - MySQL initialization
- `docker-entrypoint.sh` - Docker entrypoint

### ✅ Routes
- `routes/web.php` - Web routes
- `routes/api.php` - API routes
- `routes/auth.php` - Authentication routes

### ✅ Database
- `database/seeders/DatabaseSeeder.php` - Sample data seeder

### ✅ Documentation
- `README.md` - Main documentation
- `API_DOCUMENTATION.md` - API reference
- `SETUP_INSTRUCTIONS.md` - This file!

---

## 🔧 Available Commands

### Docker Commands
```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f laravel

# Run command in container
docker-compose exec laravel php artisan <command>

# Rebuild containers
docker-compose build --no-cache
```

### Laravel Artisan Commands
```bash
# Database
php artisan migrate               # Run migrations
php artisan migrate:fresh         # Reset & migrate
php artisan db:seed              # Seed sample data
php artisan db:seed --class=DatabaseSeeder

# Custom Commands
php artisan volley:fetch-workout          # Fetch workout data
php artisan volley:fetch-workout --force  # Force refresh
php artisan volley:generate-leaderboard   # Generate leaderboard

# Server
php artisan serve                        # Start dev server
php artisan schedule:work               # Run scheduler

# Cache & Queue
php artisan cache:clear
php artisan queue:work
```

---

## 🧪 Testing Commands

### Verify Installation
```bash
# Check all services
docker-compose ps

# Test MySQL connection
docker-compose exec laravel mysql -h mysql -u volleytrack_user -p volleytrack_db -e "SELECT 1;"

# Test Laravel
docker-compose exec laravel php artisan tinker

# In tinker:
>>> User::count()
>>> Team::count()
>>> Schedule::count()
```

### Run CLI Commands
```bash
# Fetch workouts
docker-compose exec laravel php artisan volley:fetch-workout

# Generate leaderboard
docker-compose exec laravel php artisan volley:generate-leaderboard

# Check scheduler
docker-compose exec laravel php artisan schedule:work
```

---

## 📊 Sample Data Included

After running `db:seed`, database berisi:
- **2 Users**: Adam (Pro), John Coach (Pro)
- **2 Teams**: Spike Masters (Pro), Ace Warriors (Basic)
- **12 Players**: 6 per team dengan posisi berbeda
- **2 Schedules**: Latihan reguler & pertandingan uji coba
- **18 Statistics**: 3 records per player
- **6 Leaderboards**: Ranking per team
- **5 Workouts**: Sample exercises untuk voli

---

## 🚀 Next Steps

### Phase 2.3: CTA & Sign Up Flow
- [ ] Create sign-up form view
- [ ] Implement plan selection
- [ ] Add subscription logic

### Phase 5: Optimization & Testing
- [ ] Create remaining views (dashboard, schedules, stats)
- [ ] Add form validation
- [ ] Implement error handling
- [ ] Performance optimization

### Phase 6: Deployment
- [ ] Setup production environment
- [ ] Configure SSL/HTTPS
- [ ] Setup monitoring
- [ ] Database backups

---

## 🆘 Troubleshooting

### Containers won't start
```bash
# Check for port conflicts
lsof -i :8000
lsof -i :3306

# Force clean restart
docker-compose down -v
docker-compose up -d
```

### Migration fails
```bash
# Reset database
docker-compose exec laravel php artisan migrate:refresh

# Or manually drop tables
docker-compose exec mysql mysql -u root -p123 volleytrack_db -e "DROP DATABASE volleytrack_db; CREATE DATABASE volleytrack_db;"
```

### API key not working
```bash
# Check .env
docker-compose exec laravel cat .env | grep API

# Get ExerciseDB key from:
# https://rapidapi.com/api-sports/api/api-sports
```

---

## 📞 Support Resources

- **Laravel Docs**: https://laravel.com/docs/12.x
- **Docker Docs**: https://docs.docker.com/
- **MySQL Docs**: https://dev.mysql.com/doc/
- **ExerciseDB API**: https://rapidapi.com/api-sports/api/api-sports

---

**Status**: ✅ Ready for Development  
**Last Updated**: May 1, 2025  
**Version**: 1.0.0
