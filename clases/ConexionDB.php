<?php

class ConexionDB
{
    public static function conexion()
    {
        
        $dsn = 'mysql:host=localhost;dbname=usuarios;port=8889;charset=utf8';
        $username = 'root';
        $password = 'root';
        
        try {
            $db = new PDO($dsn, $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return $db;
        }
        catch( PDOException $Exception ) {
            echo $Exception->getMessage();
        }
    }
}