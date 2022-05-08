<div class="dados">
  <h2>3. Resultados finais.</h2>
  <table>
    <tr>
      <td>Resultados</td>
      <td>Coeficiente</td>
    </tr>
    <tr>
      <td>Atual - uA / (1000W/m²)</td>
      <td><?php echo number_format($_POST['uA'],1,',','.')?></td>
    </tr>
    <tr>
      <td>Atual – mv / (2000w/m²)</td>
      <td><?php
      $resultado = $_POST['uA']*0.2;
      echo number_format($resultado,1,',','.');
       ?></td>
    </tr>
  </table>
</div>
