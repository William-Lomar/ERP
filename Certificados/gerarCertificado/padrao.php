<?php 
include('../../config.php');
$_POST = Painel::numeroPHP($_POST);
?>
<!DOCTYPE html>  
<html>
<head>
  <title>Certificado</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH?>Certificados/gerarCertificado/certificados.css?hash=<?php echo fileatime('certificados.css') ?>">
</head>
<body>
<div class="header">
    <div>
      <img src="logo.PNG">
    </div> 
    <div>
      <p>Rua Anabyr Lopes França, 111</p>
      <p>Santa Lúcia, Vitória, ES, Brasil</p>
      <p>CEP: 29.056-195</p>
    </div> 
    <div>
      <img src="SGQT.PNG">
    </div>
</div> 
<section class="certificado">
  <div class="titulo">
    <h1>CERTIFICADO DE CALIBRAÇÃO</h1>
  </div>
  <div class="dadosGerais">
    <table>
      <tr>
        <td colspan="2">Informações Basicas</td>
      </tr>
      <tr>
        <td>Equipamento</td>
        <td><?php echo $_POST['eqp']?></td>
      </tr>
      <tr>
        <td>Número de Série</td>
        <td><?php echo $_POST['ns']?></td>
      </tr>
      <tr>
        <td>Data Calibração</td>
        <td><?php echo $_POST['data']?></td>
      </tr>
      <tr>
        <td>Ordem de Serviço</td>
        <td><?php echo $_POST['os']?></td>
      </tr>
      <tr>
        <td>Cliente</td>
        <td><?php echo $_POST['cliente']?></td>
      </tr>
      <tr>
        <td>Responsável</td>
        <td><?php echo $_POST['responsavel']?></td>
      </tr>
      <tr>
        <td>Número do Certificado</td>
        <td><?php echo $_POST['numeroCertificado']?></td>
      </tr>
    </table>
  </div>
  <div class="procedimentos">
   <?php include('../procedimentos/'.$_GET['eqp'].'.php') ?>
  </div>
  <div class="padroes">
    <h2>2. Equipamentos e materiais utilizados.</h2>
    <table>
      <tr>
        <td>Equipamento / Modelo</td>
        <td>Número de Série</td>
        <td>Data Calibração</td>
        <td>Certificado</td>
      </tr>
      
      <?php 
        foreach ($_POST['padrao'] as $key => $value) {
          $padrao = Banco::selecionarID('tb_padroes',$value);
          ?>
      <tr>
        <td><?php echo $padrao['nome'] ?></td>
        <td><?php echo $padrao['NS'] ?></td>
        <td><?php echo $padrao['dataCertificado'] ?></td>
        <td><?php echo $padrao['certificado'] ?></td>
      </tr>
          <?php
        }
      ?>
      <?php 
      if ($_GET['eqp'] == 'radiacao') {
        ?>
      <tr>
        <td colspan="4">Obs: Sensor de Calibração Padrão possui validade de  2 anos.</td>
      </tr>
        <?php
      }
       ?>
    </table>
  </div>

  <?php include('../dadosCertificado/'.$_GET['eqp'].'.php') ?>

 
  <div class="final">
    <h2>4. Diagnóstico Final.</h2>
    <p>O Equipamento encontra-se operando dentro das especificações do fabricante e sem quaisquer restrições.</p>
  </div>
</section>
  <footer>
    <p>Garantia de Qualidade</p>
    <p>Assistência Técnica</p>
  </footer>
</body>
</html>




