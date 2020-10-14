<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido al sistema</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="estilo.css">

</head>
<body>
    <div class="page-header">
        <h1><b><?php echo htmlspecialchars($_SESSION["mail"]); ?></b>. Bienvenido de nuevo.</h1>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Cambiar la contraseña</a>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </p>
</body>
</html>