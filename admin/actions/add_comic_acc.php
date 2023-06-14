<?PHP
require_once "../../functions/autoload.php";

$postData = $_POST;
$fileData = $_FILES['portada'];


     echo "<pre>";
     print_r($postData);
     echo "</pre>";

try {

    // echo "<pre>";
    // print_r($fileData);
    // echo "</pre>";

    //empty retorna true en caso que tengamos false, null, 0, "" ó []
   
    $imagen = (new Imagen())->subirImagen(__DIR__ . "/../../img/covers", $fileData);
    $comicId = (new Comic())->insert(
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
        $imagen, 
        $postData['precio']
    );
    echo $comicId;
    print_r($postData["personajes_secundarios"]);
    foreach( $postData["personajes_secundarios"] as $ps ){
        (new Comic())->add_personajes_sec($comicId, $ps);
    }
    header('Location: ../index.php?sec=admin_comics');
   /**/

} catch (\Exception $e) {
    echo "<pre>";
    print_r($e->getMessage());
    echo "<pre>";
    die("No se pudo cargar el personaje =(");
}
