<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

 
require 'header.php';
require_once "../modelos/Consultas.php";


if ($_SESSION['escritorio']==1 && $_SESSION['acceso']==0) {
$user_id=$_SESSION["idusuario"];
  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();
  $rsptav = $consulta->cantidadalumnos($user_id);
  $regv=$rsptav->fetch_object();
  $totalestudiantes=$regv->total_alumnos;
  $cap_almacen=3000;

 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="panel-body">
<?php $rspta=$consulta->cantidadgrupos($user_id);
$rspta_profesor = $consulta->mostrarprofesor($user_id);

  if ($reg_profesor = $rspta_profesor->fetch_object()) {
      $nombre_profesor = $reg_profesor->nombre;
  } else {
      $nombre_profesor = "Nombre Desconocido";
}
?>
<h3 class="tituloprof"><b>Prof. <?php echo $nombre_profesor; ?></b></h3>
<h4 class="cursosdisponibles">Cursos Disponibles: </h4>

<?php
$colores = array("box box-success direct-chat direct-chat-success bg-green", "box box-rosa direct-chat direct-chat-success bg-rosa", "box box-lila direct-chat direct-chat-success bg-lila", "box box-primary direct-chat direct-chat-primary bg-aqua", "box box-warning direct-chat direct-chat-warning bg-yellow", "box box-danger direct-chat direct-chat-danger bg-red");
      while ($reg=$rspta->fetch_object()) {
        $idgrupo=$reg->idgrupo;
        $nombre_grupo=$reg->nombre;
        ?>

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 cursos">
          
          <!-- DIRECT CHAT SUCCESS -->
          <div class="<?php echo $colores[array_rand($colores)]; ?> collapsed-box cajacurso">
            <div class="box-header with-border">
              
              <h3 id="titulocurso" class="box-title"><?php echo $nombre_grupo; ?></h3>
              <p class="numest">Numero de Estudiantes:   
                <span data-toggle="tooltip" title="" class="badge" data-original-title="Cantidad de Estudiantes">
                  <?php 
                    $rsptag=$consulta->cantidadg($user_id,$idgrupo);
                    while ($regrupo=$rsptag->fetch_object()) {
                      echo $regrupo->total_alumnos;
                    }
                   ?>
                </span></p>
              
              <div class="box-tools pull-right">
                
              

                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">
                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">

                    <?php
                    $rsptas=$consulta->cantidadalumnos_porgrupo($user_id,$idgrupo);
                    while ($reg=$rsptas->fetch_object()) {
                      
                   if (empty($reg->image)){
                    echo ' <img class="img-circle" src="../files/articulos/anonymous.png" height="50px" width="50px">';

                  }else echo '<img class="img-circle" src="../files/articulos/'. $reg->image.'" height="50px" width="50px">';
                     } ?>
                  <!-- /.direct-chat-info -->
                  <!-- /.direct-chat-text -->
                </div>
              </div>
              <!--/.direct-chat-messages-->
              <!-- /.direct-chat-pane -->
            </div>
            
            <!-- /.box-body -->
            
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
          <div class="box-footer">
                <a href="vista_grupo.php?idgrupo=<?php echo $idgrupo; ?>" class="btn btn-default form-control" ><i class="fa fa-arrow-circle-right entrarcurso"></i></a>
              </div> 
        </div>


<?php } ?>


</div>

<!--fin centro-->
      </div>
      </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
<?php 
}
if($_SESSION['acceso']==1) {
   ?>
      <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
        <div class="row">  
          <div class="col-md-12">
        <div class="box">
  <div class="box-header with-border">
    <h1 class="box-title"><i class='fa fa-check-square-o'></i> Panel de Control:<b> ADMINISTRADOR </b></h1>
     
  
  
  
  
    
  </div>
  <!--box-header-->
  <!--centro-->
  <div class="panel-body table-responsive2" id="listadoregistros">
    <a  id="btnUsuarios" href="usuario.php" class="btn btn-rosa btncajas-admi"><i class='fa fa-user-plus'></i> Usuarios</a>
    <a id="btnGrupos" href="grupos.php" class="btn btn-lila btncajas-admi"><i class='fa fa-users'></i> Grupos</a>
    <a id="btnEstads" href="Rendimiento.php" class="btn btn-rojo btncajas-admi"><i class='fa  fa-bar-chart'></i>Estadisticas</a>
  
  </div>
  <!--fin centro-->
        </div>
        </div>
        </div>
        <!-- /.box -->
  
      </section>
      <!-- /.content -->
    </div>
  <?php 
}else{
//  require 'noacceso.php'; 
}

require 'footer.php';
 ?>

 <?php 
}

ob_end_flush();
  ?>

