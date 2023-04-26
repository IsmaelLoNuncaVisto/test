
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <script>

        function camposVacios(){
            var inputs = document.getElementById("inputuserName");
            for (var i=0; i<inputs.length; i++) {
                if(inputs[i]=""){
                    inputs[i].style.background="red";
                }
                
            }
        }
    </script>
    <form action="" method="$_POST">
        <ul>
            <li>
                <label for="userName">User Name:</label>
                <input type="text" name="userName" id="inputuserName">
            </li>
            <li>
                <label for="email">Email:</label>
                <input type="email" placeholder="ejemplo@prueba.com" name="email" id="inputname">
            </li>
            <li>
                <label for="password">Password:</label>
                <input type="password" name="password" id="inputpassword">
            </li>
            <li>
                <label for="passwordConfirm">Confirm Password:</label>
                <input type="password" name="passwordConfirm" id="inputpasswordConfirm">
            </li>
            <li>
                <label for="name">Name:</label>
                <input type="text" name="name" id="inputnomber">
            </li>
            <li>
                <label for="age">Age:</label>
                <input type="number" min="0" max="99" name="age" id="inputage">
            </li>
            <li>
                <label for="telephoneNumber">Telephone:</label>
                <input type="text" name="telephoneNumber" id="inputtelephoneNumber">
            </li>
            <li>
                <button type="submit" name="create" onclick="camposVacios()">Create Account</button>
                <button type="submit" name="return">Return</button>
            </li>
        </ul>
    </form>
</body>
</html>
