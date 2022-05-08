<?php
  if (isset($_GET['coletar'])) {
    $idColetar = $_GET['coletar'];
    if (Painel::deletar('tb_estoque',$idColetar)) {
        Painel::alerta('Equipamento coletado com sucesso');
        Painel::redirecionar(INCLUDE_PATH.'estoque');
      }else{
        Painel::alerta('Erro ao coletar equipamento');
        Painel::redirecionar(INCLUDE_PATH.'estoque');
      }  
  }

  if (isset($_GET['QRCode'])) {
    $_SESSION['QRCode'] = INCLUDE_PATH.'atualizarEqp?id='.$_GET['QRCode'];
    Painel::redirecionar(INCLUDE_PATH.'gerarQRCode');
  }

  $empresa = isset($_GET['empresa']) ? $_GET['empresa'] : 'geral';
  $local = isset($_GET['local']) ? $_GET['local'] : 'total';
?> 


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Estoque</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo ucfirst($empresa) ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?php echo INCLUDE_PATH ?>estoque?empresa=clientes">Clientes</a>
          <a class="dropdown-item" href="<?php echo INCLUDE_PATH ?>estoque?empresa=iema">IEMA</a>
          <a class="dropdown-item" href="<?php echo INCLUDE_PATH ?>estoque?empresa=empresa">Empresa</a>
          <a class="dropdown-item" href="<?php echo INCLUDE_PATH ?>estoque?empresa=geral">Geral</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo ucfirst($local) ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?php echo INCLUDE_PATH ?>estoque?empresa=<?php echo $empresa?>&local=bancada">Bancada</a>
          <a class="dropdown-item" href="<?php echo INCLUDE_PATH ?>estoque?empresa=<?php echo $empresa?>&local=almoxarifado">Almoxarifado</a>
          <a class="dropdown-item" href="<?php echo INCLUDE_PATH ?>estoque?empresa=<?php echo $empresa?>&local=total">Total</a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
            <a class="nav-link" href="<?php echo INCLUDE_PATH ?>addEqp">Adicionar Equipamento</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="<?php echo INCLUDE_PATH ?>pesquisarEqp">Pesquisar Equipamento</a>
        </li>
      </ul>
  </div>
</nav>

<div class="tabela">
  <form method="post">
    <table>
      <?php
      if ($local == 'bancada') {
        # code...
        ?>
        <tr>
          <td>Nome</td>
          <td>N/S</td>
          <td>Tipo de Equipamento</td>
          <td>Data Bancada</td>
          <td>Responsável</td>
          <td>Empresa</td>
          <td>OCS</td>
          <td>Observação</td>
          <td></td>
        </tr>
        <?php
      }else{
        ?>
        <tr>
          <td>Nome</td>
          <td>N/S</td>
          <td>Tipo de Equipamento</td>
          <td>Data de Entrada</td>
          <td>Data NF</td>
          <td>Local</td>
          <td>Situação</td>
          <td>Empresa</td>
          <td>OCS</td>
          <td>Observação</td>
          <td></td>
        </tr>
        <?php
      }
?>
  <?php
    $dados = Painel::selectFilter('tb_estoque',$local,$empresa);
    foreach ($dados as $key => $value) {
      # code...
      if ($local == 'bancada') {
        # code...
        ?>
        <tr>
          <td><?php echo $value['nome']?></td>
          <td><?php echo $value['NS']?></td>
          <td><?php echo $value['tipoEqp']?></td>
          <td><?php echo $value['dataBancada']?></td>
          <td><?php echo $value['responsavel']?></td>
          <td><?php echo $value['empresa']?></td>
          <td><?php echo $value['ocs']?></td>
          <td><?php echo $value['obs']?></td>
          <td><a href="<?php echo INCLUDE_PATH ?>atualizarEqp?id=<?php echo $value['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
          <a href="<?php echo INCLUDE_PATH?>estoque?QRCode=<?php echo $value['id']?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
          <a href="<?php echo INCLUDE_PATH?>estoque?coletar=<?php echo $value['id']?>"><i class="fa fa-check" aria-hidden="true"></i></a></td>
        </tr>
      <?php
      }else{
        ?>
        <tr>
          <td><?php echo $value['nome']?></td>
          <td><?php echo $value['NS']?></td>
          <td><?php echo $value['tipoEqp']?></td>
          <td <?php Painel::validaEntrada($value['dataEntrada'],$value['situacao'])?>><?php echo $value['dataEntrada']?></td>
          <td <?php Painel::validaNF($value['dataNF'])?>><?php echo $value['dataNF']?></td>
          <td><?php echo $value['local']?></td>
          <td><?php echo $value['situacao']?></td>
          <td><?php echo $value['empresa']?></td>
          <td><?php echo $value['ocs']?></td>
          <td><?php echo $value['obs']?></td>
          <td><a href="<?php echo INCLUDE_PATH ?>atualizarEqp?id=<?php echo $value['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
           <a href="<?php echo INCLUDE_PATH?>estoque?QRCode=<?php echo $value['id']?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
           <a href="<?php echo INCLUDE_PATH?>estoque?coletar=<?php echo $value['id']?>"><i class="fa fa-check" aria-hidden="true"></i></a>
          </td>
        </tr>
      <?php
      }
    }
  ?>
    </table>
  </form>
</div>



  
  

