<?PHP
$comics = (new comic())->catalogo_completo();

?>
<div class="row my-5">
    <div class="col">

        <h1 class="text-center mb-5 fw-bold">Administración de Comics</h1>
        <div class="row mb-5 d-flex align-items-center">


            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" width="15%">Portada</th>
                        <th scope="col" width="15%">Nombre</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Bajada</th>
                        <th scope="col">Personajes Secundarios</th>
                        <th scope="col">Guion</th>
                        <th scope="col">Arte</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?PHP foreach ($comics as $C) { ?>
                        <tr>
                            <td><img src="../img/covers/<?= $C->getPortada() ?>" alt="Imágen Illustrativa de <?= $C->nombre_completo() ?>" class="img-fluid rounded shadow-sm"></td>
                            <td><?= $C->nombre_completo() ?></td>
                            <td><?= $C->getTitulo() ?></td>
                            <td><?= $C->getBajada() ?></td>
                            <td><?php 
                                '$personajes = $C->getPersonajes_secundarios_ids();//"1,2,3,4"
                                $personaje_separado = empty($personajes) ? [] : explode(",", $personajes); //[1,2,3,4]
                                if( count($personaje_separado) > 0 ) echo ((new Personaje())->get_x_id($personaje_separado[0]))->getNombre();
                                //echo $personajes;'
                            ?></td>
                            <td><?= $C->getTitulo() ?></td>
                            <td><?= $C->getGuion()->getNombre() ?></td>
                            <td><?= $C->getArte()->getNombre() ?></td>
                            <td>$<?= $C->getPrecio() ?></td>
                            <td>
                                <a href="index.php?sec=edit_comic&id=<?= $C->getId() ?>" role="button" class="d-block btn btn-sm btn-warning mb-1">Editar</a>
                                <a href="index.php?sec=delete_comic&id=<?= $C->getId() ?>" role="button" class="d-block btn btn-sm btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?PHP } ?>
                </tbody>
            </table>

            <a href="index.php?sec=add_comic" class="btn btn-primary mt-5"> Cargar nuevo Comic</a>
        </div>


    </div>
</div>