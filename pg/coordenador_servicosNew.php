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