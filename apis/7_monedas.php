<?php
include '../partials/header.php';

$apiKey = "4fde1d28fb4e1d3d50765cc1"; 

$tasas = null;
$error = null;
$cantidadUSD = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['amount_usd']) && is_numeric($_POST['amount_usd'])) {
        $cantidadUSD = floatval($_POST['amount_usd']);
        
        $apiUrl = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD";

        $json_data = @file_get_contents($apiUrl);

        if ($json_data === FALSE) {
            $error = "No se pudo conectar a la API de ExchangeRate. Revisa tu API Key.";
        } else {
            $data = json_decode($json_data);

            if ($data && $data->result === 'success') {
                $tasas = $data->conversion_rates;
            } else {
                // El error viene dentro de la respuesta de la API
                $error = "Hubo un error con la API: " . ($data->{'error-type'} ?? 'Error desconocido');
            }
        }
    } else {
        $error = "Por favor, ingresa una cantidad numérica válida.";
    }
}
?>

<div class="container">
    <h1 class="text-center mb-4">7. Conversor de Monedas</h1>
    <p class="text-center">Ingresa una cantidad en Dólares (USD) para ver su equivalente en otras monedas.</p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="" class="shadow p-4 rounded-3 bg-light">
                <div class="mb-3">
                    <label for="amount_usd" class="form-label fs-5">Cantidad en USD $</label>
                    <input type="number" step="0.01" class="form-control form-control-lg" name="amount_usd" id="amount_usd" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Convertir</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5">
        <?php if ($error): ?>
            <div class="alert alert-danger text-center">🚨 <?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($tasas): ?>
            <div class="text-center">
                <h2><?php echo number_format($cantidadUSD, 2); ?> USD equivale a:</h2>
            </div>
            <div class="row justify-content-center mt-4 g-3">
                
                <div class="col-md-5">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="card-title">Peso Dominicano 🇩🇴</h3>
                            <p class="card-text fs-1 fw-bold text-success">
                                <?php echo number_format($cantidadUSD * $tasas->DOP, 2); ?>
                            </p>
                            <small class="text-muted">Tasa: 1 USD = <?php echo $tasas->DOP; ?> DOP</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="card-title">Euro 🇪🇺</h3>
                            <p class="card-text fs-1 fw-bold text-primary">
                                <?php echo number_format($cantidadUSD * $tasas->EUR, 2); ?>
                            </p>
                            <small class="text-muted">Tasa: 1 USD = <?php echo $tasas->EUR; ?> EUR</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="card-title">Yen Japonés 🇯🇵</h3>
                            <p class="card-text fs-1 fw-bold text-danger">
                                <?php echo number_format($cantidadUSD * $tasas->JPY, 2); ?>
                            </p>
                            <small class="text-muted">Tasa: 1 USD = <?php echo $tasas->JPY; ?> JPY</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="card-title">Libra Esterlina 🇬🇧</h3>
                            <p class="card-text fs-1 fw-bold text-info">
                                <?php echo number_format($cantidadUSD * $tasas->GBP, 2); ?>
                            </p>
                            <small class="text-muted">Tasa: 1 USD = <?php echo $tasas->GBP; ?> GBP</small>
                        </div>
                    </div>
                </div>

            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include '../partials/footer.php';
?>