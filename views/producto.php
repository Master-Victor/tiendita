<?PHP
$id = $_GET['id'] ?? FALSE;
$miObjetoComic = new Comic();
$comic = $miObjetoComic->producto_x_id(intval($id));
echo "<pre>";
print_r($comic);
echo "</pre>";
?>

<div class="row">
<?PHP if (isset($comic)) { ?>
    <h1 class="text-center my-5"> <?= $comic->nombre_completo() ?></h1>
    <div class="col">
            <div class="card mb-5">
                <div class="row g-0">
                    <div class="col-md-5">
                        <img src="img/covers/<?= $comic->getPortada() ?>" class="img-fluid rounded-start border-end" alt="Portada de  <?= $comic->nombre_completo() ?>">
                    </div>
                    <div class="col-md-7 d-flex flex-column p-3">
                        <div class="card-body flex-grow-0">
                            <p class="fs-4 m-0 fw-bold text-danger"><?= $comic->nombre_completo() ?></p>
                            <h2 class="card-title fs-2 mb-4"><?= $comic->getTitulo(); ?></h2>
                            <p class="card-text"><?= $comic->getBajada() ?></p>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="fw-bold">Guion:</span> <?= $comic->getGuion()->getNombre(); ?></li>
                            <li class="list-group-item"><span class="fw-bold">Arte:</span> <?= $comic->getArte()->getNombre(); ?></li>
                            <li class="list-group-item"><span class="fw-bold">Publicación:</span> <?= $comic->getPublicacion() ?></li>
                        </ul>

                        <div class="card-body flex-grow-0 mt-auto">
                            <div class="fs-3 mb-3 fw-bold text-center text-danger">$<?= $comic->precio_formateado() ?></div>
                            <form action="admin/actions/add_item_carrito.php" method="GET" class="row">
                            <div class="col-6 d-flex align-items-center">
                                    <label for="q" class="fw-bold me-2">Cantidad: </label>
                                    <input type="number" class="form-control" value="1" name="cantidad" id="cantidad">
                                </div>
                                <div class="col-6">
                                    <input type="submit" value="COMPRAR" class="btn btn-danger w-100 fw-bold">
                                    <input type="hidden" value="<?= $id ?>" name="id" id="id">

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


         </div>




<?PHP }else{ ?>
    <div class="col">
    <h2 class="text-center m-5">No se encontró el producto deseado.</h2>
</div>
<?PHP } ?>



</div>