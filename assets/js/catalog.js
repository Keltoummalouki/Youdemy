    document.addEventListener('DOMContentLoaded', function() {
    const categoryButtons = document.querySelectorAll('.category-btn');
    const courseCards = document.querySelectorAll('.course-card');

    // Filtrage côté client
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const selectedCategory = this.dataset.category;

            // Mise à jour du style des boutons
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Filtrage des cours
            courseCards.forEach(card => {
                if (selectedCategory === 'all' || card.dataset.category === selectedCategory) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });

            // Mise à jour de l'URL pour le filtrage côté serveur
            if (selectedCategory === 'all') {
                window.location.href = window.location.pathname;
            } else {
                window.location.href = `?category=${selectedCategory}`;
            }
        });
    });
});