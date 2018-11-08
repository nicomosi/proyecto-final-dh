<?php 
abstract class DataBase
{
    abstract public function traerUsuario($email);   
    abstract public function usuarioLogin($email);
    abstract public function guardarUsuario($usuario);
    abstract public function searchPassword($password, $email);
    abstract public function modificarBD($email);

    public function guardarFoto($fotoPerfil)
    {

    $nombre = $fotoPerfil["name"];

    $archivo = $fotoPerfil["tmp_name"];

    $ext = pathinfo($nombre, PATHINFO_EXTENSION);

    $nombreFinal = uniqid() . "." . $ext;

    $miArchivo = realpath(dirname(__FILE__) . '/..');
    $miArchivo = $miArchivo . "/img/";
    $miArchivo = $miArchivo . $nombreFinal;


    move_uploaded_file($archivo, $miArchivo);

    return $nombreFinal;
    }
    
    public function validarFoto ($foto)
    {
        if ($foto["error"] !== UPLOAD_ERR_OK) {
            return false; 
        }
        return true;
    }

    public function validarFotoPerfil($usuario)
    {
        $filesErrores = [];

        if (!$this->validarFoto($_FILES['subirFotoPerfil'])) {
            $filesErrores['fotoPerfil'] = 'Hubo un error al subir la foto.';
        }
        return $filesErrores;
    }

}
?>