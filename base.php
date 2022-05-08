<?php 
  if (!isset($_SESSION['login'])){
    header("Location:http://seu_caminho/ERP/");
  }

  $url = isset($_GET['url']) ? $_GET['url'] : 'servicos';

  $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ?");
  $sql->execute(array($_SESSION['usuario']));
  $dados = $sql->fetchAll();
  $img_atual = $dados[0]['img'];

  if ($img_atual == '') {
    $img_atual = 'noUser.png';
  } 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Controle ATE</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH?>css/style.css?hash=<?php echo filemtime(BASE_DIR.'/css/style.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH?>js/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH?>css/icones/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH?>css/bootstrap.min.css">
</head>
<body>

 <nav class="navbar navbar-expand-lg navbar-light bgEco">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item <?php selecionadoMenu("servicos") ?>">
          <a class="itemNav nav-link text-white" href="<?php echo INCLUDE_PATH ?>servicos">Serviços<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item <?php selecionadoMenu("estoque") ?>">
          <a class="itemNav nav-link text-white" href="<?php echo INCLUDE_PATH ?>estoque">Estoque<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item <?php selecionadoMenu("historico") ?>">
          <a class="itemNav nav-link text-white" href="<?php echo INCLUDE_PATH ?>historico">Histórico<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item <?php selecionadoMenu("certificado") ?>">
          <a class="itemNav nav-link text-white" href="<?php echo INCLUDE_PATH ?>certificado">Certificados<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item <?php selecionadoMenu("empresas") ?>">
          <a class="itemNav nav-link text-white" href="<?php echo INCLUDE_PATH ?>empresas">Empresas<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item <?php selecionadoMenu("padroes") ?>">
          <a class="itemNav nav-link text-white" href="<?php echo INCLUDE_PATH ?>padroes">Padrões<span class="sr-only">(current)</span></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
            <div class="menuOpcoes">
              <img src="img/<?php echo $img_atual ?>">
            </div>
        </li>
      </ul>
    </div>
  </nav>

  <div class="opcoes">
    <img src="img/<?php echo $img_atual ?>">
    <p><?php echo ucfirst($_SESSION['usuario'])?></p>
    <div style="text-align: left; margin-top: 50px;">
      <a class="block" href="<?php echo INCLUDE_PATH ?>editarusuario">Editar Usuário</a>
      <a class="block" <?php verificaPermissaoMenu(3)?> href="<?php echo INCLUDE_PATH ?>editarFuncionarios">Editar Funcionário</a>
      <a class="block" <?php verificaPermissaoMenu(3)?> href="<?php echo INCLUDE_PATH ?>adicionarFuncionarios">Adicionar Funcionário</a>
    </div>
    <form style="text-align: right" method="post">
      <input style="width: 50px" type="submit" name="sair" value="Sair">
    </form>
  </div>

  <?php 
    if (isset($_POST['sair'])) {
      # code... time()-1 -> serve para destruir cookie
      setcookie('lembrar','true',time()-1,'/');//'/'-> significa que é para pegar em todo o site
      session_destroy();
      header("Location: ".INCLUDE_PATH);
    } 
    
    if ($_SESSION['usuario'] == "Coordenador" || $_SESSION['usuario'] == "coordenador" && $url == "servicos"){
      $url = "coordenador_servicos";
    }

    if(file_exists('pg/'.$url.'.php')){
     include('pg/'.$url.'.php');
    }else{
      include('pg/servicos.php');
    }
   ?>

  <script type="text/javascript" src="<?php echo INCLUDE_PATH ?>js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo INCLUDE_PATH ?>js/jquery.mask.js"></script>
  <script src="<?php echo INCLUDE_PATH ?>js/dist/js/select2.min.js"></script>
  <script type="text/javascript" src="<?php echo INCLUDE_PATH?>js/jquery-ajaxform.js"></script>
  <script type="text/javascript" src="<?php echo INCLUDE_PATH ?>js/main.js?hash=<?php echo filemtime(BASE_DIR.'/js/main.js')?>"></script>
  <script src="<?php echo INCLUDE_PATH?>js/bootstrap.min.js"></script> 
</body>
</html>
