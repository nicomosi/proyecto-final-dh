<?php 
require_once('helpers.php'); 
require_once('_head.php'); 
?>
<?php

//si no hay sesion iniciada, e intentar acceder al perfil, este redirecciona al login
if (!$session->status()) { 
  redirect('login.php');
}
if ($_FILES){
  $filesErrores = $db->validarFotoPerfil($_SESSION['usuario']);
  $db->modificarFotoUsuario(user()->getEmail());
  
}
//si se presiona eliminar, elimina de la bd y redirecciona al home.
//tomar en cuenta a futuro una advertencia y/o confirmacion de eliminacion del usuario
// if ($_POST['delete']) {
//   $db->eliminarBD(user()->getEmail());
//   session_destroy();
//   redirect('index.php');

// }
if (($_POST['submit'])) {
   $errores=Validation::validarErrores();
  $usuarioBD=$db->traerUsuario($_POST['email']);
  $usuarioActual = user()->getEmail();
  if (count($errores) == 1 ) {  //count va hacer siempre uno por el $errores['emptyTyc'], indicaria que solo ese error contiene.
    if ($usuarioBD == $usuarioActual || $usuarioBD== null) { 
      // var_dump($
      $usuarioActualizado = $db->modificarBD(user()->getEmail());
      session_destroy();
      session_start();  
      $_SESSION['usuario'] = $usuarioActualizado;
      
     }else {
       $errores['usuarioExiste']='Este email ya pertenece a una cuenta registrada!';
    }
  }

 
}
$usuario = user()->getFotoPerfil();

 $usuario = $db->searchImg(user()->getEmail());
?>
<title>Perfil | Objective Food</title>
  </head>
<?php
//convoca al header
require_once('_header.php');
?>
<body>

    <section class="profile-content">
    <!-- edicion y visualizacion de la foto de perfil -->
      <article class="foto-profile">
        <img src="<?= $usuario; ?>" alt="">
        <form class="file-form contact-form"action="" method="post" enctype="multipart/form-data">
          <label for="file">Foto de Perfil</label>
          <input type="file" name="subirFotoPerfil">
          <?= (isset($filesErrores)) ? $filesErrores['fotoPerfil'] : "" ?>
          <input type ="submit" name="submit" value="Subir foto">
      </form>
    </article>
    <!-- edicion y visualizacion de los datos del perfil -->
    <article class="data-profile">
        <h3>Hola <?= user()->getNombre();?></h3>
          <form class="contact-form" method="post">
            <label for="nombre">Nombre:</label>
            <input  class="form-input" name ="nombre" type="text" value="<?= user()->getNombre();?>">
            
            <label for="apellido">Apellido:</label>
            <input  class="form-input" name="apellido" type="text" value="<?= user()->getApellido();?>">

            <label for="email">Email:</label>
            <input  class="form-input" name="email" type="email" value="<?= user()->getEmail();?>">

            <?php if (isset($errores['invalidEmail'])):?>
              <span class="error-container"><i class="fas fa-exclamation-circle"></i>
              <?php echo $errores['invalidEmail']; ?></span>
                                                
            <?php elseif (isset($errores['usuarioExiste'])):?>
              <span class="error-container"><i class="fas fa-exclamation-circle"></i>
              <?php echo $errores['usuarioExiste']; ?></span>
            <?php endif ?>

            <label for="email">Contraseña:</label>
            <input  class="form-input" name="password" type="password" value="<?= user()->getContrasenia();?>">

            <?php if (isset($errores['passwordLength'])):?>
              <span class="error-container"><i class="fas fa-exclamation-circle"></i>
              <?php echo $errores['passwordLength']; ?></span>
            <?php elseif (isset($errores['passwordlower'])):?>
              <span class="error-container"><i class="fas fa-exclamation-circle"></i>
              <?php echo $errores['passwordlower']; ?></span>
            <?php endif ?>

            <input type ="submit" name="submit" value="Actualizar">
            <input type ="submit" name="delete" value="Eliminar usuario">

          </form>
        </article>

    </section>
</body>
<?php
require_once('_footer.php');