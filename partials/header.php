<?php
// Incluimos el archivo de configuración una sola vez.
// Usamos $_SERVER['DOCUMENT_ROOT'] para crear una ruta absoluta y robusta al archivo.
include_once $_SERVER['DOCUMENT_ROOT'] . '/portal-apis/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de APIs - Axel Darwin Tavarez Polanco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">🏠 Mi Portal de APIs</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo BASE_URL; ?>index.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL; ?>acerca_de.php">Acerca de</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Lista de APIs
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>apis/1_genero.php">1. Predicción de Género</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>apis/2_edad.php">2. Predicción de Edad</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>apis/3_universidades.php">3. Universidades</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>apis/4_clima.php">4. Clima</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>apis/5_pokemon.php">5. Pokémon</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>apis/6_noticias.php">6. Noticias WP</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>apis/7_monedas.php">7. Conversor de Moneda</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>apis/8_imagenes.php">8. Imágenes AI</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>apis/9_pais.php">9. Datos de País</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>apis/10_chistes.php">10. Chistes</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container mt-4 flex-grow-1">