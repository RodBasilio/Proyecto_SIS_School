<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['grupos']==1) {

   /* if(isset($_GET['idgrupo'])) {
      $_SESSION['idgrupo'] = $_GET['idgrupo'];
    };*/
        $idgrupo=$_GET['idgrupo'];

  require_once "../modelos/Grupos.php";
  $grupos = new Grupos();
  $rspta = $grupos->mostrar_grupo($idgrupo); 
  $reg=$rspta->fetch_object();
  $nombre_grupo=$reg->nombre;


 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">  
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title"><i class='fa fa-check-square-o'></i> Panel de Control: <?php echo $nombre_grupo; ?>   </h1>
   




  <div class="box-tools pull-right">
    <a id="btngrupos" href="escritorio.php"><button class="btn btn-info"><i class='fa fa-dashboard'></i> Escritorio</button></a>
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive2" id="listadoregistros">
  <a  id="btnlistas" href="listasis.php?idgrupo=<?php echo $idgrupo; ?>" class="btn btn-aqua btncajas"><i class='fa fa-list-alt'></i> Listas</a>
  <a id="btncalificaciones" href="calificaciones.php?idgrupo=<?php echo $idgrupo; ?>" class="btn btn-rojo btncajas"><i class='fa fa-tasks'></i> Calificaciones</a>
  <a id="btnasistencia" href="asistencia.php?idgrupo=<?php echo $idgrupo; ?>" class="btn btn-celeste btncajas"><i class='fa fa-edit'></i> Asistencia</a>
  <a  id="btnconducta" href="conducta.php?idgrupo=<?php echo $idgrupo; ?>" class="btn btn-rosa btncajas"><i class='fa fa-smile-o'></i> Conducta</a>
  <a id="btncursos" href="cursos.php?idgrupo=<?php echo $idgrupo; ?>" class="btn btn-verde btncajas"><i class='fa fa-th'></i> Cursos</a>
  <a id="btninfoalumnos" href="vista_info_alum.php?idgrupo=<?php echo $idgrupo; ?>" class="btn btn-morado btncajas"><i class='fa fa-info-circle'></i> Info Alumnos</a>

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
 require 'noacceso.php'; 
}
require 'footer.php'
 ?>
 <script src="scripts/vista_grupo.js"></script>

 <?php 
}

ob_end_flush();
  ?>