<?php
require_once "../../functions/autoload.php";
$id = $_GET["id"];

if($id){
    (new Carrito())->borrar_item($id);
    header('location: ../../index.php?sec=carrito');
}