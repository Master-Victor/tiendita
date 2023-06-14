<?PHP
require_once "../functions/autoload.php";
echo "<pre>";
print_r($_SESSION);
echo isset($_SESSION['loggedIn']) ? "TRUE" : "FALSE";
$session = isset($_SESSION['loggedIn']) ? '' : 'd-none';
echo "</pre>";

//(new Autenticacion())->verify();

$secciones_validas = [
    "dashboard" => [
        "titulo" => "Panel de administración",
        "restringido" => TRUE
    ],
    "admin_comics" => [
        "titulo" => "Administrar comics",
        "restringido" => TRUE
    ],
    "admin_personajes" => [
        "titulo" => "Administrar Personajes",
        "restringido" => TRUE
    ],
    "admin_series" => [
        "titulo" => "Administrar series",
        "restringido" => TRUE
    ],
    "admin_artistas" => [
        "titulo" => "Administrar artistas",
        "restringido" => TRUE
    ],
    "admin_guionistas" => [
        "titulo" => "Administrar guionistas",
        "restringido" => TRUE
    ],
    "add_comic" => [
        "titulo" => "Agregar Personajes",
        "restringido" => TRUE
    ],
    "add_personaje" => [
        "titulo" => "Agregar Personajes",
        "restringido" => TRUE
    ],
    "edit_personaje" => [
        "titulo" => "Editar datos de Personaje",
        "restringido" => TRUE
    ],
    "delete_personaje" => [
        "titulo" => "Eliminar datos de Personaje",
        "restringido" => TRUE
    ],
    "edit_comic" => [
        "titulo" => "editar Comic",
        "restringido" => TRUE
    ],
    "login" => [
        "titulo" => "Iniciar sesión",
        "restringido" => FALSE
    ],
];

//null coalesce. Unicamente en PHP 7+

//Ternario: Si sec esta definida y no es NULL en la supregloblal, se la asigna a $seccion, sino, asigna home
//$seccion = isset($_GET['sec']) ? $_GET['sec'] : "home";
//Ternario: Si ser esta definida y no es NULL en la supregloblal, se la asigna a $serieSeleccionada, sino, asigna FALSE
//$serieSeleccionada = isset($_GET['ser']) ? $_GET['ser'] : FALSE;

//null coalesce (??). Unicamente en PHP 7+
//Si una variable esta definida y no es NULL la asigna, sino asginga la alternativa. Lo mismo pero mas conciso.
$seccion = $_GET['sec'] ?? "dashboard";


if (!array_key_exists($seccion, $secciones_validas)) {
    $vista = "404";
    $titulo = "404 - Página no encontrada";
} else {
    $vista = $seccion;
    $titulo = $secciones_validas[$seccion]['titulo'];
    if( $secciones_validas[$seccion]['restringido'] ){
        if( !isset($_SESSION['loggedIn']) ){
            header('location: index.php?sec=login');
            //echo "Restringido";
        }
    }
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

    <link href="../css/styles.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="../img/logo.png" class="logo" alt="Logo de la tienda"> Tiendita de Comics</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item <?= $session ?>">
                        <a class="nav-link active" href="index.php?sec=dashboard">Home</a>
                    </li>
                    <li class="nav-item <?= $session ?>">
                        <a class="nav-link" href="index.php?sec=admin_comics">Administrar Comics</a>
                    </li>
                    <li class="nav-item <?= $session ?>">
                        <a class="nav-link" href="index.php?sec=admin_personajes">Administrar Personajes</a>
                    </li>
                    <li class="nav-item <?= $session ?>">
                        <a class="nav-link" href="index.php?sec=admin_series">Administrar Series</a>
                    </li>
                    <li class="nav-item <?= $session ?>">
                        <a class="nav-link" href="index.php?sec=admin_artistas">Administrar Artistas</a>
                    </li>
                    <li class="nav-item <?= $session ?>">
                        <a class="nav-link" href="index.php?sec=admin_guionistas">Administrar Guionistas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?sec=login">Login</a>
                    </li> 
                    <li class="nav-item <?= $session ?>">
                        <a class="nav-link" href="actions/auth_logout.php">Cerrar session</a>
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
    <footer class="bg-info text-light text-center">
         2022
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>