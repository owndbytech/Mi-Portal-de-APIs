<?php
include '../partials/header.php';

$chiste = null;
$error = null;

// 1. CAMBIAMOS LA URL DE LA API POR UNA QUE OFRECE CHISTES EN ESPAÑOL
$apiUrl = "https://v2.jokeapi.dev/joke/Any?lang=es&type=twopart";

$json_data = @file_get_contents($apiUrl);

if ($json_data === FALSE) {
    $error = "No se pudo conectar a la API de chistes. Parece que hoy no hay humor.";
} else {
    $chiste = json_decode($json_data);
    // Esta API tiene una propiedad 'error' que podemos revisar
    if ($chiste->error) {
        $error = "La API de chistes devolvió un error.";
        $chiste = null; // Nos aseguramos de no mostrar un chiste parcial
    }
}
?>

<div class="container text-center">
    <h1 class="mb-4">10. Generador de Chistes Aleatorios 🤣</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if ($error): ?>
                <div class="alert alert-danger">🚨 <?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($chiste): ?>
                <div class="card shadow-lg">
                    <div class="card-header fs-4 fw-bold">
                        Aquí tienes tu chiste:
                    </div>
                    <div class="card-body" style="min-height: 200px; display: flex; flex-direction: column; justify-content: center;">
                        <p class="card-text fs-3">
                            "<?php echo htmlspecialchars($chiste->setup); ?>"
                        </p>
                        
                        <details class="mt-3">
                            <summary class="btn btn-success">Ver respuesta</summary>
                            <p class="fs-2 fw-bold mt-3 text-success">
                                <?php
                                    // 2. CAMBIAMOS 'punchline' POR 'delivery' QUE ES EL NOMBRE QUE USA ESTA NUEVA API
                                    echo htmlspecialchars($chiste->delivery); 
                                ?>
                            </p>
                        </details>

                    </div>
                    <div class="card-footer">
                        <a href="<?php echo BASE_URL; ?>apis/10_chistes.php" class="btn btn-primary">🤣 ¡Quiero otro!</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include '../partials/footer.php';
?>