<?php
  if (isset($_COOKIE['lembrar'])) {
    $user = $_COOKIE['user'];
    $password = $_COOKIE['password'];
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ?");
    $sql->execute(array($user,$password));
    if ($sql->rowCount() == 1){
          $_SESSION['login'] = true;
          $_SESSION['usuario'] = $user;
          $_SESSION['senha'] = $password;
          $cargo = $sql->fetch();
          $cargo = $cargo['cargo'];
          $_SESSION['cargo'] = $cargo;
          header('Location: '.INCLUDE_PATH);
          die();
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Controle ATE</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH ?>css/login.css?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--link do icone cabeçalho -->
  <link rel="shortcut icon" type="text/css" href="">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH?>css/bootstrap.min.css">
<style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
</style>
</head>
<body>
    
<form class="form-signin" method="post">
  <div class="text-center mb-4">
    <h1 class="h3 mb-3 font-weight-normal">Controle ATE</h1>
    <p>Acesse sua conta</p>
  </div>

  <div class="form-label-group">
    <input type="text" name="usuario" id="inputEmail" class="form-control" placeholder="Usuario" required autofocus>
    <label for="inputEmail">Usuário</label>
  </div>

  <div class="form-label-group">
    <input type="password" name="senha" id="inputPassword" class="form-control" placeholder="Senha" required>
    <label for="inputPassword">Senha</label>
  </div>

  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me" name="lembrar"> Lembrar senha
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="enviar">Enviar</button>
  <p class="mt-5 mb-3 text-muted text-center">&copy;DoubleSix - 2020</p>
</form>
<?php
  
if (isset($_POST['enviar'])) {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ?");
    $sql->execute(array($usuario,$senha));

  if ($sql->rowCount() == 1){
    //Logamos com sucesso
    $_SESSION['login'] = true;
    $_SESSION['usuario'] = $usuario;
    $_SESSION['senha'] = $senha;
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ?");
    $sql->execute(array($usuario));
    $cargo = $sql->fetchAll();
    $cargo = $cargo[0]['cargo'];
    $_SESSION['cargo'] = $cargo;
    if (isset($_POST['lembrar'])) {
      # code...
      setcookie('lembrar',true,time()+(60*60*24*10),'/');
      setcookie('user',$usuario,time()+(60*60*24*10),'/');
      setcookie('password',$senha,time()+(60*60*24*10),'/');
    }
    header('Location: '.INCLUDE_PATH);
    die();

  }else{
    //Falhou
    ?>
        <script type="text/javascript">
          alert('Usuario ou senha incorretos');
        </script>
  <?php
  }
}
?>
  <script src="<?php echo INCLUDE_PATH?>js/bootstrap.min.js"></script> 
</body>
</html>
