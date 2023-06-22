<?php

class Carrito
{
    //agregar items
    /**
     * Agrega un item al carrito de compras
     * @param int $productoID El ID del producto que se va a agregar.
     * @param int $cantidad La cantidad de unidades del producto que se van a agregar
     */
    public function add_item(int $productoID, int $cantidad)
    {
        $item = (new Comic())->producto_x_id($productoID);
        if ($item) {
            $_SESSION["carrito"][$productoID] = [
                'producto' => $item->nombre_completo(),
                'titulo' => $item->getTitulo(),
                'portada' => $item->getPortada(),
                'precio' => $item->getPrecio(),
                'cantidad' => $cantidad
            ];
        }
    }
    //eliminar items
    //limpiar todo
    public function clear_items()
    {
        $_SESSION['carrito'] = [];
    }
    //obtener carrito
    public function get_carrito()
    {
        if (!empty($_SESSION['carrito'])) {
            return $_SESSION['carrito'];
        } else {
            return [];
        }
    }
    //precio total
    public function get_total(){
        $total = 0;
        if( $_SESSION["carrito"] ){
            foreach($_SESSION["carrito"] as $item){
                $total += $item["precio"] * $item["cantidad"];
            }
        }
        return $total;
    }
    //modificar cantidad
    public function update_cantidades($cantidades){
        foreach( $cantidades as $id => $cantidad ){
            if( isset($_SESSION["carrito"][$id]) ){
                $_SESSION["carrito"][$id]["cantidad"] = $cantidad;
            }  
        }
    }
    //eliminar item individual
    public function borrar_item(int $id)
    {
        if (isset($_SESSION["carrito"][$id])) {
            unset($_SESSION["carrito"][$id]);
        }
    }
}
