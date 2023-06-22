<?PHP
require_once "functions/autoload.php";

$secciones_validas = [
    "home" => [
        "titulo" => "Bienvenidos"
    ],
    "envios" => [
        "titulo" => "Políticas de envío"
    ],
    "quienes_somos" => [
        "titulo" => "¿Quienes Somos?"
    ],
    "comics" => [
        "titulo" => "Comics por personaje"
    ],
    "catalogo_completo" => [
        "titulo" => "Nuestro catálogo"
    ],
    "producto" => [
        "titulo" => "Detalle de producto"
    ],
    "sandbox" => [
        "titulo" => "Sandbox para testeo"
    ],
    "login" => [
        "titulo" => "Login" 
    ],
    "carrito" => [
        "titulo" => "Carrito" 
    ]
];

//null coalesce. Unicamente en PHP 7+

//Ternario: Si sec esta definida y no es NULL en la supregloblal, se la asigna a $seccion, sino, asigna home
//$seccion = isset($_GET['sec']) ? $_GET['sec'] : "home";
//Ternario: Si ser esta definida y no es NULL en la supregloblal, se la asigna a $serieSeleccionada, sino, asigna FALSE
//$serieSeleccionada = isset($_GET['ser']) ? $_GET['ser'] : FALSE;

//null coalesce (??). Unicamente en PHP 7+
//Si una variable esta definida y no es NULL la asigna, sino asginga la alternativa. Lo mismo pero mas conciso.
$seccion = $_GET['sec'] ?? "home";

$userData = $_SESSION["loggedIn"] ?? FALSE;
if (!array_key_exists($seccion, $secciones_validas)) {
    $vista = "404";
    $titulo = "404 - Página no encontrada";
} else {
    $vista = $seccion;
    $titulo = $secciones_validas[$seccion]['titulo'];
}
//$miTituloSeccionBonito = ucfirst(str_replace("_", " ", $vista));
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Tiendita de Comics :: <?= $titulo; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="img/logo.png" class="logo" alt="Logo de la tienda"> Tiendita de Comics</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?sec=home">Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Catálogo
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="index.php?sec=comics&pj=1">Ms. Marvel</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?sec=comics&pj=2">Hawkeye / Ojo de Halcón</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?sec=comics&pj=3">She-Hulk</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?sec=catalogo_completo">Catalogo Completo</a>
                            </li>
               
                        </ul>
                    </li>
                    <li class="nav-item">
                                <a class="nav-link" href="index.php?sec=quienes_somos">¿Quienes somos?</a>
                            </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?sec=envios">Envios</a>
                    </li>
                    <li class="nav-item <?= $userData ? "d-none" : "" ?>">
                        <a class="nav-link" href="index.php?sec=login">Login</a>
                    </li>
                    <li class="nav-item <?= $userData ? "" : "d-none" ?>">
                        <a class="nav-link" href="admin/actions/auth_logout.php">Cerrar sesion</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="index.php?sec=carrito">Carrito</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container">

        <?PHP
        //require "views/$seccion.php";
        require file_exists("views/$vista.php") ? "views/$vista.php" : "views/404.php";

        ?>

    </main>
    <footer class="bg-secondary text-light text-center">
        2022
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>