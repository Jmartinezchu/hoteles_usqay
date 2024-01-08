<?php 
	
	if($grafica = "ventasMes"){
		$pagosMes = $data;
		// var_dump($pagosMes);
 ?>
<script>
		Highcharts.chart('graficames', {
        colors: [ '#0F4B81'],
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Ventas de <?= $pagosMes['mes'].' '.$pagosMes['anio']?>'
    },
    subtitle: {
        text: 'Total de ventas <?= formatMoney($pagosMes['total'])?>'
    },
    xAxis: {
        categories: [
			<?php
			 foreach ($pagosMes['ventas'] as $dia){
				echo $dia['total'].",";
			} 
			?>	<?php
			foreach ($pagosMes['ventas'] as $dia){
			   echo $dia['dia'].",";
		   } 
		   ?>
		]
    },
	xAxis: {
          categories: [
            <?php 
                foreach ($pagosMes['ventas'] as $dia) {
                  echo $dia['dia'].",";
                }
            ?>
          ]
      },
      yAxis: {
          title: {
              text: ''
          }
      },
      plotOptions: {
          line: {
              dataLabels: {
                  enabled: true
              },
              enableMouseTracking: false
          }
      },
      series: [{
          name: 'Dato',
          data: [
            <?php 
                foreach ($pagosMes['ventas'] as $dia) {
                  echo $dia['total'].",";
                }
            ?>
          ]
      }]
  });
</script>
<?php } ?>



<?php 
	
	if($grafica = "pagosReservas"){
		$reservas = $data;
 ?>

 <script>

Highcharts.chart('graficaReserva',{
        colors: [ '#0F4B81'],
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Pago de reservas de <?= $reservas['mes'].' '.$reservas['anio']?>'
    },
    subtitle: {
        text: 'Total de ventas <?= formatMoney($reservas['total'])?>'
    },
    xAxis: {
        categories: [
			<?php
			 foreach ($reservas['reservas'] as $dia){
				echo $dia['total'].",";
			} 
			?>	<?php
			foreach ($reservas['reservas'] as $dia){
			   echo $dia['dia'].",";
		   } 
		   ?>
		]
    },
	xAxis: {
          categories: [
            <?php 
                foreach ($reservas['reservas'] as $dia) {
                  echo $dia['dia'].",";
                }
            ?>
          ]
      },
      yAxis: {
          title: {
              text: ''
          }
      },
      plotOptions: {
          line: {
              dataLabels: {
                  enabled: true
              },
              enableMouseTracking: false
          }
      },
      series: [{
          name: 'Dato',
          data: [
            <?php 
                foreach ($reservas['reservas'] as $dia) {
                  echo $dia['total'].",";
                }
            ?>
          ]
      }]
    });
 </script>

<?php } ?>