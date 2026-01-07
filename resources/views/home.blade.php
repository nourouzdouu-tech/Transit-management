<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IPSEN Group Transit Maroc</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-dark: #003d80;
            --primary-medium: #0052a6;
            --primary-light: #0066cc;
            --bg-light: #e6f2ff;
            --bg-ultra-light: #f0f8ff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background: linear-gradient(135deg, var(--bg-ultra-light) 0%, var(--bg-light) 100%);
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(0, 61, 128, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--bg-light);
            transform: translateY(-2px);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-light);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 50%, var(--primary-light) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            animation: moveGrid 20s linear infinite;
        }

        @keyframes moveGrid {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .hero-content {
            text-align: center;
            color: white;
            z-index: 2;
            max-width: 800px;
            padding: 0 2rem;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 1rem;
            opacity: 0;
            animation: slideInUp 1s ease 0.5s forwards;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0;
            animation: slideInUp 1s ease 0.7s forwards;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            opacity: 0;
            animation: slideInUp 1s ease 0.9s forwards;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: white;
            color: var(--primary-dark);
        }

        .btn-primary:hover {
            background: var(--bg-light);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: white;
            color: var(--primary-dark);
            transform: translateY(-3px);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Floating Elements */
        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
        .floating-element:nth-child(2) { top: 60%; right: 15%; animation-delay: 2s; }
        .floating-element:nth-child(3) { bottom: 20%; left: 20%; animation-delay: 4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Services Section */
        .services {
            padding: 6rem 2rem;
            background: var(--bg-ultra-light);
        }

        .services-container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .services h2 {
            font-size: 3rem;
            color: var(--primary-dark);
            margin-bottom: 3rem;
            opacity: 0;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .service-card {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 61, 128, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            opacity: 0;
            transform: translateY(30px);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 61, 128, 0.2);
        }

        .service-icon {
            font-size: 3rem;
            color: var(--primary-light);
            margin-bottom: 1rem;
        }

        .service-card h3 {
            font-size: 1.5rem;
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .service-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            padding: 4rem 2rem;
            background: var(--primary-dark);
            color: white;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            text-align: center;
        }

        .stat-item {
            opacity: 0;
            transform: scale(0.8);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: var(--primary-light);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background: var(--primary-dark);
            color: white;
            padding: 3rem 2rem 1rem;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer h4 {
            color: var(--primary-light);
            margin-bottom: 1rem;
        }

        .footer p, .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            line-height: 1.6;
        }

        .footer a:hover {
            color: white;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .nav-links {
                display: none;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .services h2 {
                font-size: 2rem;
            }
        }

        /* Scroll animations */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.6s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">IPSEN GROUP</a>
            <ul class="nav-links">
                <li><a href="#accueil">Acceuil</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">À Propos</a></li>
              <!--  <li><a href="#contact">Contact</a></li>-->
                 <li><a href="{{ route('login') }}" >Se connecter</a></li>
                <li><a href="{{ route('register') }}">S'inscrire</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="accueil">
        <!-- Floating Elements -->
        <div class="floating-element">🚛</div>
        <div class="floating-element">✈️</div>
        <div class="floating-element">🚢</div>
        
        <div class="hero-content">
            <img src="{{ asset('images/logo.png') }}" alt="IGT Logo" class="logo">
            <h1>TRANSIT MAROC</h1>
            <p>Votre partenaire de confiance pour le transport international. Solutions logistiques innovantes et fiables pour connecter le Maroc au monde entier.</p>
            <div class="cta-buttons">
                <a href="#services" class="btn btn-primary">Découvrir nos Services</a>
                <a href="#contact" class="btn btn-secondary">Demander un Devis</a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="services-container">
            <h2 class="reveal">Nos Services</h2>
            <div class="services-grid">
                <div class="service-card reveal">
                    <div class="service-icon">🚛</div>
                    <h3>Transport Routier</h3>
                    <p>Solutions de transport terrestre fiables et efficaces pour tous vos besoins de livraison à travers le Maroc et l'international.</p>
                </div>
                <div class="service-card reveal">
                    <div class="service-icon">✈️</div>
                    <h3>Fret Aérien</h3>
                    <p>Transport aérien rapide et sécurisé pour vos marchandises urgentes et de haute valeur vers toutes les destinations.</p>
                </div>
                <div class="service-card reveal">
                    <div class="service-icon">🚢</div>
                    <h3>Fret Maritime</h3>
                    <p>Solutions de transport maritime économiques pour vos expéditions en vrac et containers vers tous les ports mondiaux.</p>
                </div>
                <div class="service-card reveal">
                    <div class="service-icon">📦</div>
                    <h3>Logistique</h3>
                    <p>Gestion complète de votre chaîne d'approvisionnement avec entreposage, distribution et solutions sur mesure.</p>
                </div>
                <div class="service-card reveal">
                    <div class="service-icon">🚛</div>
                    <h3>Douane & Transit</h3>
                    <p>Expertise douanière complète pour faciliter vos opérations d'import-export avec conformité réglementaire.</p>
                </div>
                <div class="service-card reveal">
                    <div class="service-icon">📊</div>
                    <h3>Suivi en Temps Réel</h3>
                    <p>Plateforme digitale avancée pour le suivi de vos expéditions en temps réel avec notifications automatiques.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-container">
            <div class="stat-item reveal">
                <div class="stat-number" data-target="500">0</div>
                <div class="stat-label">Clients Satisfaits</div>
            </div>
            <div class="stat-item reveal">
                <div class="stat-number" data-target="50">0</div>
                <div class="stat-label">Pays Desservis</div>
            </div>
            <div class="stat-item reveal">
                <div class="stat-number" data-target="10000">0</div>
                <div class="stat-label">Expéditions/An</div>
            </div>
            <div class="stat-item reveal">
                <div class="stat-number" data-target="19">0</div>
                <div class="stat-label">Années d'Expérience</div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-content">
            <div>
                <h4>IPSEN Group Transit Maroc</h4>
                <p>Votre partenaire logistique de confiance pour des solutions de transport innovantes et durables.</p>
            </div>
            <div>
                <h4>Contact</h4>
                <p>📍 6 Allée des Cyprès, Casablanca 20590</p>
                <p>📞 +212 522 66 67 70</p>
                <p>✉️ hc.specht@ipsenlogistics.com</p>
            </div>
            <div>
                <h4>Services</h4>
                <p><a href="#">Transport Routier</a></p>
                <p><a href="#">Fret Aérien</a></p>
                <p><a href="#">Fret Maritime</a></p>
                <p><a href="#">Logistique</a></p>
            </div>
        </div>
        <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem; margin-top: 2rem;">
            <p>&copy; 2025 IPSEN Group Transit Maroc. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Scroll animations
        function revealElements() {
            const reveals = document.querySelectorAll('.reveal');
            const windowHeight = window.innerHeight;
            const elementVisible = 150;

            reveals.forEach(reveal => {
                const elementTop = reveal.getBoundingClientRect().top;
                
                if (elementTop < windowHeight - elementVisible) {
                    reveal.classList.add('active');
                }
            });
        }

        // Counter animation
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            const speed = 200;

            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const count = parseInt(counter.innerText);
                const increment = target / speed;
                
                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(() => animateCounters(), 1);
                } else {
                    counter.innerText = target;
                }
            });
        }

        // Trigger animations on scroll
        let countersAnimated = false;
        window.addEventListener('scroll', () => {
            revealElements();
            
            // Animate counters when stats section is visible
            const statsSection = document.querySelector('.stats');
            const statsTop = statsSection.getBoundingClientRect().top;
            
            if (statsTop < window.innerHeight && !countersAnimated) {
                animateCounters();
                countersAnimated = true;
            }
        });

        // Navbar background on scroll
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(0, 61, 128, 0.98)';
            } else {
                navbar.style.background = 'rgba(0, 61, 128, 0.95)';
            }
        });

        // Service card hover effects
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.background = 'linear-gradient(135deg, #f0f8ff 0%, #e6f2ff 100%)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.background = 'white';
            });
        });

        // Initial reveal check
        revealElements();
    </script>
</body>
</html>