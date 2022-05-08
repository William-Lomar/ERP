<?php
  $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ?");
  $sql->execute(array($_SESSION['usuario']));
  $dados = $sql->fetchAll();
  $img_atual = $dados[0]['img'];
  $password = $dados[0]['password'];
?>

<div class="dados editarUsuario">
  <img style = 'max-width: 100%;height: auto;' src="img/<?php echo $img_atual?>">
    <h1>Editar Usuário</h1>
    <form method="post" enctype="multipart/form-data"><!--enctype="multipart/form-data"-> necessário para upload de img/arquivos -->
      <div class="form-group">
        <label>Senha:</label>
        <input type="text" name="password" value="<?php echo $password?>">
      </div><!--form-group-->
      <div class="form-group">
        <label>Imagem:</label>
        <input type="file" name="imagem" >
      </div><!--form-group-->
      <div class="form-group enviar">
        <input type="submit" name="acao" value="Atualizar">
      </div><!--form-group-->
    </form>
</div>

  <?php

    if (isset($_POST["acao"])) {
      # code... enviado formulario, img só funciona com post
      
      $password = @$_POST["password"];
      $img = @$_FILES['imagem'];

      if ($img['name'] == '') {
        # code... Não tem upload de imagem
        $img = $img_atual;
        if (Usuario::atualizarUsuario($password,$img)) {
         # code...
        Painel::alerta('Atualizado com sucesso');
       }
      }else{
        //Tem upload de imagem
        if (Painel::imagemValida($img)){
              Painel::deleteFile($img_atual);
              # code...
              $img = Painel::uploadFile($img);
              if ($img != false) {
                # code...
                if (Usuario::atualizarUsuario($password,$img)) {
                # code...
                Painel::alerta('Atualizado com sucesso junto com a imagem');
                Painel::redirecionar(INCLUDE_PATH.'editarusuario');

                }else{
                Painel::alerta('Erro ao atualizar');
                }

              }else{
                Painel::alerta('Erro ao mover a imagem');
              }
  
        }else{
          Painel::alerta('Arquivo selecionado não é valido');
        }
      }
    }


  ?>

</div>

