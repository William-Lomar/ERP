<div class="tabela dados">
  <h1>Gerar Certificado</h1> 
  <form method="post">
    <div>
      <h2>Selecione o equipamento desejado:</h2>
      <select class="select2" name="eqp">
        <option <?php selectSelecionado(@$_GET['eqp'],'radiacao') ?> value="radiacao">Radiação Solar</option>
        <option <?php selectSelecionado(@$_GET['eqp'],'velocidade') ?>  value="velocidade">Velocidade do Vento</option>
      </select>
  </div>
  <div class="enviar right">
    <input type="submit" name="Enviar" value="ENVIAR">
  </div>
  <div class="clear"></div>
  </form>
</div>

<?php  
  if (isset($_POST['Enviar'])) {
    Painel::redirecionar(INCLUDE_PATH."certificado?eqp=".$_POST['eqp']);
  }

  if (isset($_GET['eqp'])) { ?>
<div class="dados certificado">
  <form id='formCertificado' method="post" target="_blank" action="<?php
   echo INCLUDE_PATH?>Certificados/gerarCertificado/padrao.php?eqp=<?php echo $_GET['eqp']?>">
    <h1>Dados Gerais</h1>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div>
            <h2>Equipamento</h2>
            <input type="text" name="eqp">
          </div>
          <div>
            <h2>Número de Série</h2>
            <input type="text" name="ns">
          </div>
          <div>
            <h2>Data da Calibração</h2>
            <input formato='data' placeholder="dd/mm/YYYY" type="text" name="data">
          </div>
          <div>
            <h2>Ordem de Serviço</h2>
            <input type="text" name="os">
          </div>
        </div>
        <div class="col-md-6">
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
            <h2>Responsável</h2>
            <select class="select2" name="responsavel">
          <?php
             $funcionarios = Painel::selectAll('tb_admin.usuarios');
             foreach ($funcionarios as $key => $value) {
              ?>
                <option value="<?php echo $value['user'] ?>"><?php echo $value["user"] ?></option>
              <?php
             }
          ?>
            </select>
          </div>
          <div>
            <h2>Número do certificado</h2>
            <input type="text" name="numeroCertificado">
          </div>
        </div>
      </div>
    </div>

    <h1>Padrões Utilizados</h1>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <select class="select2" name="padrao[]" multiple="multiple">
              <option value=" "></option>
              <?php
                 $padroes = Painel::selectAll('tb_padroes');
                 foreach ($padroes as $key => $value) {
                  if (!Painel::validaPadraoBool($value['dataCertificado'])) {
                    continue;
                  }
                  ?>
                    <option value="<?php echo $value['id'] ?>"><?php echo $value["nome"].' - N/S: '.$value['NS'] ?></option>
                  <?php
                 }
              ?>
            </select>
        </div>
      </div>
    </div>

    <h1>Dados</h1>
    <?php 
      include("Certificados/formCertificado/".$_GET['eqp'].'.php');
    ?>

  <button name='gerarCertificado' id='gerarCertificado' type="submit" class="btn btn-success right">Gerar Certificado</button>
  <div class="clear"></div>
  </form>
</div>
<?php } ?>




