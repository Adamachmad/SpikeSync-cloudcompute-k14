<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harga - VolleyTrack</title>
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
        }

        .navbar {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #003d6b 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .pricing-header {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #003d6b 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
        }

        .pricing-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .pricing-section {
            padding: 80px 20px;
            background: var(--light-bg);
        }

        .pricing-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            margin: 20px auto;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            max-width: 400px;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .pricing-card.popular {
            border: 3px solid var(--primary-color);
            transform: scale(1.05);
        }

        .pricing-header-card {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #003d6b 100%);
            color: white;
            padding: 40px 20px;
            position: relative;
        }

        .pricing-header-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .price {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .price-period {
            font-size: 1rem;
            opacity: 0.8;
        }

        .popular-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--primary-color);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .pricing-body {
            padding: 40px 20px;
        }

        .price-description {
            color: #666;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin-bottom: 30px;
        }

        .features-list li {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
        }

        .features-list li i {
            color: var(--primary-color);
            margin-right: 15px;
            font-size: 1.1rem;
        }

        .cta-button {
            width: 100%;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cta-button.primary {
            background: var(--primary-color);
            color: white;
        }

        .cta-button.primary:hover {
            background: #ff5a1f;
            transform: translateY(-2px);
        }

        .cta-button.secondary {
            background: var(--secondary-color);
            color: white;
        }

        .cta-button.secondary:hover {
            background: #003d6b;
            transform: translateY(-2px);
        }

        .comparison-table {
            background: white;
            border-radius: 15px;
            padding: 40px;
            margin-top: 60px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .comparison-table h3 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--secondary-color);
            font-weight: 700;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: #f8f9fa;
        }

        .table th, .table td {
            vertical-align: middle;
            padding: 15px;
            border-color: #e9ecef;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        footer {
            background: var(--secondary-color);
            color: white;
            padding: 40px 20px;
            margin-top: 60px;
        }

        @media (max-width: 768px) {
            .pricing-card.popular {
                transform: scale(1);
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
                        <a class="nav-link" href="/">Home</a>
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
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="pricing-header">
        <div class="container">
            <h1>Pilih Paket Premium</h1>
            <p style="font-size: 1.1rem; margin-bottom: 0;">Akses penuh ke semua fitur VolleyTrack dengan harga terjangkau</p>
        </div>
    </div>

    <!-- Pricing Cards -->
    <section class="pricing-section">
        <div class="container">
            <div class="row justify-content-center">
                @foreach($plans as $plan)
                    <div class="col-lg-6 col-md-8">
                        <div class="pricing-card {{ $plan['is_popular'] ? 'popular' : '' }}">
                            <div class="pricing-header-card">
                                @if($plan['is_popular'])
                                    <div class="popular-badge">
                                        <i class="fas fa-star"></i> PALING DIMINATI
                                    </div>
                                @endif
                                <h3>{{ $plan['name'] }}</h3>
                                <p class="price-description">{{ $plan['description'] }}</p>
                                <div class="price">
                                    Rp {{ number_format($plan['price']) }}
                                </div>
                                <div class="price-period">{{ $plan['billing_period'] }}</div>
                            </div>

                            <div class="pricing-body">
                                <ul class="features-list">
                                    @foreach($plan['features'] as $feature)
                                        <li>
                                            <i class="fas fa-check-circle"></i>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>

                                @auth
                                    <a href="/dashboard" class="cta-button {{ $plan['is_popular'] ? 'primary' : 'secondary' }}">
                                        {{ $plan['cta_text'] }}
                                    </a>
                                @else
                                    <a href="/register" class="cta-button {{ $plan['is_popular'] ? 'primary' : 'secondary' }}">
                                        {{ $plan['cta_text'] }}
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Comparison Table -->
            <div class="comparison-table">
                <h3>Perbandingan Paket Fitur</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fitur</th>
                                <th class="text-center">Basic</th>
                                <th class="text-center">Pro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Manajemen Jadwal</td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>Tracking Statistik Individual</td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>Workout Recommendations</td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>Manajemen Tim</td>
                                <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>Global Leaderboard</td>
                                <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>API Access</td>
                                <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td>Priority Support</td>
                                <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

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
