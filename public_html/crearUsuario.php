<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Crear Usuario</title>
    </head>
    <body>

        <script>

            function camposVacios(){
                var email=document.getElementById('email');
                var contrasenia=document.getElementById('contrasenia');
                var contraseniaRep=document.getElementById('repetirConstrasenia');
                var nombre=document.getElementById('nombre');
                if(email==""||contrasenia==""||contraseniaRep==""||nombre==""){
                    alert("Existe algún campo vacío");
                    return false;
                }else{
                    if(contrasenia!=contraseniaRep){
                        alert("Las contraseñas no existen");
                        return false;
                    }
                    return true;
                }
            }

        </script>



        <section>
            <form action="./ficheros_php/index.php" method="post">
                <label>Email: <input type="email" placeholder="ejemplo@ejemplo.com" name="email"></label>
                <p></p>
                <label>Contraseña: <input type="password" name="contrasenia"></label>
                <p></p>
                <label>Repita Contraseña: <input type="password"  name="repetirContrasenia"></label>
                <p></p>
                <label>Nombre: <input type="text" name="nombre"></label>
                <p></p>
                <button type="submit" name="aniadir" onclick="return camporVacios()" value="Aniadir">Añadir</button>
                <button onclick="<?php  header('Location: https://wwwdes.ismael.lonuncavisto.org/index.php');exit;?>">Volver</button>
            </form>

        </section>

    </body>
</html>
