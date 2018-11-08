<?php 
class Json extends DataBase 
{
    
    public $archivo;
    
    public function __construct($archivo){
        $this->archivo=$archivo;
    }
    public function traerUsuario($email){
        $usuarios = $this->traerUsuarios();

        foreach ($usuarios->usuarios as $usuario) {
            $emailJson = $usuario->email;
            

            if ( $emailJson == $email) {
                return $email;
            } 
        }
        return NULL;
    
    }

    public function usuarioLogin($email){
        $usuarios = $this->traerUsuarios();

        foreach ($usuarios->usuarios as $usuario) {
            $emailJson = $usuario->email;
            

            if ( $emailJson == $email) {
                
                return new Usuario($usuario->nombre, $usuario->apellido, $usuario->email, $usuario->password, $usuario->fotoPerfil);    
            } 
        }
    
    }
    

    public function guardarUsuario($usuario){

      
        $user = [
            "nombre" => $usuario->getNombre(),
            "apellido" => $usuario->getApellido(),
            "email" => $usuario->getEmail(),
            "password" => $usuario->getContrasenia(),
            "fotoPerfil" => $usuario->getFotoPerfil()
        ];

        $usuarios = $this->traerUsuarios(); 
        $usuarios->usuarios[]=$user;
        $json = json_encode($usuarios);
        file_put_contents($this->archivo, $json);
    }
    
    public function traerUsuarios()
    {
        $archivo = file_get_contents($this->archivo);
        $arrayUsuarios = json_decode($archivo); //devuelve un string de json
        
        return $arrayUsuarios;
    }

   
    public function searchImg($email){


        $usuarios = $this->traerUsuarios();

        foreach ($usuarios->usuarios  as $usuario) {
            $emailJson = $usuario->email;
            if ($emailJson == $email) {
                return $usuario->fotoPerfil;
                         break;
            }
        }
    }
    public function searchPassword($password, $email){

        $usuarios = $this->traerUsuarios();

        foreach ($usuarios->usuarios as $usuario) {
            $emailJson = $usuario->email;
            

            if ( $emailJson == $email) {
                if (password_verify($password, $usuario->password)) {  //devuelve true si la verificacion lo es
                    return true;
                    break;
                } else {
                    return false;
                    break;
                }
            } 
        }

        
    }
    
                      
            public function modificarBD($email){  
                $usuarios = $this->traerUsuarios();
                
                foreach ($usuarios->usuarios as $usuario) {
                    $emailJson = $usuario->email;
                    if ($emailJson == $email) {
                        foreach ($_POST as $key => $value) {
                            if ($key == 'password' && $value != $usuario->password) {
                                $usuario->password = password_hash($value, PASSWORD_DEFAULT);
                            } elseif ($key != 'submit')  {
                                $usuario->$key = $value;
                            }                            
                        }
                        
                        break;
                    }
                }
            
                $json = json_encode($usuarios);
                file_put_contents($this->archivo, $json);
                $usuarioActualizado = new Usuario($usuario->nombre, $usuario->apellido, $usuario->email, $usuario->password);
                

                return $usuarioActualizado;
                
            }
            
            public function eliminarBD($email){  
                $usuariosJson = $this->traerUsuarios(); 
                $user = [];
                $position = 0;
                foreach ($usuariosJson->usuarios as $usuario) {
                    $emailJson = $usuario->email;
                    if ($emailJson !== $email) {
                        $user = [
                            "nombre" => $usuario->nombre,
                            "apellido" => $usuario->apellido,
                            "email" => $usuario->email,
                            "password" => $usuario->password,
                            "fotoPerfil" => $usuario->fotoPerfil
                        ];
                        $usuarios->usuarios[]=$user;
                    }  
                    
                    
                    } 
                    
                $json = json_encode($usuarios);
                file_put_contents($this->archivo, $json);
                
            }

            public function modificarFotoUsuario($email){

                $usuarios = $this->traerUsuarios();
                
                foreach ($usuarios->usuarios as $usuario) {
                    $emailJson = $usuario->email;
                    if ($emailJson == $email) {
                        $nuevaFoto = "img/".$this->guardarFoto($_FILES["subirFotoPerfil"]);
                                $usuario->fotoPerfil= $nuevaFoto;
                    }
                }
                $json = json_encode($usuarios);
                file_put_contents($this->archivo, $json);
                
                
            }
        }
            ?>