<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

 
require 'header.php';



if ($_SESSION['acceso']==1) {
    ?>
      
       <div class="content-wrapper">
       <!-- Main content -->
        <section class="content">
   
         <!-- Default box -->
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                    <h1 style="text-align: center; font-size: 22px;">RENDIMIENTO ESCOLAR</h1>
                      <div class="row" >
                      <div class="col-lg-4">
       
        
    </div>
                      <select id="nombreBloque" class="form-control">
                <option disabled selected>Seleccionar Curso</option>
                  <option value="PRIMERO DE PRIMARIA">PRIMERO DE PRIMARIA</option>
                  <option value="SEGUNDO DE PRIMARIA">SEGUNDO DE PRIMARIA</option>
                  <option value="TERCERO DE PRIMARIA">TERCERO DE PRIMARIA</option>
                  <option value="CUARTO DE PRIMARIA">CUARTO DE PRIMARIA</option>
                  <option value="QUINTO DE PRIMARIA">QUINTO DE PRIMARIA</option>
                  <option value="SEXTO DE PRIMARIA">SEXTO DE PRIMARIA</option>
                  <option value="1RO DE SECUNDARIA A">1RO DE SECUNDARIA A</option>
                  <!-- Agrega más opciones según tus necesidades -->
                </select>

                <div class="row">
    <div class="col-lg-4">
        <button class="btn btn-primary" onclick="CargarDatosGrafico()">MOSTRAR</button>
        <canvas id="miGrafico" width="{}" height="{}"></canvas>
    </div>

    

  
</div>


                    <div class="box-tools pull-right">
                      
                </div>
             </div>
            
     <!--box-header-->
     <!--centro-->
     
     
   <?php 
}else{
    require 'noacceso.php'; 
   }
require 'footer.php';
 ?>

 <?php 
}

ob_end_flush();
  ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>


<script>
function CargarDatosGrafico(){
  CargarDatosGraficoBar();
  CargarDatosGraficoBar1();
  //CargarDatosGraficoBar3();
}
  function CargarDatosGraficoBar(){
    var nombreBloque = $("#nombreBloque").val();
    var nombreCurso = $("#nombreCurso").val();
    $.ajax({
        url: "../ajax/Controlador_graficoEs.php",
        type: "POST",
        data: { nombreBloque: nombreBloque , nombreCurso: nombreCurso} 
    }).done(function(resp)
    {
          // Verificar si la respuesta contiene etiquetas HTML o no
      if (resp.indexOf('<') === -1) {
          var data2 = JSON.parse(resp);
          // Resto del código para procesar los datos JSON
      } else {
          console.log("La respuesta no es un JSON válido.");
          // Aquí puedes manejar la respuesta no válida, mostrar un mensaje de error, etc.
      }

      var titulo =[];
      var cantidad = [];
      var materia=[] ;

      var data2 = JSON.parse(resp);
      console.log(resp);
      for(var i = 0; i < data2.length;i++){
        titulo.push(data2[i][0]);
        cantidad.push(data2[i][1]);
        
        
      }
       // Aquí almacenaremos los objetos combinados

       var aprobados = titulo;
            var reprobados = cantidad;


      var ctx = document.getElementById('miGrafico').getContext('2d');

          // Define tus datos y opciones de gráfico
          var data = {
                labels: ['Aprobados', 'Reprobados'],
                datasets: [
                    {
                        label: nombreBloque,
                        data: [aprobados, reprobados], // Aquí colocamos la cantidad de aprobados y reprobados
                        backgroundColor: ['green', 'red'],
                        borderWidth: 1
                    }
                ]
            };
          

          var options = {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          };
          function generarColorAleatorio() {
  const r = Math.floor(Math.random() * 256);
  const g = Math.floor(Math.random() * 256);
  const b = Math.floor(Math.random() * 256);
  return `rgba(${r}, ${g}, ${b}, 1)`;
}
          // Crea el gráfico de línea
          var miGrafico = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
          });

    })
  }




  function CargarDatosGraficoBar1(){
    var nombreBloque = $("#nombreBloque").val();

    $.ajax({
        url: "../ajax/Controlador_graficoEs.php",
        type: "POST",
        data: { nombreBloque: nombreBloque } 
    }).done(function(resp)
    {
          // Verificar si la respuesta contiene etiquetas HTML o no
      if (resp.indexOf('<') === -1) {
          var data2 = JSON.parse(resp);
          // Resto del código para procesar los datos JSON
      } else {
          console.log("La respuesta no es un JSON válido.");
          // Aquí puedes manejar la respuesta no válida, mostrar un mensaje de error, etc.
      }

      var titulo =[];
      var cantidad = [];
      var materia=[] ;

      var data2 = JSON.parse(resp);
      console.log(resp);
      for(var i = 0; i < data2.length;i++){
        titulo.push(data2[i][0]);
        cantidad.push(data2[i][1]);
        
      }
      
      var ctx = document.getElementById('miGrafico1').getContext('2d');

          // Define tus datos y opciones de gráfico
          var data = {
            labels: cantidad,
            datasets: [
              {
                label: nombreBloque,
                data: titulo,
                fill: false,
                borderColor: generarColorAleatorio(),
                borderWidth: 3,
                tension: 0  // Establece la tensión en 0 para líneas rectas
              }
            ]
          };

          var options = {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          };
          function generarColorAleatorio() {
  const r = Math.floor(Math.random() * 256);
  const g = Math.floor(Math.random() * 256);
  const b = Math.floor(Math.random() * 256);
  return `rgba(${r}, ${g}, ${b}, 1)`;
}
          // Crea el gráfico de línea
          var miGrafico = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
          });

    })
  }


  /*function CargarDatosGraficoBar3(){
    var nombreBloque = $("#nombreBloque").val();

    $.ajax({
        url: "../ajax/Controlador_graficoEs.php",
        type: "POST",
        data: { nombreBloque: nombreBloque } 
    }).done(function(resp)
    {
          // Verificar si la respuesta contiene etiquetas HTML o no
      if (resp.indexOf('<') === -1) {
          var data2 = JSON.parse(resp);
          // Resto del código para procesar los datos JSON
      } else {
          console.log("La respuesta no es un JSON válido.");
          // Aquí puedes manejar la respuesta no válida, mostrar un mensaje de error, etc.
      }

      var titulo =[];
      var cantidad = [];
      var materia=[] ;

      var data2 = JSON.parse(resp);
      console.log(resp);
      for(var i = 0; i < data2.length;i++){
        titulo.push(data2[i][0]);
        cantidad.push(data2[i][1]);
        
      }
      
      var ctx = document.getElementById('miGrafico3').getContext('2d');

          // Define tus datos y opciones de gráfico
          var data = {
            labels: cantidad,
            datasets: [
              {
                label: nombreBloque,
                data: titulo,
                fill: false,
                borderColor: generarColorAleatorio(),
                borderWidth: 3,
                tension: 0  // Establece la tensión en 0 para líneas rectas
              }
            ]
          };

          var options = {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          };
          function generarColorAleatorio() {
            const r = Math.floor(Math.random() * 256);
            const g = Math.floor(Math.random() * 256);
            const b = Math.floor(Math.random() * 256);
            return `rgba(${r}, ${g}, ${b}, 1)`;
          }
          // Crea el gráfico de línea
          var miGrafico = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
          });

    })
  }*/
  
  
</script>

<?php