<html>
<body>
    <p>Se ha realizado una medición de ruido con la aplicación móvil, la que ha calculado un nivel de exposición de <?php echo $item->loudness; ?> dB(A).</p>
    <p></p>
    <p>Por ello, se recomienda contactar a su organismo administrador  para la realización de un screening con instrumentos normados para corroborar el estado de exposición.</p>
    <p></p>
    <p>Los antecedentes de la medición son los siguientes:</p>
    <p></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha y hora: <?php echo $item->created_on; ?></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mutualidad: <?php echo $item->admin; ?></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Empresa: <?php echo $item->company; ?></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Puesto de trabajo: <?php echo $item->space; ?></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Coordenadas: (<?php echo $item->position; ?>)</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nivel de ruido en dB(A): <?php echo $item->loudness; ?></p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nivel de exposición: <?php echo $item->level; ?></p>

    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Resultado:</p>

    <p style="text-align: center;">
        <img src="<?php echo $item->image; ?>" style="margin-top: -130px;" />
    </p>
    
    
    
    <p>Para descargar el detalle completo de la medición, <a href="http://52.38.187.44/prexor/welcome/download_csv/<?php echo $item->id; ?>">haga clic en este enlace</a>.</p>

</body>
</html>