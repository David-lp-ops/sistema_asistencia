<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?> 
<body class="hold-transition skin-purple-light sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Horarios
      </h1>
      <ol class="breadcrumb">
        <li><a href="../admin/home.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li>Empleados</li>
        <li class="active">Horarios</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i>¡Proceso Exitoso!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Código de Asistencia</th>
                  <th>Nombre</th>
                  <th>Unidad de Negocio</th>
                  <th>Área</th>
                  <th>Horarios</th>
                  <th>Miembro Desde</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  <?php
                /*    $sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id";*/

                $sql = "SELECT *, employees.id AS empid
                            FROM employees
                            LEFT JOIN position
                            ON position.id = employees.position_id
                            LEFT JOIN schedules
                            ON schedules.id = employees.schedule_id
                            LEFT JOIN negocio
                            ON negocio.id = employees.negocio_id ";
                            /*LEFT JOIN attendance
                            ON attendance.employee_id = employees.employee_id";*/
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td>".$row['employee_id']."</td>
                          <td>".$row['firstname'].' '.$row['lastname']."</td>
                          <td>".$row['nombre_negocio']."</td>
                          <td>".$row['description']."</td>
                      <td>".date('h:i A', strtotime($row['time_in'])).' - '.date('h:i A', strtotime($row['time_out']))."</td>
                      <td>".date('M d, Y', strtotime($row['created_on']))."</td>
                          <td>
                          <button class='btn btn-warning btn-sm edit btn-flat' data-id='".$row['empid']."' data-photo='".$row['photo']."'><i class='fa fa-edit'></i> Detalles</button>
                          </td>
                        </tr>
                      ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/employee_schedule_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'schedule_employee_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.employee_name').html(response.firstname+' '+response.lastname);
      $('#schedule_val').val(response.schedule_id);
      $('#employee_val').val(response.employee_id);
      $('#schedule_val').html(response.time_in+' '+response.time_out);
      $('#empid').val(response.empid);
      $('#employee_name').html(response.firstname+' '+response.lastname);
      $('#position_val').val(response.position_id).html(response.description);
      $('#negocio_val').val(response.negocio_id).html(response.nombre_negocio);
      $('#position_valv2').val(response.description);
      $('#negocio_valv2').val(response.nombre_negocio);
      $('#num_hr').val(response.num_hr);
      
      // Obtener la suma total de horas de trabajo del empleado
      $.ajax({
        type: 'POST',
        url: 'get_total_hours.php',
        data: { employee_id: response.empid },
        dataType: 'json',
        success: function (hoursResponse) {
          $('#sum_num_hr').val(hoursResponse.total_hours);
        }
      });
      $.ajax({
        type: 'POST',
        url: 'get_cantidad_asistencia.php',
        data: { employee_id: response.empid },
        dataType: 'json',
        success: function (assistanceResponse) {
          $('#dias_trabajados').val(assistanceResponse.cantidad_asistencia);
        }
      });
      $.ajax({
        type: 'POST',
        url: 'get_cantidad_faltas.php',
        data: { employee_id: response.empid },
        dataType: 'json',
        success: function (foulsResponse) {
          $('#dias_faltados').val(foulsResponse.cantidad_faltas);
        }
      });
      $.ajax({
        type: 'POST',
        url: 'get_cantidad_tardanzas.php',
        data: { employee_id: response.empid },
        dataType: 'json',
        success: function (tardiesResponse) {
          $('#dias_tardados').val(tardiesResponse.cantidad_tardanzas);
        }
      });
      function generateChart(data) {
        // Aquí puedes utilizar la biblioteca Chart.js para generar el gráfico basado en los datos del empleado
        // Puedes acceder a los datos específicos del empleado, como la cantidad de días trabajados, faltados, etc., a través del objeto 'data'
        // Por ejemplo:
        const diasTrabajados = parseInt(data.dias_trabajados);
        const diasFaltados = parseInt(data.dias_faltados);
        const diasTardados = parseInt(data.dias_tardados);

        // Luego, puedes generar el gráfico utilizando los datos
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ['Faltas', 'Asistencias', 'Tardanzas'],
            datasets: [{
              label: 'Días',
              data: [diasFaltados, diasTrabajados, diasTardados],
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
      
    }
  });
}

function showProfileImage(photo) {
  var imageSrc = photo ? "../images/" + photo : "../images/profile.jpg";
  $('#profile_image').attr('src', imageSrc);
}

$(function() {
  $('.edit').click(function(e) {
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    var photo = $(this).data('photo');
    showProfileImage(photo);
    getRow(id);
  });
});

$('#edit').on('shown.bs.modal', function() {
    const diasTrabajados = parseInt(document.getElementById('dias_trabajados').value);
    const diasFaltados = parseInt(document.getElementById('dias_faltados').value);
    const diasTardados = parseInt(document.getElementById('dias_tardados').value);

    var myChart = Chart.getChart('myChart');
    if (myChart) {
      myChart.destroy();
    }

    const ctx = document.getElementById('myChart').getContext('2d');
    
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Faltas', 'Asistencias', 'Tardanzas'],
        datasets: [{
          label: 'Días',
          data: [diasFaltados, diasTrabajados, diasTardados],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
});

</script>
</body>
</html>
