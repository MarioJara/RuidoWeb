<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes de Periodicidad
        <small>Ajustar los reportes</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="welcome/reports"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reportes de Periodicidad</li>
      </ol>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Detalles mediciones</h3>
                  <a href="welcome/add_report" class="btn btn-default pull-right">+ Crear nuevo</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Periodicidad</th>
                      <th>Destinatarios</th>
                      <th>Mutualidad</th>
                      <th>Empresa</th>
                      <th>Fecha y hora de creación</th>
                      <th>Accion</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $labels = array(); $data = array(); ?>
                        <?php foreach($reports as $report) { ?>
                    <tr>
                        <td><?php echo $report->id; ?></td>
                        <td><?php echo $report->period; ?></td>
                        <td><?php echo $report->emails; ?></td>
                        <td><?php echo $report->admin; ?></td>
                        <td><?php echo $report->company; ?></td>
                        <td><?php echo $report->created_on; ?></td>
                        <td><a href="welcome/delete_report/<?php echo $report->id; ?>" class="btn btn-xs btn-danger">eliminar</a></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>