<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome.php");
  exit;
}
 

require_once "config.php";
 
$username = $password = "";
$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["mail"]))){
        $username_err = "ingresa el correo.";
    } else{
        $username = trim($_POST["r_mail"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Ingresa la contraseña";
    } else{
        $password = trim($_POST["r_password"]);
    }
    

    if(empty($username_err) && empty($password_err)){

        $sql = "SELECT id, mail, password FROM user WHERE mail = '$username'";
        
        if($stmt = mysqli_prepare($link, $sql)){
            $param_username = $username;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                // revisa si el el correo existe
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["mail"] = $username;                            
                            header("location: welcome.php");
                        } else{                            
                            $password_err = "La contraseña no es la correcta.";
                        }
                    }
                } else{
                    $username_err = "Usuario no registrado.";
                }
            } else{
                echo "Erro: algo salio mal, intentalo de nuevo.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ingresa al sistema</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="estilo.css">
    
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <div class="fadeIn first">
                <img src="avatardefault_92824.png" id="icon" alt="Bienvenido" />
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Correo</label>
                <br>
                <input type="email" name="r_mail" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <br>
                <input type="password" name="r_password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>crear una cuenta<a class="underlineHover" href="register.php"></a>.</p>
        </form>
        </div>        
    </div>    
</body>
</html>