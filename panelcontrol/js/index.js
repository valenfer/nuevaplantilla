document.addEventListener('DOMContentLoaded', function() {
    const menuLinks = document.querySelectorAll('.menu a');
    
    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Evita el comportamiento por defecto del enlace (#)
            const page = this.getAttribute('data-page');
            // Redirige a index.php con el parámetro page correcto
            window.location.href = `index.php?page=${page}`;
        });
    });
});