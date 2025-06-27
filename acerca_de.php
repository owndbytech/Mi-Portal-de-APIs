<?php 
// Incluimos el header para tener la barra de navegación y el estilo
include 'partials/header.php'; 
?>

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h2 class="m-0">🎨 Acerca de Este Proyecto</h2>
        </div>
        <div class="card-body p-4">
            <h5 class="card-title">Framework CSS Utilizado: Bootstrap 5</h5>
            <p class="card-text">
                Para el diseño y la maquetación de todo este portal, se utilizó el framework de CSS **Bootstrap 5**.
            </p>
            <p class="card-text">
                Elegí Bootstrap por varias razones clave que facilitaron enormemente el desarrollo:
            </p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>🚀 Rapidez y Eficiencia:</strong> Permite construir interfaces limpias, modernas y responsivas muy rápidamente gracias a su extenso sistema de componentes predefinidos (como las tarjetas que ves en cada API, los formularios, los botones y la barra de navegación).
                </li>
                <li class="list-group-item">
                    <strong>📱 Sistema de Rejilla (Grid System):</strong> Su sistema de `rows` y `cols` es extremadamente potente y flexible para crear layouts complejos que se adaptan automáticamente a cualquier tamaño de pantalla (móvil, tablet, escritorio).
                </li>
                <li class="list-group-item">
                    <strong>📚 Excelente Documentación:</strong> La documentación oficial de Bootstrap es clara y está llena de ejemplos fáciles de copiar y pegar, lo que acelera la búsqueda y aplicación de cualquier componente.
                </li>
                <li class="list-group-item">
                    <strong>🌍 Popularidad y Comunidad:</strong> Al ser el framework CSS más popular del mundo, existe una enorme cantidad de recursos, tutoriales y soluciones a problemas comunes disponibles en internet, lo que garantiza soporte para cualquier duda.
                </li>
            </ul>
            <p class="card-text mt-3">
                En resumen, Bootstrap me permitió concentrarme más en la lógica de PHP y la interacción con las APIs, asegurando al mismo tiempo un resultado visual profesional y funcional sin necesidad de escribir cientos de líneas de CSS desde cero.
            </p>
        </div>
    </div>
</div>

<?php 
// Incluimos el footer para cerrar la página
include 'partials/footer.php'; 
?>