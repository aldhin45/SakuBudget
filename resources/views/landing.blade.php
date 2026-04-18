<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SakuBudget</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f9fc;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Background Gradient Area */
        .background-gradient {
            background: linear-gradient(180deg, #004c70 0%, #0077a6 40%, #a6dcf0 100%);
            padding-bottom: 50px;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 0;
            color: white;
        }

        .logo {
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .link-masuk {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .divider {
            color: white;
            opacity: 0.5;
        }

        .btn-daftar {
            color: white;
            text-decoration: none;
            border: 1px solid white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-daftar:hover {
            background-color: white;
            color: #004c70;
        }

        /* Hero Section */
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 60px 0 80px 0;
            color: white;
        }

        .hero-content {
            flex: 1;
            max-width: 550px;
        }

        .hero-content h1 {
            font-size: 42px;
            line-height: 1.2;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .hero-content p {
            font-size: 16px;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .btn-mulai {
            display: inline-block;
            background-color: #ff9800;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.4);
            transition: 0.3s;
        }

        .btn-mulai:hover {
            background-color: #e68a00;
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        .outline-wallet {
            font-size: 180px;
            color: transparent;
            -webkit-text-stroke: 4px white;
            opacity: 0.9;
        }

        /* Features Section */
        .features {
            padding: 40px 0 80px 0;
            background: linear-gradient(to bottom, transparent, #ffffff);
            margin-top: -30px;
        }

        .features h2 {
            color: #003b5c;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .feature-card {
            background-color: white;
            padding: 25px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .feature-card .icon {
            font-size: 28px;
            color: #003b5c;
        }

        .card-text h3 {
            color: #003b5c;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .card-text p {
            color: #666;
            font-size: 12px;
            line-height: 1.5;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                text-align: center;
                gap: 50px;
            }
            
            .hero-content {
                max-width: 100%;
            }

            .hero-image {
                justify-content: center;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .features h2 {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="background-gradient">
        <div class="container">
            <header class="navbar">
                <div class="logo">
                    <i class="fa-solid fa-earth-americas"></i>
                    <i class="fa-solid fa-wallet" style="margin-left: -8px;"></i>
                    <span>SakuBudget</span>
                </div>
                <div class="nav-links">
                    <a href="{{ route('login') }}" class="link-masuk">Masuk</a>
                    <span class="divider">|</span>
                    <a href="{{ route('register') }}" class="btn-daftar">Daftar</a>
                </div>
            </header>

            <section class="hero">
                <div class="hero-content">
                    <h1>Kelola Keuangan Harianmu dengan Lebih Cerdas</h1>
                    <p>Aplikasi budgeting dengan notifikasi & analisis kesehatan finansial</p>
                    <a href="{{ route('login') }}" class="btn-mulai">Mulai Sekarang</a>
                </div>
                <div class="hero-image">
                    <i class="fa-solid fa-wallet outline-wallet"></i>
                </div>
            </section>
        </div>
    </div>

    <section class="features">
        <div class="container">
            <h2>Kenapa memilih SakuBudget ?</h2>
            <div class="features-grid">
                
                <div class="feature-card">
                    <div class="icon"><i class="fa-solid fa-puzzle-piece"></i></div>
                    <div class="card-text">
                        <h3>Rule-Based<br>Budgeting</h3>
                        <p>Berikan peringatan otomatis saat pengeluaran mendekati batas anggaran</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="icon"><i class="fa-regular fa-bell"></i></div>
                    <div class="card-text">
                        <h3>Notifikasi<br>Otomatis</h3>
                        <p>Notifikasi real-time ketika anggaran hampir habis</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="icon"><i class="fa-solid fa-chart-line"></i></div>
                    <div class="card-text">
                        <h3>Analisis<br>Finansial</h3>
                        <p>Berikan peringatan otomatis saat pengeluaran mendekati batas anggaran</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="icon"><i class="fa-regular fa-clock"></i></div>
                    <div class="card-text">
                        <h3>Tracking<br>Real-time</h3>
                        <p>Berikan peringatan otomatis saat pengeluaran mendekati batas anggaran</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
</body>
</html>