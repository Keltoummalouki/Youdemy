<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/styles/catalog.css">
    <title>Youdemy - Catalogue de Cours</title>
</head>
<body>
<header>
        <div class="logosec">
        <div class="logo">You<span>demy</span></div>
        </div>

        <div class="searchbar">
            <input type="text"
                placeholder="Search">
            <div class="searchbtn">
                <img src="../../../assets/media/image/search.png"
                    class="icn srchicn"
                    alt="search-icon">
            </div>
        </div>

        <div class="message">
            <div class="circle"></div>
            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210183322/8.png"
                class="icn"
                alt="">
            <div class="dp">
                <img src="../../../../assets/media/image/Profil.png"
                    class="dpicn"
                    alt="dp">
                    <a href="../../auth/login.php"></a>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="categories">
            <button class="category-btn">Tous les cours</button>
            <button class="category-btn">Développement Web</button>
            <button class="category-btn">Business</button>
            <button class="category-btn">Design</button>
            <button class="category-btn">Marketing</button>
            <button class="category-btn">Photographie</button>
            <button class="category-btn">Musique</button>
        </div>

        <div class="courses-grid">
            <!-- Carte de cours 1 -->
            <div class="course-card">
                <img src="/api/placeholder/280/160" alt="cours" class="course-image">
                <div class="course-info">
                    <h3 class="course-title">Développement Web Complet 2024</h3>
                    <p class="course-instructor">Par Jean Dupont</p>
                    <div class="course-rating">
                        <span class="rating-stars">★★★★★</span>
                        <span>4.8 (2,345 avis)</span>
                    </div>
                    <button class="enroll-btn">S'inscrire</button>
                </div>
            </div>

            <!-- Carte de cours 2 -->
            <div class="course-card">
                <img src="/api/placeholder/280/160" alt="cours" class="course-image">
                <div class="course-info">
                    <h3 class="course-title">Marketing Digital pour Débutants</h3>
                    <p class="course-instructor">Par Marie Martin</p>
                    <div class="course-rating">
                        <span class="rating-stars">★★★★☆</span>
                        <span>4.2 (1,890 avis)</span>
                    </div>
                    <button class="enroll-btn">S'inscrire</button>
                </div>
            </div>

            <!-- Carte de cours 3 -->
            <div class="course-card">
                <img src="/api/placeholder/280/160" alt="cours" class="course-image">
                <div class="course-info">
                    <h3 class="course-title">Design UI/UX Master Class</h3>
                    <p class="course-instructor">Par Sophie Bernard</p>
                    <div class="course-rating">
                        <span class="rating-stars">★★★★★</span>
                        <span>4.9 (3,421 avis)</span>
                    </div>
                    <button class="enroll-btn">S'inscrire</button>
                </div>
            </div>

            <!-- Carte de cours 4 -->
            <div class="course-card">
                <img src="/api/placeholder/280/160" alt="cours" class="course-image">
                <div class="course-info">
                    <h3 class="course-title">Python pour la Data Science</h3>
                    <p class="course-instructor">Par Pierre Dubois</p>
                    <div class="course-rating">
                        <span class="rating-stars">★★★★☆</span>
                        <span>4.5 (1,567 avis)</span>
                    </div>
                    <button class="enroll-btn">S'inscrire</button>
                </div>
            </div>
        </div>
        <div class="pagination">
            <button class="pagination-btn">«</button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">4</button>
            <button class="pagination-btn">5</button>
            <button class="pagination-btn">»</button>
        </div>
    </main>
</body>
</html>