<?php
  if (isset($_GET['excluirPadrao'])) {
    # code...
    $idPadrao = $_GET['excluirPadrao'];
    Painel::deletar('tb_padroes',$idPadrao);
    Painel::redirecionar(INCLUDE_PATH.'padroes');
  }

  if (isset($_POST['enviar'])) {
    # code...
    if (Painel::insert($_POST,'tb_padroes')) {
      # code...
      Painel::alerta('Padrão Cadastrado com sucesso');
      Painel::redirecionar(INCLUDE_PATH.'padroes');
    }else{
      Painel::alerta('Erro ao cadastrar padrão');
      Painel::redirecionar(INCLUDE_PATH.'padroes');
    }
  }
?>
<div class="dados">
  <form method="post">
    <h1>Cadastrar Padrão</h1>
    <div class="container">
    <div class="row">
      <div class="col-md-6 first">
        <div>
          <h2>Nome</h2>
          <input type="text" name="nome">
        </div>
        <div>
          <h2>N/S</h2>
          <input type="text" name="NS">
        </div>
      </div>
      <div class="col-md-6">
        <div>
          <h2>Certificado:</h2>
          <input type="text" name="certificado">
        </div>
        <div>
          <h2>Data da Calibração</h2>
          <input formato='data' type="text" name="dataCertificado" placeholder="dd/mm/YYYY">
        </div>
      </div>
    </div>
  </div>
    <div class="enviar right">
      <input type="submit" name="enviar" value="ENVIAR">
    </div>
    <div class="clear"></div>
  </form>
</div>

  <div class="tabela">
    <h1>Padrões</h1>
    <form method="post">
      <table>
        <tr>
          <td>Nome</td>
          <td>N/S</td>
          <td>Certificado</td>
          <td>Data Calibração</td>
          <td></td>
        </tr>

         <?php
        $padroes = Painel::selectAll('tb_padroes');

        foreach ($padroes as $key => $value) {
          ?>
            <tr <?php Painel::validaPadrao($value['dataCertificado']); ?>>
              <td><?php echo $value['nome'] ?></td>
              <td><?php echo $value['NS'] ?></td>
              <td><?php echo $value['certificado'] ?></td>
              <td><?php echo $value['dataCertificado'] ?></td>
              <td>
                <a href="<?php echo INCLUDE_PATH ?>atualizarPadrao?idPadrao=<?php echo $value['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <a <?php verificaPermissaoMenu(2)?> href="<?php echo INCLUDE_PATH?>padroes?excluirPadrao=<?php echo $value['id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
              </td>
            </tr>
          <?php
        }
      ?>
      </table>
    </form>
  </div>



