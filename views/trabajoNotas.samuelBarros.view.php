<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $data['titulo']; ?></h1>

</div>

<!-- Content Row -->

<div class="row">

    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo']; ?></h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post">                   -->
                <form method="post" action="./?sec=trabajoNotas.samuelBarros">

                    <div class="alert alert-success">


                    </div>

                    <div class="alert alert-warning">


                    </div>

                    <div class="alert alert-info">


                    </div>

                    <div class="alert alert-danger">


                    </div>



                    <div class="mb-3">
                        <label for="json">Inserta JSON</label>
                        <textarea class="form-control" id="json" name="json" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>