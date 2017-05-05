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
                <div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">Bar Chart</h3>
                      <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="area-chart" style="height:230px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
            </div>
        </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Detalles mediciones</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Fecha</th>
                  <th>Ruido</th>
                  <th>Exposición</th>
                  <th>Duración</th>
                  <th>Latitud</th>
                  <th>Longitud</th>
                  <th>Empresa</th>
                  <th>Mutualidad</th>
                  <th>Email</th>
                  <th>Area</th>
                  <th>Puesto</th>
                  <th>Tarea</th>
                  <th>Tipo medición</th>
                  <th>Marca Sonómetro</th>
                  <th>Modelo Sonómetro</th>
                  <th>Num. Serie Sonómetro</th>
                  <th>Fuente</th>
                  <th>Otras fuentes</th>
                  <th>Tpo. Exposición</th>
                  <th>Cant. Tjadores</th>
                  <th>Otros puestos</th>
                  <th>Uso protección</th>
                  <th>Tipo protección</th>
                  <th>Info. Protección</th>
                  <th>Observaciones</th>
                  
                </tr>
                </thead>
                <tbody>
                    <?php $labels = array(); $data = array(); ?>
                    <?php foreach($details as $m) { ?>
                        <?php $labels[] = $m->created_on; ?>
                        <?php $data[] = array($m->loudness); ?>
                        <?php $position = json_decode($m->position); ?>
                        <?php
                        $audio_level_text = "Tarea con probable nivel sobre 10 veces el límite permisible para 8 horas de exposición.";
                        if($m->loudness <= 80) {
                            $audio_level_text = "Tarea de probable nivel bajo";
                        } else if($m->loudness > 80 && $m->loudness <= 82) {
                            $audio_level_text = "Tarea con probable nivel sobre criterio de exposición de 80 dB (A).";
                        } else if($m->loudness > 82 && $m->loudness <= 85) {
                            $audio_level_text = "Tarea con probable nivel sobre el criterio de acción de 82 dB(A).";
                        } else if($m->loudness > 85 && $m->loudness <= 95) {
                            $audio_level_text = "Tarea con probable nivel sobre el límite permisible para 8 horas de exposición.";
                        }
                        ?>
                <tr>
                    <td><?php echo $m->file_id; ?></td>
                    <td><?php echo $m->created_on; ?></td>
                    <td><?php echo $m->loudness; ?></td>
                    <td><?php echo $audio_level_text; ?></td>
                    <td><?php echo $m->time_interval; ?></td>
                    <td><?php echo $position->latitude; ?></td>
                    <td><?php echo $position->longitude; ?></td>
                    <td><?php echo $m->company; ?></td>
                    <td><?php echo $m->admin; ?></td>
                    <td><?php echo $m->email; ?></td>
                    <td><?php echo $m->area; ?></td>
                    <td><?php echo $m->space; ?></td>
                    <td><?php echo $m->tasks; ?></td>
                    <td><?php echo $m->events_characteristics; ?></td>
                    <td><?php echo $m->external_type; ?></td>
                    <td><?php echo $m->external_model; ?></td>
                    <td><?php echo $m->external_serial; ?></td>
                    <td><?php echo $m->primary_source; ?></td>
                    <td><?php echo $m->other_sources; ?></td>
                    <td><?php echo $m->hours; ?></td>
                    <td><?php echo $m->count; ?></td>
                    <td><?php echo $m->other_afected; ?></td>
                    <td><?php echo $m->use_protection; ?></td>
                    <td><?php echo $m->protection_type; ?></td>
                    <td><?php echo $m->protection_model; ?></td>
                    <td><?php echo $m->aditional; ?></td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
                </div>
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
<script>
    var labels = <?php echo json_encode($labels); ?>;
    var data = <?php echo json_encode($data); ?>;
    console.log(labels)
    console.log(data)
</script>