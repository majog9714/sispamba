<?php
$connect = mysqli_connect("localhost", "root", "", "toldopamba");
session_start();
if(isset($_SESSION["username"]))
{
     header("location:entry.php");
}
if(isset($_POST["register"]))
{
     if(empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["lastname"])||empty($_POST["name"]))
     {
          echo '<script>alert("Todos los campos son requeridos")</script>';
     }
     else
     {
          $username = mysqli_real_escape_string($connect, $_POST["username"]);
          $password = mysqli_real_escape_string($connect, $_POST["password"]);
          $lastname = mysqli_real_escape_string($connect, $_POST["lastname"]);
          $name     = mysqli_real_escape_string($connect, $_POST["name"]);
          $password = password_hash($password, PASSWORD_DEFAULT,[15]);
          $query = "INSERT INTO users(username, password, lastname, name) VALUES('$username', '$password', '$lastname', '$name')";
          if(mysqli_query($connect, $query))
          {
               echo '<script>alert("Registro completo, para ingresar al sistema dar click en Login")</script>';
          }
     }
}
if(isset($_POST["login"]))
{
     if(empty($_POST["username"]) || empty($_POST["password"]))
     {
          echo '<script>alert("Todos los campos son requeridos")</script>';
     }
     else
     {
          $username = mysqli_real_escape_string($connect, $_POST["username"]);
          $password = mysqli_real_escape_string($connect, $_POST["password"]);
          $query = "SELECT * FROM users WHERE username = '$username'";
          $result = mysqli_query($connect, $query);
          if(mysqli_num_rows($result) > 0)
          {
               while($row = mysqli_fetch_array($result))
               {
                    if(password_verify($password, $row["password"]))
                    {
                         //return true;
                         $_SESSION["username"] = $username;
                         $_SESSION["fullName"] = $row["name"]." ".$row["lastname"];

                         header("location:entry.php");
                    }
                    else
                    {
                         //return false;
                         echo '<script>alert("El usuario o Contrase??a no son correctos")</script>';
                    }
               }
          }
          else
          {
               echo '<script>alert("El usuario o Contrase??a no son correctos")</script>';
          }
     }
}
?>
<!DOCTYPE html>
<html>
     <head>
          <title>sispamba</title>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
          <link rel="stylesheet" href="estilos.css">
     </head>
     <body>
          <br /><br />
          <div class="container card-login" style="width:500px;">
               <img src="/img/toldopamba.png" width="60em" height="75em">
               <h3 align="center" class="texto-borde">Sispamba</h3>
               <h2 align="center">Carga y Consulta de Datos</h2>
               <br />
               <?php
               if(isset($_GET["action"]) == "login")
               {
               ?>
               <h4 align="center">Iniciar Sesi??n</h4>
               <br />
               <form method="post">
                    <label>Usuario</label>
                    <input type="text" name="username" class="form-control" />
                    <br />
                    <label>Contrase??a</label>
                    <input type="password" name="password" class="form-control" />
                    <br />
                    <input type="submit" name="login" value="Login" class="btn btn-light" />
                    <br />
                    <p align="center"><a href="sispambaindex.php">Registrarse</a></p>
               </form>
               <?php
               }
               else
               {
               ?>
               <h4 align="center">Registro</h4>
               <br />
               <form method="post">
                     <label>Nombre</label>
                     <input type="text" name="name" class="form-control" />
                     <br />
                     <label>Apellido</label>
                     <input type="text" name="lastname" class="form-control" />
                     <br />
                    <label>Usuario</label>
                    <input type="text" name="username" class="form-control" />
                    <br />
                    <label>Contrase??a</label>
                    <input type="password" name="password" class="form-control" />
                    <br />
                    <input type="submit" name="register" value="Registrarse" class="btn btn-light" />
                    <br />
                    <p align="center"><a href="sispambaindex.php?action=login">Login</a></p>
               </form>
               <?php
               }
               ?>
          </div>
     </body>
</html>
