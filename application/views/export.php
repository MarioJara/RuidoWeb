<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Descarga
        <small>Descargar mediciones</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Descarga</li>
      </ol>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-body">
                        <form action="<?php echo current_url(); ?>" method="post" class="form-inline">
                            <div class="form-group">
                                <label for="date">Fecha: </label>
                                <input type="text" class="form-control" id="date" name="date" placeholder="desde">
                                <input type="text" class="form-control" id="date-to" name="date_to" placeholder="hasta">
                            </div>
                            <div class="form-group">
                                <label for="admin">&nbsp;&nbsp;Mutualidad: </label>
                                <select class="form-control" name="admin" id="admin">
                                    <option>---</option>
                                    <option>IST</option>
                                    <option>ACHS</option>
                                    <option>Mutual de Seguridad</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="company">&nbsp;&nbsp;Empresa: </label>
                                <select class="form-control" name="company" id="company">
                                    <?php foreach($companies as $company) { ?>
                                    <option class="<?php echo $company->admin; ?>"><?php echo $company->company; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="space">&nbsp;&nbsp;Puesto de trabajo: </label>
                                <select class="form-control" name="space" id="space">
                                    <?php foreach($spaces as $space) { ?>
                                    <option class="<?php echo $space->company; ?>"><?php echo $space->space; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            &nbsp;&nbsp;<button type="submit" class="btn btn-default">Descargar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>