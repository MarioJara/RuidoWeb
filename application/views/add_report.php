<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes de Periodicidad
        <small>Nuevo reporte</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="welcome/reports"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="welcome/add_report"><i class="fa fa-dashboard"></i> Reportes de Periodicidad</a></li>
        <li class="active">Nuevo reporte</li>
      </ol>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-body">
                        <form action="<?php echo current_url(); ?>" method="post" class="form">
                            <div class="form-group">
                                <label for="period">Periodicidad (en dias)</label>
                                <input type="text" class="form-control" id="period" name="period" placeholder="7">
                            </div>
                            <div class="form-group">
                                <label for="emails">Destinatarios </label>
                                <input type="text" class="form-control" id="emails" name="emails" placeholder="Listado de emails, separados por coma">
                            </div>
                            <div class="form-group">
                                <label for="admin">Mutualidad</label>
                                <select class="form-control" name="admin" id="admin">
                                    <option value="">Todas</option>
                                    <option>IST</option>
                                    <option>ACHS</option>
                                    <option>Mutual de Seguridad</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="company">Empresa</label>
                                <select class="form-control" name="company" id="company">
                                    <?php foreach($companies as $company) { ?>
                                    <option class="<?php echo $company->admin; ?>"><?php echo $company->company; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>