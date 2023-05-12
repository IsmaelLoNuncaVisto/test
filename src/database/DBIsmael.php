<?php
namespace APP\database;



use PDO;

class DBIsmael
{

    private static $_db;


    public static function getConexion()
    {
        
        if(!self::$_db){
            
        $pdo=new PDO(
            'mysql:host=localhost;dbname=ismael;charsert=utf8',
            'ismael',
            'ismael'
        );

        
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        

        self::$_db = $pdo;
        }

        return self::$_db;
    }

    /*
    //Se crea la conexion xon la base de datos
    public function establecerConexion()
    {
        $db_host = "localhost";
        $db_nombre = "ismael";
        $db_user = "ismael";
        $db_contrasenia = "ismael";

        $this->conexion = mysqli_connect($db_host, $db_user, $db_contrasenia, $db_nombre);

        if (mysqli_connect_errno()) {
            echo "Fallo al conectar con al abase de datos";
            exit();

        }
        mysqli_select_db($this->conexion, $db_nombre) or die("No se encuentra la BBDD");
    }

    //Se cierra la conexión con la base de datos
    public function cerrarConexion()
    {
        mysqli_close($this->conexion);
    }
    */

}

?>
