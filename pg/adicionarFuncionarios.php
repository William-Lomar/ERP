<?php verificaPermissaoPagina(3); ?>

<div class="dados adicionarFuncionario">
   <h1>Adicionar Funcionário</h1>

  <form method="post">
    <div>
      <h2>Nome</h2>
      <input type="text" name="user">
    </div>
    <div>
      <h2>Senha</h2>
      <input type="password" name="password">
    </div>
    <div>
      <h2>Cargo</h2>
      <input type="hidden" name="img" value="">
    </div>  
    <div>
      <select name="cargo" class="select2">
        <option value="1">Técnico</option>
        <option value="2">ADM</option>
      </select>
    </div>
    <div class="enviar right">
      <input type="submit" name="enviar" value="ENVIAR">
    </div>
    <div class="clear"></div>
  </form>
</div>

  <?php
    if (isset($_POST['enviar'])){
      if (Painel::insert($_POST,'tb_admin.usuarios')) {
        # code...
        Painel::alerta('O cadastro foi realizado com sucesso');
      }else{
        Painel::alerta('Campos vazios');
      }
    }
  ?>
