<div class=" d-flex justify-content-center p-5">
    <div>
        <h1 class="text-center mb-5 fw-bold">Probando cosas</h1>
        <div class="row mb-5 d-flex align-items-center">
            <div class="col">
                <?PHP

                $objetoPersonaje = new Personaje();
                $listaCompleta = $objetoPersonaje->lista_completa();



                $objetoPersonaje->insert('Billy Kaplan', "Wiccan", "Allan Heingberg, Jim Cheung", "1986", "Reclutado para los Jóvenes Vengadores por Iron Lad, la historia de Wiccan incluye el descubrimiento de que él y su compañero héroe adolescente Speed son, de hecho, hermanos gemelos perdidos hace mucho tiempo, y que la pareja son los hijos de Scarlet Witch y su esposo Visión. Las historias más importantes para el personaje incluyen la búsqueda de él y su hermano de su madre desaparecida, aprender a dominar sus poderes y una relación continua con su compañero de equipo Hulkling.", "");


                echo "<pre>";
                print_r($listaCompleta);
                echo "</pre>";

                ?>
            </div>
        </div>
    </div>
</div>