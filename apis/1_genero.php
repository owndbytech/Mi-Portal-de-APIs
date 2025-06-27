<?php
// ---- LÓGICA DE PHP ----
// Esta parte se ejecuta antes de que se muestre nada en la página.

// 1. Incluimos el header. La ruta '../partials/header.php' significa
//    "sube un nivel de carpeta y luego entra a partials".
include '../partials/header.php';

// 2. Inicializamos las variables que usaremos.
$resultado = null; // Guardará los datos de la API si todo sale bien.
$error = null;     // Guardará un mensaje de error si algo falla.

// 3. Verificamos si el formulario fue enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 4. Verificamos que el campo 'name' no esté vacío.
    if (!empty($_POST['name'])) {
        // Limpiamos el nombre para que sea seguro usarlo en una URL.
        $nombre = urlencode($_POST['name']);
        
        // Construimos la URL de la API con el nombre ingresado.
        $apiUrl = "https://api.genderize.io/?name={$nombre}";

        // 5. Hacemos la llamada a la API.
        $json_data = @file_get_contents($apiUrl);

        if ($json_data === FALSE) {
            $error = "No se pudo conectar a la API de Genderize. Inténtalo más tarde.";
        } else {
            // Decodificamos la respuesta JSON para poder usarla en PHP.
            $data = json_decode($json_data);

            // Verificamos si la API nos dio un género.
            // La parte "isset($data->gender) && $data->gender != null" es para nombres que la API no reconoce.
            if ($data && isset($data->gender) && $data->gender != null) {
                $resultado = $data;
            } else {
                $error = "No se pudo determinar el género para ese nombre. Prueba con otro.";
            }
        }
    } else {
        $error = "Por favor, ingresa un nombre en el formulario.";
    }
}
?>

<div class="container text-center">
    <h1 class="mb-4">1. Predicción de Género</h1>
    <p>Ingresa un nombre para predecir si es masculino o femenino.</p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Ej: Irma, Pedro" required>
                    <button type="submit" class="btn btn-primary">Predecir Género</button>
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
                // Determinamos el estilo según el género para la tarjeta
                $cardClass = '';
                $genderText = '';
                $genderEmoji = '';
                if ($resultado->gender == 'male') {
                    $cardClass = 'border-primary';
                    $genderText = 'Masculino';
                    $genderEmoji = '💙';
                } elseif ($resultado->gender == 'female') {
                    $cardClass = 'border-pink'; 
                    $genderText = 'Femenino';
                    $genderEmoji = '💖';
                }
            ?>
            <style>.border-pink { border-color: #e83e8c !important; } .text-pink { color: #e83e8c !important; }</style>

            <div class="card mx-auto <?php echo $cardClass; ?>" style="max-width: 400px; border-width: 3px;">
                <div class="card-body">
                    <h5 class="card-title fs-4">El nombre "<?php echo htmlspecialchars($resultado->name); ?>" es...</h5>
                    <p class="card-text display-4 fw-bold <?php echo ($resultado->gender == 'female') ? 'text-pink' : 'text-primary'; ?>">
                        <?php echo $genderText . ' ' . $genderEmoji; ?>
                    </p>
                    <p class="card-text text-muted">
                        (Probabilidad: <?php echo ($resultado->probability * 100); ?>%)
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php
// 6. Finalmente, incluimos el footer.
include '../partials/footer.php';
?>