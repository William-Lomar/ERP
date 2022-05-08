<?php
    if (isset($_GET['editar'])) {
    # code...
    $idEditar = $_GET['editar'];
  }else{
    echo "Erro, necessário id";
    die();
  }

  if (isset($_POST['Enviar'])) {
  # code...
  $nome = @$_SESSION['usuario'];
  $cliente = isset($_POST['cliente']) ? $_POST['cliente'] : '';
  $ocs = isset($_POST['OCS']) ? $_POST['OCS'] : '';
  $eqp = isset($_POST['equip']) ? $_POST['equip'] : '';
  $equip = '';
  $dadosEqp = '';
  foreach ($eqp as $key => $value) {
    # code...
    $equip .= $value.'/'; 
    $buscaEqp = Painel::selecionarID('tb_estoque',$value);
    $dadosEqp .= $buscaEqp[0]['nome'].' - N/S: '.$buscaEqp[0]['NS'].'/';
  }




  $dias = isset($_POST['dias']) ? $_POST['dias'] : '';
  $tipoeqp = isset($_POST['tipoeqp']) ? $_POST['tipoeqp'] : '';
  $servico = isset($_POST['servico']) ? $_POST['servico'] : '';
  $obs = isset($_POST['obs']) ? $_POST['obs'] : '';
  
  $sql = MySql::conectar()->prepare("UPDATE `tb.historico` SET `cliente` = ?, `ocs` = ?, `dias` = ?, `eqp` = ?, `tipoeqp` = ?, `servico` = ?, `obs` = ?, `dadosEqp` = ? WHERE `tb.historico`.`id` = ?");
  
  if ($sql->execute(array($cliente,$ocs,$dias,$equip,$tipoeqp,$servico,$obs,$dadosEqp,$idEditar))) {
    # code...
    Painel::alerta('Serviço atualizado com sucesso');
   Painel::atualizarPG();
  }else{
    Painel::alerta('Error');
    Painel::atualizarPG();
  }
}

 $servico =Painel::selecionarID('tb.historico',$idEditar);
  
?>

<div class="dados">
  <form method="post">
    <h1>Editar Serviço</h1>
    <div class="container">
      <div class="row">
        <div class="col-md-6 first">
          <div>
            <h2>Nome</h2>
            <p><?php echo ucfirst($_SESSION['usuario'])?></p>
          </div>
          <div>
            <h2>Cliente</h2> 
            <select class="select2" name="cliente">
              <option value=" "></option>
              <?php
                 $empresas = Painel::selectAll('tb_empresas');
                 foreach ($empresas as $key => $value) {
                   # code...
                  ?>
                    <option <?php selectSelecionado($servico[0]['cliente'],$value['empresa']) ?> value="<?php echo $value['empresa'] ?>"><?php echo $value["empresa"] ?></option>
                  <?php
                 }
              ?>
            </select>
          </div>
          <div>
            <h2>Equipamento</h2>
            <select class="select2" name="equip[]" multiple="multiple">
              <option value=" "></option>
              <?php
                 $equipamentos = Painel::selectAll('tb_estoque');

                 foreach ($equipamentos as $key => $value) {
                   # code...
                  ?>
                    <option <?php selectSelecionadoEqp($servico[0]['eqp'],$value['id']) ?> value="<?php echo $value['id'] ?>"><?php echo $value["nome"].' - N/S: '.$value['NS'] ?></option>
                  <?php
                 }
              ?>
            </select>
          </div> 
          <div >
            <h2>OCS</h2> 
            <input type="text" name="OCS" value="<?php echo $servico[0]['ocs']?>">  
          </div>
          <div>
            <h2>Estimativa (Dias)</h2>
            <input type="text" name="dias" pattern="[0-9]+$" value="<?php echo $servico[0]['dias']?>"> 
          </div> 
        </div>
        <div class="col-md-6">
          <div>
            <h2>Tipo de Equipamento</h2>
            <select class="select2" name="tipoeqp">
              <option <?php selectSelecionado($servico[0]['tipoeqp'],'Meterológicos') ?> value="Meterológicos">Meterológicos</option>
              <option <?php selectSelecionado($servico[0]['tipoeqp'],'Ecologger') ?> value="Ecologger">Ecologger</option>
              <option <?php selectSelecionado($servico[0]['tipoeqp'],"Monitor de Particulas") ?> value="Monitor de Particulas">Monitor de Particulas</option>
              <option <?php selectSelecionado($servico[0]['tipoeqp'],'Calibrador') ?> value="Calibrador">Calibrador</option>
              <option <?php selectSelecionado($servico[0]['tipoeqp'],'Analisador') ?> value="Analisador">Analisador</option>
              <option <?php selectSelecionado($servico[0]['tipoeqp'],'Outros') ?> value="Outros">Outros</option>    
            </select>
          </div> 
          <div>
            <h2>Serviço</h2>
            <select class="select2" name="servico">
              <option <?php selectSelecionado($servico[0]['servico'],'Calibracao') ?> value="Calibracao">Calibração</option>
              <option <?php selectSelecionado($servico[0]['servico'],'Avaliacao tecnica') ?> value="Avaliacao tecnica">Avaliação técnica</option>
              <option <?php selectSelecionado($servico[0]['servico'],'Teste de Funcionamento') ?> value="Teste de Funcionamento">Teste de Funcionamento</option>
              <option <?php selectSelecionado($servico[0]['servico'],'Configuracao') ?> value="Configuracao">Configuração</option>
              <option <?php selectSelecionado($servico[0]['servico'],'Manutencao') ?> value="Manutencao">Manutenção</option>
              <option <?php selectSelecionado($servico[0]['servico'],'Rotinas Administrativas') ?> value="Rotinas Administrativas">Rotinas Administrativas</option>
              <option <?php selectSelecionado($servico[0]['servico'],'Viagem') ?> value="Viagem">Viagem</option>
              <option <?php selectSelecionado($servico[0]['servico'],'Outros') ?> value="Outros">Outros</option>
            </select>
          </div>
           <div>
            <h2>Observação</h2>
            <textarea name="obs"><?php echo $servico[0]['obs']?></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="enviar right">
      <input type="submit" name="Enviar" value="Atualizar">
    </div>
    <div class="clear"></div>    
  </form>
</div><!--dados-->

