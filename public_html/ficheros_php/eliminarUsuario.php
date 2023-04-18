<?php



    $email=$_POST['email'];

    //Establece conexión con la BD
    require("conexion.php");
    $conexion= new UsoBD();
    $conexion->establecerConexion();

           
    $conexion->eliminarUsuario($email);
    

?>


