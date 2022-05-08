<?php
  $idEditar = $_GET['id'];
  $dados = Painel::selecionarID('tb_estoque',$idEditar);

  if (count($dados) == 0) {
    # code...
    Painel::alerta('Equipamento não se encontra em estoque');
    Painel::redirecionar(INCLUDE_PATH.'estoque');
  }

  if (isset($_POST['acaoBancada'])) {
      # code...
      $dadosRetorno = [
          'nome_tabela'=>'tb_estoque',
          'id'=>$idEditar,
          'local'=>$_POST['local'],
          'responsavel'=>'indeterminado',
          'obs'=>$_POST['obs'],
          'situacao'=>$_POST['situacao'],
        ] ;
       
      if (Painel::update($dadosRetorno)) {
        # code...
        Painel::alerta('Equipamento retornou ao almoxarifado com sucesso');
        Painel::redirecionar(INCLUDE_PATH.'estoque');
      }else{
        Painel::alerta('Erro');
        Painel::redirecionar(INCLUDE_PATH.'atualizarEqp?id='.$_GET['id']);
      }
    }

    if (isset($_POST['atualizar'])) {
        # code...
        if (Painel::update($_POST)) {
        # code...
        Painel::alerta('Equipamento atualizado com sucesso');
        Painel::redirecionar(INCLUDE_PATH.'estoque');
        }else{
          Painel::alerta('Erro ao atualizar');
          Painel::redirecionar(INCLUDE_PATH.'atualizarEqp?id='.$_GET['id']);
        }
    }

    if (isset($_POST['enviarBancada'])) {
        $infoBancada = array(
          'nome_tabela'=>'tb_estoque',
          'id'=>$idEditar,
          'situacao'=>'Em Execução',
          'dataBancada'=> date('d/m/Y'),
          'local'=>'Bancada',
          'responsavel'=>$_POST['responsavel'],
        ); 
        if (Painel::update($infoBancada)) {
              # code...
              Painel::alerta('Equipamento enviado para bancada com sucesso');
              Painel::redirecionar(INCLUDE_PATH.'estoque');
            }else{
              Painel::alerta('Ocorreu um erro');
              Painel::redirecionar(INCLUDE_PATH.'atualizarEqp?id='.$_GET['id']);
            }    
      }

  if ($dados[0]['local'] == 'Bancada') {
    # code...
    ?>
      <div class="dados">
        <form method="post">
          <h1>Retornar equipamento para o almoxarifado?</h1>
          <div><h2>Local:</h2><input type="text" name="local" required></div>
          <div><h2>Observação:</h2><textarea name="obs"><?php echo $dados[0]['obs']?></textarea></div>
          <div>
            <h2>Situação:</h2>
            <select class="select2" name="situacao" required>
              <option value="Ag Avaliação"<?php selectSelecionado($dados[0]['situacao'],'Ag Avaliação')?>>Ag Avaliação</option>
              <option value="Ag Manutenção"<?php selectSelecionado($dados[0]['situacao'],'Ag Manutenção')?>>Ag Manutenção</option>
              <option value="Ag Aprovação"<?php selectSelecionado($dados[0]['situacao'],'Ag Aprovação')?>>Ag Aprovação</option>
              <option value="Ag Coleta"<?php selectSelecionado($dados[0]['situacao'],'Ag Coleta')?>>Ag Coleta</option>
            </select>
          </div>
          <div class="enviar right">
            <input style="width: auto" type="submit" name="acaoBancada" value="Retornar Equipamento">
          </div>
          <div class="clear"></div>
        </form>
      </div>
<?php  }else{  ?>

<div class="dados">
  <h1>Atualizar Equipamento</h1>
  <form method="post">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div>
            <h2>Nome:</h2> 
            <input type="text" name="nome" value="<?php echo $dados[0]['nome'] ?>" required>
          </div>
          <div>
            <h2>N/S:</h2> 
            <input type="text" name="NS" value="<?php echo $dados[0]['NS'] ?>">
          </div>
          <div>
            <h2>Tipo de Equipamento:</h2>
            <select class="select2" name="tipoEqp" required>
              <option value="BAM1020" <?php if ($dados[0]['tipoEqp'] == 'BAM1020') echo 'selected'?>>BAM1020</option>
              <option value="Analisador" <?php if ($dados[0]['tipoEqp'] == 'Analisador') echo 'selected'?>>Analisador</option>
              <option value="Meteorológicos" <?php if ($dados[0]['tipoEqp'] == 'Meteorológicos') echo 'selected'?>>Meteorológicos</option>
            </select>
          </div>
          <div>
            <h2>Data de Entrada:</h2>
            <input placeholder="dd/mm/YYYY" formato=data type="text" name="dataEntrada" value="<?php echo $dados[0]['dataEntrada'] ?>" required>
          </div>
          <div>
            <h2>Data da NF:</h2>
            <input placeholder="dd/mm/YYYY" formato=data type="text" name="dataNF" value="<?php echo $dados[0]['dataNF'] ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div>
            <h2>Local:</h2>
            <input type="text" name="local" value="<?php echo $dados[0]['local'] ?>" required>
          </div>
          <div>
            <h2>Situação:</h2>
            <select class="select2" name="situacao" required>
              <option value="Ag Avaliação"<?php selectSelecionado($dados[0]['situacao'],'Ag Avaliação')?>>Ag Avaliação</option>
              <option value="Ag Manutenção"<?php selectSelecionado($dados[0]['situacao'],'Ag Manutenção')?>>Ag Manutenção</option>
              <option value="Ag Aprovação"<?php selectSelecionado($dados[0]['situacao'],'Ag Aprovação')?>>Ag Aprovação</option>
              <option value="Ag Coleta"<?php selectSelecionado($dados[0]['situacao'],'Ag Coleta')?>>Ag Coleta</option>
            </select>
          </div>
          <div>
            <h2>Empresa:</h2>
            <select class="select2" name="empresa">
              <?php
               $empresas = Painel::selectAll('tb_empresas');
               foreach ($empresas as $key => $value) {
                 # code...
                ?>
                  <option value="<?php echo $value['empresa'] ?>" <?php if($dados[0]['empresa'] == $value['empresa']) echo "selected"?>>
                    <?php echo $value['empresa'] ?>
                  </option>
                 <?php
               }
              ?>
            </select>
          </div>
          <input type="hidden" name="responsavel" value="indeterminado">
          <div>
            <h2>OCS:</h2>
            <input type="text" name="ocs" value="<?php echo $dados[0]['ocs'] ?>">
          </div>
          <div>
            <h2>Observação:</h2>
            <textarea name="obs"><?php echo $dados[0]['obs']?></textarea>
          </div>
          <input type="hidden" name="id" value="<?php echo $idEditar?>">
          <input type="hidden" name="nome_tabela" value="tb_estoque">
          <div class="enviar right">
            <input type="submit" name="atualizar" value="Atualizar">
          </div>
          <div class="enviar right">
            <input style="width: auto;" type="submit" name="bancada" value="Enviar para bancada">
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </div>
   
   <?php
    if (isset($_POST['bancada'])) {
      # code...
      ?><div>
          <h2>Responsável</h2>
          <select class="select2" name="responsavel">
            <?php 
            $usuarios = Painel::selectAll('tb_admin.usuarios');
               foreach ($usuarios as $key => $value) {
                 # code...
                ?>
                  <option value="<?php echo $value['user'] ?>">
                    <?php echo $value['user'] ?>
                  </option>
                 <?php
               }
              ?>
          </select>
        </div>
        <div class="enviar right">
          <input type="submit" name="enviarBancada" value="Enviar">
        </div>
        <div class="clear"></div>
      </form>
       <?php } } ?>
</div>


