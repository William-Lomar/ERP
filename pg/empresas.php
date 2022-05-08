<?php
  if (isset($_GET['excluir'])) {
    # code...
    $idExcluir = $_GET['excluir'];

    if (Painel::deletar("tb_empresas",$idExcluir)) {
      # code...
      Painel::alerta('Empresa excluida com sucesso');
      Painel::redirecionar(INCLUDE_PATH.'empresas');
    }else{
      Painel::alerta('Erro ao excluir empresa');
      Painel::redirecionar(INCLUDE_PATH.'empresas');
    }

  }
?>
<div class="container">
  <div class="row">
    <div class="col-md-5">
      <div class="dados empresas">
        <form method="post">
          <div>
            <h1>Cadastrar</h1>
            <input type="text" name="empresa">
          </div>
          <div>
            <input type="submit" name="enviar" value="CADASTRAR">
          </div>
          <div class="clear"></div>
        </form>

        <?php
        if (isset($_POST['enviar'])) {
          # code...
          if(Painel::insert($_POST,'tb_empresas')){
            Painel::alerta('Empresa cadastrada com sucesso');
          }
        }
        ?>
      </div>
    </div>
    <div class="col-md-7">
      <div class="dados">
        <h1>Empresas</h1>
        <div class="center" style="margin-top: 40px;">
        <?php
          $dados = Painel::selectAll('tb_empresas');
          foreach ($dados as $key => $value) {
            # code...
            ?>
              <h2 class="excluir"><?php echo $value['empresa']?><a <?php verificaPermissaoMenu(2)?> style="color: black" href="http://localhost/Atividades/Clientes/Controle_ATE/empresas?excluir=<?php echo $value['id']?>"><i class="fa fa-eraser" aria-hidden="true"></i></a></h2>
            <?php
          }
      ?>
      </div>
    </div>
  </div>
</div>









