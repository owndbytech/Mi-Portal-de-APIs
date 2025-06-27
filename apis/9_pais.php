<?php
include '../partials/header.php';

$resultado = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['country_name'])) {
    $countryName = urlencode(trim($_POST['country_name']));
    
    $apiUrl = "https://restcountries.com/v3.1/name/{$countryName}";

    $json_data = @file_get_contents($apiUrl);

    if ($json_data === FALSE) {
        $error = "No se encontró el país '{$_POST['country_name']}'. Por favor, verifica el nombre (en inglés).";
    } else {
        $data = json_decode($json_data);
        // La API devuelve un array de países, incluso si solo encuentra uno.
        // Tomamos el primer resultado del array.
        if (!empty($data) && is_array($data)) {
            $resultado = $data[0];
        } else {
            $error = "La respuesta de la API no es válida.";
        }
    }
}
?>

<div class="container">
    <h1 class="text-center mb-4">9. Información de un País</h1>
    <p class="text-center">Escribe el nombre de un país (preferiblemente en inglés) para obtener sus datos.</p>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="">
                <div class="input-group mb-3 shadow-sm">
                    <input type="text" class="form-control form-control-lg" name="country_name" placeholder="Ej: Dominican Republic, Germany, Japan" required>
                    <button type="submit" class="btn btn-primary btn-lg">Buscar País</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <?php if ($error): ?>
            <div class="alert alert-danger">🚨 <?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($resultado): ?>
            <div class="card shadow mx-auto" style="max-width: 600px;">
                <img src="<?php echo htmlspecialchars($resultado->flags->svg); ?>" class="card-img-top" alt="Bandera de <?php echo $resultado->name->common; ?>">
                <div class="card-body">
                    <h2 class="card-title text-center"><?php echo htmlspecialchars($resultado->name->official); ?></h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nombre Común:</strong> <?php echo htmlspecialchars($resultado->name->common); ?></li>
                        <li class="list-group-item"><strong>Capital:</strong> <?php echo htmlspecialchars($resultado->capital[0] ?? 'No disponible'); ?></li>
                        <li class="list-group-item"><strong>Población:</strong> <?php echo number_format($resultado->population); ?> habitantes</li>
                        <li class="list-group-item"><strong>Región:</strong> <?php echo htmlspecialchars($resultado->region); ?> (<?php echo htmlspecialchars($resultado->subregion); ?>)</li>
                        <li class="list-group-item">
                            <strong>Moneda:</strong> 
                            <?php
                                // La estructura de la moneda es compleja, la procesamos aquí
                                $moneda_info = array_values((array)$resultado->currencies)[0];
                                echo htmlspecialchars($moneda_info->name) . " (" . htmlspecialchars($moneda_info->symbol) . ")";
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include '../partials/footer.php';
?>