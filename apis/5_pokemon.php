<?php
include '../partials/header.php';

$resultado = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['pokemon_name'])) {
    // La API de Pokémon requiere los nombres en minúsculas y sin espacios extra.
    $pokemon_name = strtolower(trim($_POST['pokemon_name']));
    
    $apiUrl = "https://pokeapi.co/api/v2/pokemon/" . urlencode($pokemon_name);

    $json_data = @file_get_contents($apiUrl);

    if ($json_data === FALSE) {
        $error = "Pokémon no encontrado. Revisa que el nombre esté bien escrito (Ej: pikachu, charizard).";
    } else {
        $resultado = json_decode($json_data);
    }
}
?>

<style>
    .card-pokemon {
        background: linear-gradient(to bottom, #f7d34a, #f3c22a);
        border: 10px solid #2a75bb;
        border-radius: 20px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .pokemon-img-container {
        background-color: #fff;
        border: 5px solid #2a75bb;
        border-radius: 15px;
        margin: -50px auto 10px auto;
        width: 150px;
        height: 150px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .pokemon-img-container img {
        width: 120%; /* Hacemos la imagen un poco más grande que su contenedor */
        image-rendering: pixelated; /* Mantiene el estilo pixel art */
    }
    .pokemon-abilities .badge {
        background-color: #ffcb05 !important;
        color: #2a75bb !important;
        border: 2px solid #2a75bb;
        font-size: 1rem;
    }
</style>

<div class="container">
    <h1 class="text-center mb-4">5. Buscador de Pokémon ⚡</h1>
    <p class="text-center">Ingresa el nombre de un Pokémon para ver sus datos.</p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="pokemon_name" placeholder="Ej: pikachu, ditto, mew" required>
                    <button type="submit" class="btn" style="background-color: #ffcb05; color: #2a75bb; border: 2px solid #2a75bb; font-weight: bold;">¡Atrapálos ya!</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5">
        <?php if ($error): ?>
            <div class="alert alert-danger mx-auto" style="max-width: 500px;">🚨 <?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($resultado): ?>
            <div class="card mx-auto card-pokemon" style="max-width: 500px;">
                <div class="pokemon-img-container">
                    <img src="<?php echo $resultado->sprites->front_default; ?>" alt="Sprite de <?php echo $resultado->name; ?>">
                </div>
                <div class="card-body text-center">
                    <h2 class="card-title text-capitalize fw-bold" style="color: #2a75bb;"><?php echo $resultado->name; ?></h2>
                    
                    <?php if (isset($resultado->cries->latest)): ?>
                        <audio controls autoplay class="mb-3" style="width: 100%;">
                            <source src="<?php echo $resultado->cries->latest; ?>" type="audio/ogg">
                            Tu navegador no soporta el audio.
                        </audio>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col">
                            <h5>Experiencia Base</h5>
                            <p class="fs-3 fw-bold"><?php echo $resultado->base_experience; ?></p>
                        </div>
                    </div>
                    
                    <h5>Habilidades</h5>
                    <div class="pokemon-abilities">
                        <?php foreach ($resultado->abilities as $habilidad): ?>
                            <span class="badge m-1 p-2"><?php echo ucfirst($habilidad->ability->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include '../partials/footer.php';
?>