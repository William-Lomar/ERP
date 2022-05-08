<?php verificaPermissaoPagina(3); ?>


<div class="tabela editarFuncionarios dados">
  <form method="post">
    <h1>Editar Funcionários</h1>
    <div>
      <h2>Selecione o novo cargo:</h2>
      <select class="select" name="cargo">
        <option value="1">Técnico</option>
        <option value="2">ADM</option>
      </select>
    </div>
    

    <table>
      <tr>
        <td>Nome</td>
        <td>Cargo</td>
        <td></td>
      </tr>

      <?php 
    $cargo = @$_POST["cargo"];
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios`");
    $sql->execute();
    $usuarios = $sql->fetchAll();

    foreach ($usuarios as $key => $value) {
      # code...
      if ($value['user'] == "Coordenador") {
        # code...
        continue;
      }
      ?>
      <tr>
        <td><?php echo $value['user']?></td>
        <td>
          <?php if ($value['cargo'] == 1) {
          # code...
          echo "Técnico";
          }elseif($value['cargo'] == 2){
            echo "ADM";
          }?>
        </td>
        <td>
          <input type="submit" name="atualizar<?php echo $value['id']?>" value="Atualizar">
          <input type="submit" name="demitir<?php echo $value['id']?>" value="Demitir">
        </td>
      </tr>
      <?php

      if (isset($_POST['demitir'.$value['id']])) {
        # code...
        $idExcluir = $value['id'];
        if (Painel::deletar("tb_admin.usuarios",$idExcluir)) {
          # code...
          ?>
            <script type="text/javascript">
              alert('Funcionário demitido com sucesso');
            </script>
          <?php
          Painel::redirecionar(INCLUDE_PATH.'editarFuncionarios');

        }else{
          ?>
            <script type="text/javascript">
              alert('Error ao demitir funcionário');
            </script>
          <?php
          Painel::redirecionar(INCLUDE_PATH.'editarFuncionarios');
        }
        
      }

      if (isset($_POST['atualizar'.$value['id']])) {
        # code...
        $sql = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET cargo = ? WHERE id = ?");
        
        if ($sql->execute(array($cargo,$value['id']))) {
          # code...
          ?>
            <script type="text/javascript">
              alert('Funcionário atualizado com sucesso');
            </script>
          <?php
          Painel::redirecionar(INCLUDE_PATH.'editarFuncionarios');
        }else{
          ?>
            <script type="text/javascript">
              alert('Erro ao atualizar funcionário');
            </script>
          <?php
        }
      }
    }
    ?>
    </table>
  </form>
</div>

