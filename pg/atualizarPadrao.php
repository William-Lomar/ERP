<?php
  if (isset($_GET['idPadrao'])) {
    # code...
    $id = $_GET['idPadrao'];
    $dados = Painel::selecionarID('tb_padroes',$id);

  }else{
    echo "Sem dados para atualizar";
  }
?>


<div class="dados">
  <form method="post">
    <h1>Atualizar Padrão</h1>
    <div class="container">
    <div class="row">
      <div class="col-md-6 first">
        <div>
          <h2>Nome</h2>
          <input value="<?php echo $dados[0]['nome'] ?>" type="text" name="nome">
        </div>
        <div>
          <h2>N/S</h2>
          <input value="<?php echo $dados[0]['NS'] ?>" type="text" name="NS">
        </div>
      </div>
      <div class="col-md-6">
        <div>
          <h2>Certificado:</h2>
          <input value="<?php echo $dados[0]['certificado'] ?>" type="text" name="certificado">        </div>
        <div>
          <h2>Data da Calibração</h2>
          <input value="<?php echo $dados[0]['dataCertificado'] ?>" formato='data' type="text" name="dataCertificado" placeholder="dd/mm/YYYY">
        </div>
      </div>
    </div>
  </div>
    <div class="enviar right">
      <input type="submit" name="acao" value="Atualizar">
    </div>
    <div class="clear"></div>
  </form>
</div>


<!--

<div class="addEqp">
  <h1>Atualizar Padrão:</h1>
  <form method="post">
    <div>
      <h2>Nome/Modelo:</h2>
      <input value="<?php echo $dados[0]['nome'] ?>" type="text" name="nome">
    </div>
    <div>
      <h2>N/S:</h2>
      <input value="<?php echo $dados[0]['NS'] ?>" type="text" name="NS">
    </div>
    <div>
      <h2>Certificado:</h2>
    </div>
    <div>
      <h2>Data da Calibração</h2>
      <input value="<?php echo $dados[0]['dataCertificado'] ?>" formato='data' type="text" name="dataCertificado" placeholder="dd/mm/YYYY">
    </div>
    <div>
      <input type="submit" name="acao" value="Atualizar">
    </div>
  </form>-->

<?php
if (isset($_POST['acao'])) {
# code...

$dadosRetorno = [
    'nome_tabela'=>'tb_padroes',
    'id'=>$id,
    'nome'=>$_POST['nome'],
    'NS'=>$_POST['NS'],
    'certificado'=>$_POST['certificado'],
    'dataCertificado'=>$_POST['dataCertificado'],
  ] ;
 
if (Painel::update($dadosRetorno)) {
  # code...
  ?>
    <script type="text/javascript">
      alert('Padrão atualizado com sucesso');
    </script>
  <?php
  Painel::redirecionar(INCLUDE_PATH.'padroes');
}else{
  ?>
    <script type="text/javascript">
      alert('Erro ao atualizar padrão');
    </script>
  <?php
}
}
?>

