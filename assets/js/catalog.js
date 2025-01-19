    document.addEventListener('DOMContentLoaded', function() {
    const categoryButtons = document.querySelectorAll('.category-btn');
    const courseCards = document.querySelectorAll('.course-card');

    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const selectedCategory = this.dataset.category;

            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            courseCards.forEach(card => {
                if (selectedCategory === 'all' || card.dataset.category === selectedCategory) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });

            if (selectedCategory === 'all') {
                window.location.href = window.location.pathname;
            } else {
                window.location.href = `?category=${selectedCategory}`;
            }
        });
    });
});