<?php
  if (isset($_POST['excel'])) {
  Painel::redirecionar(INCLUDE_PATH.'imprimir.php');
  }

  $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
  $porPagina = 10;
  $historico = Painel::selectAll("tb.historico",($paginaAtual-1)*$porPagina,$porPagina);
?>

<div class="tabela">
  <h1 class="left">Histórico</h1>
  <div class="enviar right">
    <a href="<?php echo INCLUDE_PATH?>imprimir.php" target='_blank'>Gerar Excel</a>
  </div>
    <table>
      <tr>
        <td>Nome</td>
        <td>Cliente</td>
        <td>OCS</td>
        <td>Data inicial</td>
        <td>Data final</td>
        <td>Est (Dias)</td>
        <td>Equipamento</td>
        <td>Tipo Eqp</td>
        <td>Serviço</td>
        <td>Observação</td>
        <td>Status</td>
      </tr>

      <?php
      foreach ($historico as $key => $value) {
        ?>
        <tr>
          <td><?php echo ucfirst($value['nome']) ?></td>
          <td><?php echo $value['cliente'] ?></td>
          <td><?php echo $value['ocs'] ?></td>
          <td><?php echo $value['datainicial'] ?></td>
          <td><?php echo $value['datafinal'] ?></td>
          <td><?php echo $value['dias'] ?></td>
          <td><?php echo $value['dadosEqp'] ?></td>
          <td><?php echo $value['tipoeqp'] ?></td>
          <td><?php echo $value['servico'] ?></td>
          <td><?php echo $value['obs'] ?></td>
          <td><?php echo $value['status']?></td>
        </tr>
        <?php } ?>
    </table>
    <nav class="paginacao">
      <ul class="pagination justify-content-center">
        <?php
        $totalPaginas = ceil(count(Painel::selectAll("tb.historico")) / $porPagina);
        //ceil -> arrendonda pro proximo inteiro
        for ($i=1; $i <= $totalPaginas; $i++) { 
          # code...
          if ($i == $paginaAtual) {
            # code...
            echo "<li class='page-item'><a class='page-link selectAtivado' href='".INCLUDE_PATH."historico?pagina=".$i."'>".$i."</a></li>";
          }else{
            echo "<li class='page-item'><a class='page-link' href='".INCLUDE_PATH."historico?pagina=".$i."'>".$i."</a></li>";
          }
        }
        ?>
       </ul>
    </nav>
</div><!--tabela-->


