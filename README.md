# Portal de APIs Dinámico 🚀

¡Bienvenido al Portal de APIs Dinámico! Este es un proyecto web desarrollado en PHP como una demostración práctica para consumir y mostrar datos de 10 APIs externas diferentes. Cada API tiene su propia página y funcionalidad, presentando la información obtenida de forma visualmente atractiva y funcional.

## ✨ Características

El portal incluye la implementación de las siguientes 10 APIs:

1.  **Predicción de Género:** Estima el género de un nombre usando [Genderize.io](https://genderize.io/).
2.  **Predicción de Edad:** Estima la edad de un nombre usando [Agify.io](https://agify.io/).
3.  **Buscador de Universidades:** Encuentra universidades en un país específico usando la [Universities API](http://universities.hipolabs.com/).
4.  **Clima Actual:** Muestra el clima en tiempo real de una ciudad usando [OpenWeatherMap](https://openweathermap.org/).
5.  **Información de Pokémon:** Obtiene datos de un Pokémon, incluyendo su imagen y sonido, desde [PokeAPI](https://pokeapi.co/).
6.  **Últimas Noticias de WordPress:** Extrae los 3 artículos más recientes de blogs de tecnología vía la [WP REST API](https://developer.wordpress.org/rest-api/).
7.  **Conversor de Monedas:** Convierte montos de USD a otras monedas con las tasas de cambio de [ExchangeRate-API](https://www.exchangerate-api.com/).
8.  **Generador de Imágenes:** Genera imágenes de alta calidad basadas en una palabra clave usando [Unsplash](https://unsplash.com/).
9.  **Datos de un País:** Muestra información detallada de un país (bandera, capital, población) desde [REST Countries](https://restcountries.com/).
10. **Generador de Chistes:** Muestra un chiste aleatorio en español usando [JokeAPI](https://v2.jokeapi.dev/).

## 🛠️ Tecnologías Utilizadas

* **Backend:** PHP
* **Frontend:** HTML5, CSS3
* **Framework CSS:** Bootstrap 5
* **Servidor Local:** XAMPP (Apache)

## ⚙️ Guía de Instalación y Ejecución

Para ejecutar este portal en tu propia máquina, sigue estos pasos:

1.  **Prerrequisitos:**
    * Asegúrate de tener **XAMPP** instalado. Puedes descargarlo desde [aquí](https://www.apachefriends.org/es/index.html).

2.  **Clonar/Descargar el Proyecto:**
    * Descarga o clona los archivos de este proyecto en tu computadora.

3.  **Mover el Proyecto a `htdocs`:**
    * Mueve la carpeta completa del proyecto (`portal-apis/`) a la carpeta de servidor de XAMPP. La ruta usualmente es: `C:\xampp\htdocs\`

4.  **Iniciar el Servidor Apache:**
    * Abre el Panel de Control de XAMPP.
    * Haz clic en el botón **`Start`** al lado del módulo **Apache**. Espera a que se ponga de color verde.

5.  **Configurar las API Keys (¡Paso Crucial!):**
    * Este proyecto necesita 3 llaves de API (API Keys) para funcionar completamente.
    * **API del Clima (OpenWeatherMap):**
        * Regístrate en [OpenWeatherMap](https://openweathermap.org/home/sign_up) para obtener tu llave.
        * Abre el archivo `apis/4_clima.php`.
        * Pega tu llave en la variable `$apiKey`.
    * **API de Monedas (ExchangeRate-API):**
        * Regístrate en [ExchangeRate-API](https://www.exchangerate-api.com/pricing) (plan gratuito).
        * Abre el archivo `apis/7_monedas.php`.
        * Pega tu llave en la variable `$apiKey`.
    * **API de Imágenes (Unsplash):**
        * Regístrate como desarrollador en [Unsplash](https://unsplash.com/developers).
        * Abre el archivo `apis/8_imagenes.php`.
        * Pega tu "Access Key" en la variable `$accessKey`.

6.  **Acceder al Portal:**
    * Abre tu navegador web y ve a la siguiente dirección:
    * `http://localhost/portal-apis/`

¡Y listo! El portal debería estar funcionando a la perfección.

---

## 👨‍💻 Autor

Desarrollado por **Axel Darwin Tavarez Polanco**.