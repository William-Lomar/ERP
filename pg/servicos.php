<?php
  if (isset($_GET['finalizar'])) {
    $idFinalizar = intval($_GET['finalizar']);
    $sql = MySql::conectar()->prepare("UPDATE `tb.historico` SET `status` = 'Concluída', `datafinal` = ? WHERE `tb.historico`.`id` = ?");
    $sql->execute(array(date('d/m/Y'),$idFinalizar));
    Painel::alerta('Registro concluído com sucesso!');
    Painel::redirecionar(INCLUDE_PATH.'servicos');
  }

  if (isset($_GET['excluir'])) {
    $idExcluir = intval($_GET['excluir']);

    if (Painel::deletar("tb.historico",$idExcluir)) {
      Painel::alerta('Registro excluído com sucesso!');
      Painel::redirecionar(INCLUDE_PATH.'servicos');

    }else{
      ?>
        <script type="text/javascript">
          alert('Error ao excluir registro');
        </script>
      <?php
      Painel::redirecionar(INCLUDE_PATH.'servicos');
    }

  }

   if (isset($_POST['Enviar'])) {
    $nome = @$_SESSION['usuario'];
    $cliente = isset($_POST['cliente']) ? $_POST['cliente'] : '';
    $ocs = isset($_POST['OCS']) ? $_POST['OCS'] : '';
    $eqp = isset($_POST['equip']) ? $_POST['equip'] : '';
    $equip = '';
    $dadosEqp = '';
    foreach ($eqp as $key => $value) {
      $equip .= $value.'/'; 
      $buscaEqp = Painel::selecionarID('tb_estoque',$value);
      $dadosEqp .= $buscaEqp[0]['nome'].' - N/S: '.$buscaEqp[0]['NS'].'/';
    }

    $dias = isset($_POST['dias']) ? $_POST['dias'] : '';
    $tipoeqp = isset($_POST['tipoeqp']) ? $_POST['tipoeqp'] : '';
    $servico = isset($_POST['servico']) ? $_POST['servico'] : '';
    $obs = isset($_POST['obs']) ? $_POST['obs'] : '';
    
    $sql = MySql::conectar()->prepare("INSERT INTO `tb.historico` VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?)");
    if ($sql->execute(array($nome,$cliente,$ocs,date('d/m/Y'),"",$dias,$equip,$tipoeqp,$servico,$obs,"Em execução",$dadosEqp))) {
        Painel::alerta("Serviço cadastrado com sucesso");
        Painel::atualizarPG();
      }  
  }
?> 

<div class="dados">
  <form method="post">
    <h1>Cadastrar Serviço</h1>
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
                  ?>
                    <option value="<?php echo $value['empresa'] ?>"><?php echo $value["empresa"] ?></option>
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
                  ?>
                    <option value="<?php echo $value['id'] ?>"><?php echo $value["nome"].' - N/S: '.$value['NS'] ?></option>
                  <?php
                 }
              ?>
            </select>
          </div> 
          <div >
            <h2>OCS</h2> 
            <input type="text" name="OCS">  
          </div>
          <div>
            <h2>Estimativa (Dias)</h2>
            <input required="" type="text" name="dias" pattern="[0-9]+$"> 
          </div> 
        </div>
        <div class="col-md-6">
          <div>
            <h2>Tipo de Equipamento</h2>
            <select class="select2" name="tipoeqp">
              <option value=" "></option>
              <option value="Meterológicos">Meterológicos</option>
              <option value="Ecologger">Ecologger</option>
              <option value="Monitor de Particulas">Monitor de Particulas</option>
              <option value="Calibrador">Calibrador</option>
              <option value="Analisador">Analisador</option>
              <option value="Outros">Outros</option>
            </select>
          </div> 
          <div>
            <h2>Serviço</h2>
            <select class="select2" name="servico">
              <option value=" "></option>
              <option value="Calibracao">Calibração</option>
              <option value="Avaliacao tecnica">Avaliação técnica</option>
              <option value="Teste de Funcionamento">Teste de Funcionamento</option>
              <option value="Configuracao">Configuração</option>
              <option value="Manutencao">Manutenção</option>
              <option value="Rotinas Administrativas">Rotinas Administrativas</option>
              <option value="Viagem">Viagem</option>
              <option value="Outros">Outros</option>
            </select>
          </div>
           <div>
            <h2>Observação</h2>
            <textarea name="obs"></textarea>
          </div>
          
        </div>
      </div>
    </div>
    <div class="enviar right">
      <input type="submit" name="Enviar" value="ENVIAR">
    </div>
    <div class="clear"></div>
  </form>
</div><!--dados-->

<div class="tabela">
  <h1>Em execução</h1>
  <form method="post">

    <table>
      <tr>
        <td>Nome</td>
        <td>Cliente</td>
        <td>OCS</td>
        <td>Data inicial</td>
        <td>Est (Dias)</td>
        <td>Equipamento</td>
        <td>Tipo Eqp</td>
        <td>Serviço</td>
        <td>Observação</td>
        <td></td>
      </tr>
      <?php 
          $nome = @$_SESSION['usuario'];
          $sql = MySql::conectar()->prepare("SELECT * FROM `tb.historico` WHERE `tb.historico`.`status` = 'Em execução' AND `tb.historico`.`nome` = ?");
          $sql->execute(array($nome));

          $info = $sql->fetchAll();
          
          $n = count($info);

          for ($i=0; $i < $n; $i++) { 
            # code...
            $id = $info[$i]['id'];
             ?>
              <tr>
                <td><?php echo ucfirst($info[$i]['nome'])?></td>
                <td><?php echo $info[$i]['cliente'] ?></td>
                <td><?php echo $info[$i]['ocs'] ?></td>
                <td><?php echo $info[$i]['datainicial'] ?></td>
                <td><?php echo $info[$i]['dias'] ?></td>
                <td>
                  <?php
                  $equipamentos = explode('/', $info[$i]['eqp']);
                  if (count($equipamentos) > 1){
                    foreach ($equipamentos as $key => $value) {
                      # code...
                      if (count($equipamentos)-1 == $key) {
                        # code...
                        continue;
                      }

                      $equipamento = Painel::selecionarID('tb_estoque',$value);
                      if (count($equipamento) == 0) {
                        # code...
                        continue;
                      }

                      ?>
                      <a style="display: block;" href="<?php echo INCLUDE_PATH.'atualizarEqp?id='.$value?>"><?php echo $equipamento[0]['nome'].' - N/S: '.$equipamento[0]['NS']; ?></a>
                    <?php
                    }
                  }
                   ?>
                </td>
                <td><?php echo $info[$i]['tipoeqp'] ?></td>
                <td><?php echo $info[$i]['servico'] ?></td>
                <td><?php echo $info[$i]['obs'] ?></td>
                <td>
                  <a botaoAcao = "finalizar" href="<?php echo INCLUDE_PATH?>servicos?finalizar=<?php echo $info[$i]['id']?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                  <a botaoAcao='delete' href="<?php echo INCLUDE_PATH?>servicos?excluir=<?php echo $info[$i]['id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                  <a href="<?php echo INCLUDE_PATH?>editarServico?editar=<?php echo $info[$i]['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                </td>
              </tr>
            <?php } ?>
    </table>        
   </form>
  </table>
</div>

