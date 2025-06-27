<?php
include '../partials/header.php';

$resultado = null;
$error = null;
$sitioSeleccionado = '';
$nombreSitio = '';

// Definimos una lista de sitios de noticias con APIs de WordPress públicas
$sitiosDeNoticias = [
    'https://techcrunch.com' => 'TechCrunch',
    'https://www.smashingmagazine.com' => 'Smashing Magazine',
    'https://www.engadget.com' => 'Engadget'
];

// Por defecto, usamos el primer sitio de la lista
$urlBaseSitio = key($sitiosDeNoticias);

// Si el formulario se envió, usamos el sitio que el usuario eligió
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['site_url'])) {
    $urlBaseSitio = $_POST['site_url'];
}

$nombreSitio = $sitiosDeNoticias[$urlBaseSitio]; // Obtenemos el nombre legible del sitio

// Construimos la URL de la API para obtener los últimos 3 posts
// &_embed nos ayuda a obtener información extra como la imagen destacada
$apiUrl = "{$urlBaseSitio}/wp-json/wp/v2/posts?per_page=3&_embed";

// Usamos un user-agent para simular un navegador, algunas APIs lo requieren
$options = [
    'http' => [
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36\r\n"
    ]
];
$context = stream_context_create($options);
$json_data = @file_get_contents($apiUrl, false, $context);

if ($json_data === FALSE) {
    $error = "No se pudo conectar a la API de '{$nombreSitio}'. El sitio podría no ser compatible o estar caído.";
} else {
    $resultado = json_decode($json_data);
    if (empty($resultado)) {
        $error = "No se encontraron noticias o la respuesta estaba vacía.";
    }
}
?>

<div class="container">
    <h1 class="text-center mb-4">6. Últimas Noticias de WordPress</h1>
    <p class="text-center">Elige un blog de tecnología para ver sus 3 noticias más recientes usando la API REST de WordPress.</p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="">
                <div class="input-group mb-3">
                    <select class="form-select" name="site_url">
                        <?php foreach ($sitiosDeNoticias as $url => $nombre): ?>
                            <option value="<?php echo $url; ?>" <?php if ($url == $urlBaseSitio) echo 'selected'; ?>>
                                <?php echo $nombre; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Cargar Noticias</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <?php if ($error): ?>
            <div class="alert alert-danger">🚨 <?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($resultado): ?>
            <h2 class="mb-3">Últimas noticias de: <?php echo $nombreSitio; ?></h2>
            <div class="row">
                <?php foreach ($resultado as $noticia): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <?php 
                                // Intentamos obtener la imagen destacada
                                $imagenUrl = BASE_URL . 'assets/img/default-news.png'; // Una imagen por defecto
                                if (isset($noticia->_embedded) && isset($noticia->_embedded->{'wp:featuredmedia'}[0]->source_url)) {
                                    $imagenUrl = $noticia->_embedded->{'wp:featuredmedia'}[0]->source_url;
                                }
                            ?>
                            <img src="<?php echo $imagenUrl; ?>" class="card-img-top" alt="Imagen de la noticia" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($noticia->title->rendered); ?></h5>
                                <div class="card-text">
                                    <?php echo $noticia->excerpt->rendered; // El resumen ya viene en HTML ?>
                                </div>
                                <a href="<?php echo htmlspecialchars($noticia->link); ?>" target="_blank" class="btn btn-secondary mt-auto">Leer Más</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include '../partials/footer.php';
?>