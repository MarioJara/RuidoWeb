<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Mediciones</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Nombre Empresa</th>
                  <th>Organismo Administrador</th>
                  <th>Puesto trabajo</th>
                  <th>Total Mediciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($measurements as $m) { ?>
                <tr>
                    <td><a href="welcome/details/<?php echo $m->admin; ?>/<?php echo $m->company; ?>/<?php echo $m->space; ?>"><?php echo $m->company; ?></a></td>
                    <td><?php echo $m->admin; ?></td>
                    <td><?php echo $m->space; ?></td>
                    <td><?php echo $m->count; ?></td>
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