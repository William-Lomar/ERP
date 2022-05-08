<?php
if (isset($_POST['enviar'])){
  if (Painel::insert($_POST,'tb_estoque')) {
  Painel::alerta($_POST['nome'].' cadastrado com sucesso');
  Painel::redirecionar(INCLUDE_PATH.'addEqp');
  }else{
    Painel::alerta('Erro ao cadastrar');
    Painel::redirecionar(INCLUDE_PATH.'addEqp');
  }
}
?>

<div class="dados">
  <form method="post">
    <h1>Adicionar Equipamento</h1>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div>
            <h2>Nome</h2> 
            <input type="text" name="nome" required>
          </div>
          <div>
            <h2>N/S</h2> 
            <input type="text" name="NS">
          </div>
          <div>
            <h2>Tipo de Equipamento</h2>
            <select class="select2" name="tipoEqp">
              <option value=""></option>
              <option value="BAM1020">BAM1020</option>
              <option value="Analisador">Analisador</option>
              <option value="Meteorológicos">Meteorológicos</option>
            </select>
          </div>
          <div>
            <h2>Data de Entrada</h2>
            <input formato='data' type="text" name="dataEntrada" placeholder="dd/mm/YYYY" required>
          </div>
          <div>
            <h2>Data da NF</h2>
            <input formato='data' type="text" name="dataNF" placeholder="dd/mm/YYYY">
          </div>
        </div>
        <div class="col-md-6">
          <div>
            <h2>Local</h2>
            <input type="text" name="local" required>
          </div>
          <div>
            <h2>Situação</h2>
            <select class="select2" name="situacao">
              
              <option value="Aguardando Avaliação">Ag Avaliação</option>
              <option value="Aguardando Manutenção">Ag Manutenção</option>
              <option value="Aguardando Aprovação">Ag Aprovação</option>
              <option value="Aguardando Coleta">Ag Coleta</option>
            </select>
          </div>
          <div>
            <h2>Empresa</h2>
            <select class="select2" name="empresa">
              <?php
               $empresas = Painel::selectAll('tb_empresas');
               foreach ($empresas as $key => $value) {
                 # code...?>
                  <option value="<?php echo $value['empresa'] ?>"><?php echo $value['empresa'] ?></option>
                 <?php
               }
              ?>
            </select>
          </div>
          <input type="hidden" name="responsavel" value="indeterminado">
          <div>
            <h2>OCS</h2>
            <input type="text" name="ocs">
          </div>
          <div>
            <h2>Observação</h2>
            <textarea name="obs"></textarea>
          </div>
          <input type="hidden" name="dataBancada" value="indeterminado">
        </div>
      </div>
    </div>
    <div class="enviar right">
      <input type="submit" name="enviar" value="ENVIAR">
    </div>
    <div class="clear"></div>
  </form>
</div><!--dados-->

