<?PHP
$miObjetoComic = new Comic();
$productos = $miObjetoComic->catalogo_completo();

?>
<h1 class="text-center fs-2 my-5"> Nuestro catálogo completo</h1>
<div class="row">

<?PHP if (count($productos)) { ?>
    <?PHP foreach ($productos as $comic) {     
?>
        <div class="col-3">
            <div class="card mb-3">
                <img src="img/covers/<?= $comic->getPortada() ?>" class="card-img-top" alt="Portada de <?= $comic->nombre_completo() ?>">
                <div class="card-body">
                    <p class="fs-6 m-0 fw-bold text-danger"><?= $comic->nombre_completo() ?></p>
                    <h2 class="card-title fs-5"><?=$comic->getTitulo() ?></h2>
                    <p class="card-text"><?= $comic->bajada_reducida() ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><span class="fw-bold">Guion:</span> <?= $comic->getGuion()->getNombre() ?></li>
                    <li class="list-group-item"><span class="fw-bold">Arte:</span> <?= $comic->getArte()->getNombre() ?></li>
                    <li class="list-group-item"><span class="fw-bold">Publicación:</span> <?= $comic->getPublicacion() ?></li>
                </ul>
                <div class="card-body">
                    <div class="fs-3 mb-3 fw-bold text-center text-danger">$<?= $comic->precio_formateado() ?></div>
                    <a href="index.php?sec=producto&id=<?= $comic->getId(); ?>" class="btn btn-danger w-100 fw-bold">VER MÁS</a>
                </div>

            </div>
        </div>
    <?PHP } ?>

<?PHP }else{ ?>
    <div class="col">
    <h2 class="text-center mb-5">No se encontraron productos.</h2>
</div>
<?PHP } ?>



</div>