 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VolleyTrack - Kelola Bola Voli Profesional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #004E89;
            --light-bg: #F7F7F7;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #003d6b 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #003d6b 100%);
            color: white;
            padding: 100px 20px;
            text-align: center;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .hero-button {
            background: var(--primary-color);
            color: white;
            padding: 12px 40px;
            font-size: 1.1rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .hero-button:hover {
            background: #ff5a1f;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255,107,53,0.3);
        }

        /* Features Section */
        .features {
            padding: 80px 20px;
            background: var(--light-bg);
        }

        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            margin: 20px 0;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #ff8c5a 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
            margin: 60px 0;
            border-radius: 15px;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* Footer */
        footer {
            background: var(--secondary-color);
            color: white;
            padding: 40px 20px;
            margin-top: 60px;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-volleyball"></i> VolleyTrack
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pricing">Harga</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button class="nav-link btn btn-link" type="submit">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">Daftar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1>🏐 VolleyTrack SaaS</h1>
            <p>Platform Manajemen Bola Voli Profesional untuk Team Impian Anda</p>
            <a href="/pricing" class="hero-button">Mulai Sekarang</a>
        </div>
    </div>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 50px; color: var(--secondary-color);">
                Fitur Unggulan VolleyTrack
            </h2>

            <div class="row">
                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3 class="feature-title">Manajemen Jadwal</h3>
                        <p>Kelola jadwal latihan & pertandingan tim Anda dengan mudah dalam satu dashboard terpusat</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <h3 class="feature-title">Workout Recommendations</h3>
                        <p>Dapatkan rekomendasi latihan fisik yang dipersonalisasi untuk pemain voli profesional</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h3 class="feature-title">Tracking Statistik</h3>
                        <p>Pantau performa pemain dengan metrik komprehensif (Spike, Block, Ace, Pass Accuracy)</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h3 class="feature-title">Global Leaderboard</h3>
                        <p>Lihat ranking pemain & tim secara real-time dengan sistem poin komprehensif</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <div class="container">
        <div class="cta-section">
            <h2>Siap Tingkatkan Performa Tim?</h2>
            <p style="font-size: 1.1rem; margin-bottom: 30px;">Bergabunglah dengan ribuan klub voli yang sudah menggunakan VolleyTrack</p>
            <a href="/pricing" class="btn btn-light btn-lg" style="color: var(--primary-color); font-weight: 600;">
                Lihat Paket Harga
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>VolleyTrack SaaS</h5>
                    <p>Solusi manajemen bola voli modern untuk tim profesional</p>
                </div>
                <div class="col-md-4">
                    <h5>Links</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li><a href="/" style="color: white; text-decoration: none;">Home</a></li>
                        <li><a href="/pricing" style="color: white; text-decoration: none;">Harga</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p>Email: support@volleytrack.test<br>
                    Phone: +62-XXX-XXXX-XXXX</p>
                </div>
            </div>
            <hr style="background: rgba(255,255,255,0.3);">
            <p style="text-align: center; margin: 0;">© 2025 VolleyTrack. All rights reserved. • Cloud Computing Semester 6</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
