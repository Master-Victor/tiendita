<?PHP 
session_start();
function autoloadClases($nombreClase){
 //echo "<p> SE SOLICITÓ UNA CLASE NO INCLUIDA:  $nombreClase<p>";

 $archivoClase = __DIR__ . "/../classes/".$nombreClase.".php";

 //echo "<p>ESTA ES NUESTRA RUTA:  $archivoClase</p>";

 if(file_exists($archivoClase)){
    require_once $archivoClase;
}

}

spl_autoload_register('autoloadClases');

?>