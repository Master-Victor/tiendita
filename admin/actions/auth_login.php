<?PHP
require_once "../../functions/autoload.php";

$postData = $_POST;
echo "<pre>";
print_r($postData['pass']);
echo password_hash($postData['pass'], PASSWORD_DEFAULT); 
echo "</pre>";
$login = (new Autenticacion())->log_in($postData['username'], $postData['pass']);

 if($login){
    if( $login != "usuario" )
        header('location: ../index.php?sec=dashboard');
    else{
        header('location: ../../index.php');
    }
 }else{
    header('location: ../../index.php?sec=login');
 }
