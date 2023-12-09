<script>
    window.addEventListener('scroll', function() {
        var scrollPosition = window.scrollY;

        // Ajouter la classe "visible" lorsque la position de défilement dépasse 200 pixels
        if (scrollPosition > 200) {
            document.querySelector('.ancre').classList.add('visible');
        } else {
            // Retirer la classe "visible" si la position de défilement est inférieure à 200 pixels
            document.querySelector('.ancre').classList.remove('visible');
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