<script>
    window.addEventListener('scroll', function() {
        var scrollPosition = window.scrollY;
        var ancre = document.querySelector('.ancre');

        // Ajouter la classe "visible" lorsque la position de défilement dépasse 200 pixels
        if (scrollPosition > 200) {
            ancre.classList.add('visible');
        } else {
            // Retirer la classe "visible" si la position de défilement est inférieure à 200 pixels
            ancre.classList.remove('visible');
        }

        // Appliquer des styles spécifiques pour la version mobile
        if (window.innerWidth <= 500) {
            ancre.style.height = '8vw';
            ancre.style.width = '8vw';
            ancre.style.bottom = '18vw';
        }
    });

    function goTop() {
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    }
</script>

<div class="ancre">
    <span class="material-symbols-outlined arrowTop" onclick="goTop()">
        arrow_upward
    </span>
</div>