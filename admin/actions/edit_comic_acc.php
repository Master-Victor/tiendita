<?PHP
require_once "../../functions/autoload.php";
$id = $_GET['id'] ?? FALSE;
$postData = $_POST;
$fileData = $_FILES['portada'];


echo "<pre>";
print_r($postData);
echo "</pre>";

try {
    $comic = new Comic();
    // echo "<pre>";
    // print_r($fileData);
    // echo "</pre>";

    //empty retorna true en caso que tengamos false, null, 0, "" ó []

    //Necesito borrar mis personajes secundarios y Luego almacenar los nuevos
    (new Comic())->clear_personajes_sec($id);
    print_r($postData['personajes_secundarios'] );
    if (isset($postData['personajes_secundarios'])) {
        foreach ($postData['personajes_secundarios'] as $personaje_id) {
            $comic->add_personajes_sec($id, $personaje_id);
        }
    }

    $imagen = (new Imagen())->subirImagen(__DIR__ . "/../../img/covers", $fileData);
    (new Imagen())->borrarImagen(__DIR__ . "/../../img/covers/" . $postData["portada_og"]);
    (new Comic())->edit(
        $postData['titulo'],
        $postData['personaje_principal_id'],
        $postData['serie_id'],
        $postData['guionista_id'],
        $postData['artista_id'],
        $postData['volumen'],
        $postData['numero'],
        $postData['publicacion'],
        $postData['origen'],
        $postData['editorial'],
        $postData['bajada'],
        $postData['precio'],
        $id
    );
    //Necesito almacenar mis personajes secundarios
    //header('Location: ../index.php?sec=admin_comics');
    /**/
} catch (\Exception $e) {
    echo "<pre>";
    print_r($e->getMessage());
    echo "<pre>";
    die("No se pudo cargar el personaje =(");
}
