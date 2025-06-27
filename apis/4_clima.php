<?php
include '../partials/header.php';

$resultado = null;
$error = null;
$ciudadBuscada = 'Santo Domingo'; // Ciudad por defecto


$apiKey = "b9f74017fd8bd3cfedabed0e5d226164"; 


// Si el formulario fue enviado, busca la nueva ciudad. Si no, usa la de por defecto.
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['city'])) {
    $ciudadBuscada = $_POST['city'];
}

$ciudadParam = urlencode($ciudadBuscada);
$apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$ciudadParam}&appid={$apiKey}&units=metric&lang=es";

$json_data = @file_get_contents($apiUrl);

if ($json_data === FALSE) {
    $error = "No se pudo conectar a la API de OpenWeatherMap. ¿Pegaste tu API Key?";
} else {
    $data = json_decode($json_data);

    // El código 'cod' == 200 significa que todo salió bien.
    if ($data->cod == 200) {
        $resultado = $data;
    } else {
        $error = "No se encontró la ciudad '{$ciudadBuscada}'. Intenta de nuevo.";
    }
}

// Lógica para el fondo dinámico
$bgClass = 'bg-light'; // Fondo por defecto
if ($resultado) {
    $mainWeather = $resultado->weather[0]->main;
    switch ($mainWeather) {
        case 'Clear':
            $bgClass = 'bg-sunny';
            break;
        case 'Clouds':
            $bgClass = 'bg-cloudy';
            break;
        case 'Rain':
        case 'Drizzle':
            $bgClass = 'bg-rainy';
            break;
        case 'Thunderstorm':
            $bgClass = 'bg-stormy';
            break;
        default:
            $bgClass = 'bg-light';
            break;
    }
}
?>

<style>
    .weather-wrapper { border-radius: 15px; transition: background-color 0.5s ease; }
    .bg-sunny { background-color: #87CEEB; color: #000; } /* Cielo Azul */
    .bg-cloudy { background-color: #B0C4DE; color: #000; } /* Gris Claro */
    .bg-rainy { background-color: #778899; color: #fff; } /* Gris Pizarra */
    .bg-stormy { background-color: #2F4F4F; color: #fff; } /* Gris Oscuro */
</style>

<div class="container">
    <div class="p-5 mb-4 <?php echo $bgClass; ?> weather-wrapper shadow">
        <h1 class="text-center mb-4">4. Clima Actual 🌦️</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="">
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" name="city" placeholder="Buscar otra ciudad...">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center">🚨 <?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($resultado): ?>
            <div class="text-center">
                <h2><?php echo htmlspecialchars($resultado->name); ?>, <?php echo $resultado->sys->country; ?></h2>
                <div class="d-flex align-items-center justify-content-center">
                    <img src="https://openweathermap.org/img/wn/<?php echo $resultado->weather[0]->icon; ?>@4x.png" alt="Icono del clima">
                    <p class="display-1 fw-bold m-0"><?php echo round($resultado->main->temp); ?>°C</p>
                </div>
                <p class="fs-4 text-capitalize"><?php echo htmlspecialchars($resultado->weather[0]->description); ?></p>
                <div class="row mt-3">
                    <div class="col"><strong>Sensación Real:</strong> <?php echo round($resultado->main->feels_like); ?>°C</div>
                    <div class="col"><strong>Humedad:</strong> <?php echo $resultado->main->humidity; ?>%</div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include '../partials/footer.php';
?>