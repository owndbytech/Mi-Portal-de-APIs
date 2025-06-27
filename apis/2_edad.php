<?php
// Incluimos el header. Esto también nos da acceso a la constante BASE_URL.
include '../partials/header.php';

// Inicializamos variables
$resultado = null;
$error = null;

// Verificamos si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name'])) {
        $nombre = urlencode($_POST['name']);
        
        // Construimos la URL de la API de Agify
        $apiUrl = "https://api.agify.io/?name={$nombre}";

        // Hacemos la llamada a la API
        $json_data = @file_get_contents($apiUrl);

        if ($json_data === FALSE) {
            $error = "No se pudo conectar a la API de Agify. Inténtalo más tarde.";
        } else {
            $data = json_decode($json_data);

            // Verificamos que la API nos devuelva una edad
            if ($data && isset($data->age)) {
                $resultado = $data;
            } else {
                $error = "No se pudo estimar la edad para ese nombre.";
            }
        }
    } else {
        $error = "Por favor, ingresa un nombre en el formulario.";
    }
}
?>

<div class="container text-center">
    <h1 class="mb-4">2. Predicción de Edad 🎂</h1>
    <p>Ingresa un nombre para estimar la edad promedio de una persona con ese nombre.</p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Ej: Meelad, Sofia" required>
                    <button type="submit" class="btn btn-success">Estimar Edad</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <?php if ($error): ?>
            <div class="alert alert-danger mx-auto" style="max-width: 400px;">
                🚨 <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($resultado): ?>
            <?php
                // Lógica para determinar la categoría y la imagen con NUEVOS RANGOS
                $edad = $resultado->age;
                $categoria = '';
                $imagen_url = '';

                // ====== LÍNEAS MODIFICADAS ======
                if ($edad < 40) { // Antes era 30
                    $categoria = 'Joven 👶';
                    $imagen_url = BASE_URL . 'assets/img/joven.jpg'; 
                } elseif ($edad >= 40 && $edad < 65) { // Antes era 30 y 60
                    $categoria = 'Adulto 🧑';
                    $imagen_url = BASE_URL . 'assets/img/adulto.jpg';
                } else { // Mayores de 65
                    $categoria = 'Anciano 👴';
                    $imagen_url = BASE_URL . 'assets/img/anciano.jpg';
                }
                // =================================
            ?>
            <div class="card mx-auto" style="max-width: 400px;">
                <div class="text-center p-3">
                    <img src="<?php echo $imagen_url; ?>" class="rounded-circle" alt="<?php echo $categoria; ?>" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #198754;">
                </div>
                <div class="card-body pt-0">
                    <h5 class="card-title fs-4">La edad estimada para "<?php echo htmlspecialchars($resultado->name); ?>" es...</h5>
                    <p class="card-text display-4 fw-bold text-success">
                        <?php echo $edad; ?> años
                    </p>
                    <p class="card-text fs-3">
                        Clasificado como: <strong><?php echo $categoria; ?></strong>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
// Incluimos el footer
include '../partials/footer.php';
?>