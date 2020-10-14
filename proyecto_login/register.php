<?php

require_once "config.php";
 

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["r_mail"]))){
        $username_err = "ingresa el mail.";
    } else{
        $g_mail=$_POST["r_mail"];
        $sql = "SELECT id FROM user WHERE mail = '$g_mail'";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            
            // Set parameters
            $param_username = trim($_POST["r_mail"]);
            
           
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "ya existe ";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Algo salio mal, intentalo más tarde";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
    
    
    if(empty(trim($_POST["r_password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["r_password"])) < 4){
        $password_err = "tu contraseña debe tener mas de 4 caracteres";
    } else{
        $password = trim($_POST["r_password"]);
    }
    
  
    if(empty(trim($_POST["r_confirm_password"]))){
        $confirm_password_err = "Por favor ingresa una contraseña.";     
    } else{
        $confirm_password = trim($_POST["r_confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "La contraseña no coincide.";
        }
    }
    
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
      
        $sql = "INSERT INTO user (mail, password) VALUES ('$username','$password')";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            
            if(mysqli_stmt_execute($stmt)){
                
                header("location: login.php");
            } else{
                echo "Algo salio mal.";
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
    <title>Registrarse</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="estilo.css"></head>
<body>
    <div class="wrapper fadeInDown">
        <h2>Crear sesion</h2>
   
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>mail</label>
                <input type="text" name="r_mail" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="password" name="r_password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirmar Contraseña</label>
                <input type="password" name="r_confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            </div>
            <a href="login.php">Iniciar sesión</a>
            </div>
        </form>
    </div>    
</body>
</html>