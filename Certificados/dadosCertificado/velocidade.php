<div class="padroes">
  <h2>3. Resultados finais.</h2>
  <table class="tabelaVelocidade">
    <tr>
      <td style="text-align: center;" colspan = '6'>Velocidade do Vento</td>
    </tr>
    <tr>
      <td style="text-align: center;">Intervalo de Velocidade (m/s)</td>
      <td>Velocidade Convencional (m/s)</td>
      <td>Velocidade Medida (m/s)</td>
      <td>Erro (m/s)</td>
      <td>Tolerância +/- (m/s)</td>
      <td>Situação</td>
    </tr>
    <tr>
      <td>10 a 15</td>
      <td><?php echo $_POST['vp1']?></td>
      <td><?php echo $_POST['vs1']?></td>
      <td><?php if ($_POST['vs1'] - $_POST['vp1'] > 0) {
        echo '+';
      } echo $_POST['vs1'] - $_POST['vp1'] ?></td>
      <td>0,50</td>
      <td>OK</td>
    </tr>
    <tr>
      <td>20 a 25</td>
      <td><?php echo  $_POST['vp2']?></td>
      <td><?php echo $_POST['vs2']?></td>
      <td><?php if ($_POST['vs2'] - $_POST['vp2'] > 0) {
        echo '+';
      } echo $_POST['vs2'] - $_POST['vp2'] ?></td>
      <td>0,50</td>
      <td>OK</td>
    </tr>
    <tr>
      <td>30 a 35</td>
      <td><?php echo $_POST['vp3']?></td>
      <td><?php echo $_POST['vs3']?></td>
      <td><?php if ($_POST['vs3'] - $_POST['vp3'] > 0) {
        echo '+';
      } echo $_POST['vs3'] - $_POST['vp3'] ?></td>
      <td>0,50</td>
      <td>OK</td>
    </tr>
    <tr>
      <td>40 a 45</td>
      <td><?php echo $_POST['vp4']?></td>
      <td><?php echo $_POST['vs4']?></td>
      <td><?php if ($_POST['vs4'] - $_POST['vp4'] > 0) {
        echo '+';
      } echo $_POST['vs4'] - $_POST['vp4'] ?></td>
      <td>0,50</td>
      <td>OK</td>
    </tr>
  </table>
</div>
