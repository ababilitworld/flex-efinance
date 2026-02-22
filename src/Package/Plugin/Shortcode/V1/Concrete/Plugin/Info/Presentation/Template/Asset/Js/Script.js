document.addEventListener('DOMContentLoaded', function() {
    // Animate stats when they come into view
    const animateStats = () => {
        const statNumbers = document.querySelectorAll('.stat-number');
        const statsSection = document.querySelector('.stats-section');
        const sectionPosition = statsSection.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;

        if (sectionPosition < screenPosition) {
            statNumbers.forEach(stat => {
                if (!stat.classList.contains('animated')) {
                    animateValue(stat);
                    stat.classList.add('animated');
                }
            });
        }
    };

    // Animate value function
    const animateValue = (element) => {
        const target = parseFloat(element.getAttribute('data-count'));
        const prefix = element.getAttribute('data-prefix') || '';
        const suffix = element.getAttribute('data-suffix') || '';
        const duration = 2000; // Animation duration in ms
        const start = 0;
        const increment = target / (duration / 16); // 60fps
        
        let current = start;
        const animate = () => {
            current += increment;
            if (current < target) {
                // For decimal values
                if (target % 1 !== 0) {
                    element.textContent = prefix + current.toFixed(1) + suffix;
                } else {
                    element.textContent = prefix + Math.floor(current) + suffix;
                }
                requestAnimationFrame(animate);
            } else {
                element.textContent = prefix + target + suffix;
            }
        };
        
        animate();
    };

    // Run on load and scroll
    animateStats();
    window.addEventListener('scroll', animateStats);
});