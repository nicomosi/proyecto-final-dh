<?php 
class Json extends DataBase 
{
    private $conexion; 
    
    public function __construct($conexion){
        $this->conexion=$conexion;
    }
    public function traerUsuario($email){
        
    }    

    public function usuarioLogin($email)
    {
    }

    public function guardarUsuario($usuario){
        
    }
    public function traerUsuarios()
    {

    }

    public function searchImg($email){
    }

    public function searchPassword($password, $email){
        
    }
    public function modificarBD($email)
    {
        
    }

    public function eliminarBD($email)
    {

    }

    public function modificarFotoUsuario($email)
    {
        
    }


    public function index($tabla)
    {
        $query = $this->conexion->prepare("SELECT * FROM {$tabla}"); 
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
       
        return $result;
    }

}
            ?>