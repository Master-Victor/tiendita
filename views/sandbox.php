<div class=" d-flex justify-content-center p-5">
    <div>
        <h1 class="text-center mb-5 fw-bold">Probando cosas</h1>
        <div class="row mb-5 d-flex align-items-center">
            <div class="col">
                <?PHP

                    (new Alerta())->add_alerta("warning", "amarillo");
                    echo "<pre>";
                    print_r($_SESSION);
                    echo "</pre>";
                    echo (new Alerta())->get_alertas();
                    //(new Alerta())->clear_alertas();
                ?>
            </div>
        </div>
    </div>
</div>