<?php

require_once "../../functions/autoload.php";

$postData = $_POST;

if(!empty($postData)){
    (new Carrito())->update_cantidades($postData["cantidad"]);
    header('location: ../../index.php?sec=carrito');
}