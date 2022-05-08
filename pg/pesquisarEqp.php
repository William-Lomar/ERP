<div class="dados">
    <h1 style="margin-bottom: 20px">Pesquisar Equipamento</h1>
    <form method="post">
      <div class="form-row">
        <div class="col">
          <input name="pesquisa" type="text" class="form-control" placeholder="Digite aqui sua pesquisa">
        </div>
      </div>
    <div class="enviar right">
      <input type="submit" name="acao" value="Pesquisar">
    </div>
    <div class="clear"></div>
  </form>
</div>

<div class="tabela">
  <table>
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
      <td>Ações</td>
    </tr>
  

  <?php
 if (isset($_POST['acao'])) {
      $busca = $_POST['pesquisa'];
      $dados = Painel::pesquisa($busca,'tb_estoque');
      
      foreach ($dados as $key => $value) {
    ?>
      <tr>
        <td><?php echo $value['nome']?></td>
        <td><?php echo $value['NS']?></td>
        <td><?php echo $value['tipoEqp']?></td>
        <td><?php echo $value['dataEntrada']?></td>
        <td><?php echo $value['dataNF']?></td>
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
  }?>
   </table>
</div>




