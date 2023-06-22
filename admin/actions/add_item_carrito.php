<?php
require_once "../../functions/autoload.php";

$id = $_GET['id'] ?? FALSE;
$cantidad = $_GET["cantidad"] ?? 1;
if($id){
    (new Carrito())->add_item($id,$cantidad );
    header('Location: ../../index.php?sec=carrito');
}