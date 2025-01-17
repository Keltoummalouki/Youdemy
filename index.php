<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        nav {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #2563eb;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #1f2937;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #2563eb;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 6rem 2rem;
            color: white;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto 2rem auto;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            background-color: white;
            color: #2563eb;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-3px);
        }

        /* Features Section */
        .features {
            padding: 6rem 2rem;
            background-color: #f3f4f6;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .features h2 {
            text-align: center;
            font-size: 2.5rem;
            color: #1f2937;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .feature-card h3 {
            color: #2563eb;
            margin: 1rem 0;
        }

        .feature-card p {
            color: #4b5563;
            line-height: 1.6;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <a href="/" class="logo">Youdemy</a>
            <ul class="nav-links">
                <li><a href="#features">Fonctionnalités</a></li>
                <li><a href="#courses">Cours</a></li>
                <li><a href="#teachers">Enseignants</a></li>
                <li><a href="#pricing">Tarifs</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>Révolutionnez votre apprentissage</h1>
            <p>Youdemy est une plateforme de cours en ligne innovante qui offre une expérience d'apprentissage personnalisée et interactive pour les étudiants et les enseignants.</p>
            <a href="#signup" class="cta-button">Commencer gratuitement</a>
        </div>
    </section>

    <section class="features">
        <div class="features-container">
            <h2>Nos fonctionnalités</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <h3>Apprentissage personnalisé</h3>
                    <p>Un parcours adapté à votre rythme et à vos objectifs d'apprentissage.</p>
                </div>
                <div class="feature-card">
                    <h3>Experts qualifiés</h3>
                    <p>Apprenez avec des instructeurs expérimentés et passionnés.</p>
                </div>
                <div class="feature-card">
                    <h3>Contenu interactif</h3>
                    <p>Des cours enrichis avec des quiz, des projets pratiques et des discussions en direct.</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>