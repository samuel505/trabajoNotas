<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $data['titulo']; ?></h1>

</div>

<!-- Content Row -->

<div class="row">
<?php if (isset($data['resultado'])) { ?>
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>

                                    <th>Módulo</th>
                                    <th>Media</th>
                                    <th>Aprobados</th>
                                    <th>Suspensos</th>
                                    <th>Máximo</th>
                                    <th>Mínimo</th>

                                </thead>
                                <tbody>

                                    <?php foreach ($data['resultado']['asignaturas'] as $asignatura => $value) { ?>
                                        <tr>
                                            <td><?php echo $asignatura ?></td>
                                            <td><?php echo $value['media'] ?></td>
                                            <td><?php echo $value['aprobados']  ?></td>
                                            <td><?php echo $value['suspensos']  ?></td>
                                            <td><?php echo implode(": ", $value['max'])  ?></td>
                                            <td><?php echo implode(": ", $value['min'])  ?></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>

                            </table>
                        </div>
                    <?php } ?>


                    <?php if (isset($data['resultado'])) { ?>
                        <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="alert alert-success">
                                <ul>
                                    <p>Aprobado todo</p>
                                    <?php
                                    foreach ($data['resultado']['alumnos']  as $nombre => $datos) {
                                        if ($datos['suspensos'] == 0) {
                                            echo "<li>$nombre</li>";
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="alert alert-warning">
                                <ul>
                                    <p>Suspendido al menos una asignatura</p>
                                    <?php
                                    foreach ($data['resultado']['alumnos'] as $nombre => $datos) {
                                        if ($datos['suspensos'] >= 1) {
                                            echo "<li>$nombre</li>";
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>



                        <div class="col-12 col-lg-6">
                            <div class="alert alert-info">
                                <ul>
                                    <p>Promocionan</p>
                                    <?php
                                    foreach ($data['resultado']['alumnos']  as $nombre => $datos) {
                                        if ($datos['suspensos'] <= 1) {
                                            echo "<li>$nombre</li>";
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="alert alert-danger">
                                <ul>
                                    <p>No promocionan</p>
                                    <?php
                                    foreach ($data['resultado']['alumnos']  as $nombre => $datos) {
                                        if ($datos['suspensos'] >= 2) {
                                            echo "<li>$nombre</li>";
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div></div>

                    <?php  } ?>
    <div class="col-12">
        
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo']; ?></h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post">        
                               -->
                               

                <form method="post" action="./?sec=trabajoNotas.samuelBarros">

                    <div class="mb-3">
                        <label for="json">Inserta JSON</label>
                        <textarea class="form-control" id="json" name="json" rows="5"><?php echo isset($data['input']) ? $data['input'] : ""    ?></textarea>
                    </div>


                    <p class="text-danger"><?php
                                            $string = "";
                                            if (isset($data['errores'])) {
                                                $errores = $data['errores'];
                                                foreach ($errores as $key => $value) {

                                                    $string .= $value . "<br>";
                                                }
                                            }
                                            echo $string; ?></p>

                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>