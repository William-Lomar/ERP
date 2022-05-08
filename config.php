<?php
  require_once "QRCode/vendor/autoload.php";

  //setar timezone
  date_default_timezone_set('America/Sao_Paulo');
  
  session_start();
  
  //incluir classes dinamicamente
  $autoload = function($class){
    include('class/'.$class.'.php');
  };

  spl_autoload_register($autoload);

  define('INCLUDE_PATH', "http://seu_caminho/ERP/");
  define('BASE_DIR',__DIR__);

  //Conectar com banco de dados
  define('HOST',"seu_host");
  define("USER", "seu_usuario");
  define("PASS", "sua_senha");
  define("DB", "sua_database");

 //Funções
  function selecionadoMenu($par){
    $url = explode('/', @$_GET['url'])[0];
    if ($url == $par) {
      # code...
      echo 'ativado';
    }
  }

  function selecionadoMenuEmpresa($par){
    $empresa = isset($_GET['empresa']) ? $_GET['empresa'] : 'geral';
    if ($empresa == $par) {
      # code...
      echo ' class="menu-active" ';
    }
  } 

  function selecionadoMenuLocal($par){
    $local = isset($_GET['local']) ? $_GET['local'] : 'total';
    if ($local == $par) {
      # code...
      echo ' class="menu-active" ';
    }
  }

  function selectSelecionado($par1,$par2){
    if ($par1 == $par2){
      echo 'selected';
    } 
  }

  function selectSelecionadoEqp($arr,$par2){
    $eqps = explode('/', $arr);
    $return = '';
    foreach ($eqps as $key => $value) {
      if ($value == $par2) {
        $return = 'selected';
        break;
      }
    }
    echo $return;
  }

  function verificaPermissaoMenu($permissao){
    if ($_SESSION['cargo'] >= $permissao) {
      return;
    }else{
      echo ' style=display:none; ';
    }
  }

  function verificaPermissaoPagina($permissao){
    if ($_SESSION['cargo'] >= $permissao) {
      return;
    }else{
      include("pg/permissaonegada.php");
      die();
    }
  }
?>
