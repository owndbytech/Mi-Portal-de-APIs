<?php
include '../partials/header.php';

$accessKey = "OcGGZv3hHWY-RSwp4173odK3qFsgCIdpW86E6Zrh31Y";

$resultado = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['keyword'])) {
    $keyword = urlencode($_POST['keyword']);
    
    // Pedimos solo 1 imagen aleatoria de la primera página de resultados
    $apiUrl = "https://api.unsplash.com/search/photos?query={$keyword}&per_page=1&page=1";

    // Unsplash requiere autenticación a través de una cabecera (Header)
    $options = [
        'http' => [
            'header' => "Authorization: Client-ID {$accessKey}\r\n" .
                        "User-Agent: MiProyectoDeAPIs/1.0\r\n"
        ]
    ];
    $context = stream_context_create($options);
    $json_data = @file_get_contents($apiUrl, false, $context);

    if ($json_data === FALSE) {
        $error = "No se pudo conectar a la API de Unsplash. Revisa tu Access Key.";
    } else {
        $data = json_decode($json_data);
        if (!empty($data->results)) {
            // Tomamos la primera imagen de la lista de resultados
            $resultado = $data->results[0];
        } else {
            $error = "No se encontraron imágenes para la palabra clave '{$_POST['keyword']}'.";
        }
    }
}
?>

<div class="container">
    <h1 class="text-center mb-4">8. Generador de Imágenes</h1>
    <p class="text-center">Escribe una palabra clave (en inglés es más efectivo) para generar una imagen de alta calidad desde Unsplash.</p>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="">
                <div class="input-group mb-3 shadow-sm">
                    <input type="text" class="form-control form-control-lg" name="keyword" placeholder="Ej: nature, technology, beach" required>
                    <button type="submit" class="btn btn-dark btn-lg">Generar Imagen</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <?php if ($error): ?>
            <div class="alert alert-danger">🚨 <?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($resultado): ?>
            <div class="card shadow mx-auto" style="max-width: 700px;">
                <img src="<?php echo $resultado->urls->regular; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($resultado->alt_description); ?>">
                <div class="card-footer text-muted text-center">
                    Foto por 
                    <a href="<?php echo $resultado->user->links->html; ?>?utm_source=mi_portal_apis&utm_medium=referral" target="_blank">
                        <?php echo $resultado->user->name; ?>
                    </a>
                    en 
                    <a href="https://unsplash.com/?utm_source=mi_portal_apis&utm_medium=referral" target="_blank">Unsplash</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include '../partials/footer.php';
?>