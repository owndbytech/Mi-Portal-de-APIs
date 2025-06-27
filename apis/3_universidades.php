<?php
// Incluimos el header para tener la estructura y la constante BASE_URL
include '../partials/header.php';

$resultado = null;
$error = null;
$paisBuscado = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['country'])) {
        // Guardamos el nombre del país para mostrarlo en el título
        $paisBuscado = htmlspecialchars($_POST['country']);

        // Preparamos el nombre del país para la URL (reemplaza espacios con +)
        $countryParam = urlencode($_POST['country']);
        
        $apiUrl = "http://universities.hipolabs.com/search?country={$countryParam}";

        $json_data = @file_get_contents($apiUrl);

        if ($json_data === FALSE) {
            $error = "No se pudo conectar a la API de Universidades.";
        } else {
            $data = json_decode($json_data);

            // Esta API devuelve un array vacío si no encuentra resultados.
            // Verificamos si el array 'data' no está vacío.
            if (!empty($data)) {
                $resultado = $data;
            } else {
                $error = "No se encontraron universidades para el país '{$paisBuscado}'. Asegúrate de escribir el nombre en inglés (Ej: Dominican Republic, Spain, Italy).";
            }
        }
    } else {
        $error = "Por favor, ingresa el nombre de un país.";
    }
}
?>

<div class="container">
    <h1 class="text-center mb-4">3. Universidades por País</h1>
    <p class="text-center">Ingresa el nombre de un país en inglés para buscar una lista de sus universidades.</p>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="country" placeholder="Ej: Dominican Republic, United States" required>
                    <button type="submit" class="btn btn-info">Buscar Universidades</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <?php if ($error): ?>
            <div class="alert alert-danger">
                🚨 <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($resultado): ?>
            <h2 class="mb-3">Universidades encontradas en <?php echo $paisBuscado; ?>:</h2>
            <div class="list-group">
                <?php foreach ($resultado as $universidad): ?>
                    <a href="<?php echo htmlspecialchars($universidad->web_pages[0]); ?>" target="_blank" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo htmlspecialchars($universidad->name); ?></h5>
                            <small>Dominio: <?php echo htmlspecialchars($universidad->domains[0]); ?></small>
                        </div>
                        <p class="mb-1">Visitar sitio web: <?php echo htmlspecialchars($universidad->web_pages[0]); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
// Incluimos el footer
include '../partials/footer.php';
?>