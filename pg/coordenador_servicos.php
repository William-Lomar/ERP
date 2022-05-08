<?php 
 if (isset($_POST['Enviar'])) {
  $eqp = $_POST['equip'];
  $equip = '';
  $dadosEqp = '';
  foreach ($eqp as $key => $value) {
    $equip .= $value.'/'; 
    $buscaEqp = Painel::selecionarID('tb_estoque',$value);
    $dadosEqp .= $buscaEqp[0]['nome'].' - N/S: '.$buscaEqp[0]['NS'].'/';
  }
 
  $dadosBanco = array(
    'nome' => $_POST['nome'], 
    'cliente' => $_POST['cliente'],
    'OCS' => $_POST['OCS'],
    'datainicial' => date('d/m/Y'),
    'datafinal' => '',
    'dias' => $_POST['dias'],
    'eqp' => $equip,
    'tipoeqp' => $_POST['tipoeqp'],
    'servico' => $_POST['servico'],
    'obs' => $_POST['obs'],
    'status' => 'Em execução',
    'dadosEqp' => $dadosEqp
  );

  if (Banco::insert($dadosBanco,'tb.historico')) {
    Painel::alerta("Serviço cadastrado com sucesso");
    Painel::atualizarPG();
  }
 }
?> 
<div class="dados">
  <form method="post">
    <h1>Designar Serviço</h1>
    <div class="container">
      <div class="row">
        <div class="col-md-6 first">
          <div>
            <h2>Nome</h2> 
            <select class="select2" name="nome">
          <?php
             $funcionarios = Painel::selectAll('tb_admin.usuarios');
             foreach ($funcionarios as $key => $value) {
              if ($value['user'] == 'Coordenador') {
                continue;
              }
              ?>
                <option value="<?php echo $value['user'] ?>"><?php echo $value["user"] ?></option>
              <?php
             }
          ?>
            </select>
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
                   # code...
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
</div>
<?php 
  $dadosFuncionarios = Banco::newSelectAll('tb_admin.usuarios');
  foreach ($dadosFuncionarios as $chave => $valor) {
    if ($valor['user'] == 'Coordenador') {
      continue;
    }
    ?>
    <div class="tabela">
  <?php
    $nome = $valor['user']; 
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb.historico` WHERE `tb.historico`.`status` = 'Em execução' AND `tb.historico`.`nome` = ?");
    $sql->execute(array($nome));
    $info = $sql->fetchAll();
   ?>
  <h1><?php echo $nome ?></h1>
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
      </tr>
      <?php 
    foreach ($info as $key => $value) { 
      $id = $value['id'];
       ?>
        <tr>
          <td><?php echo ucfirst($value['nome'])?></td>
          <td><?php echo $value['cliente'] ?></td>
          <td><?php echo $value['ocs'] ?></td>
          <td><?php echo $value['datainicial'] ?></td>
          <td><?php echo $value['dias'] ?></td>
          <td>
            <?php
            $equipamentos = explode('/', $value['eqp']);
            if (count($equipamentos) > 1){
              foreach ($equipamentos as $key2 => $value2) {
                if (count($equipamentos)-1 == $key2) {
                  continue;
                }
                $equipamento = Painel::selecionarID('tb_estoque',$value2);
                if (count($equipamento) == 0) {
                  continue;
                }
                ?>
                <a style="display: block;" href="<?php echo INCLUDE_PATH.'atualizarEqp?id='.$value2?>"><?php echo $equipamento[0]['nome'].' - N/S: '.$equipamento[0]['NS']; ?></a>
              <?php
              }
            }
             ?>
          </td>
          <td><?php echo $value['tipoeqp'] ?></td>
          <td><?php echo $value['servico'] ?></td>
          <td><?php echo $value['obs'] ?></td>
        </tr>
      <?php } ?>
    </table>        
   </form>
  </table>
</div>
    <?php
  }
?>


