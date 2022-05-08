<?php include("config.php"); ?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="utf-8">
</head>
<body>

<?php 
      $arquivo = "ATE.xls";

      $html = "";
      $html = '';
      $html .= '<table border="1">';
      $html .= '<tr>';
      $html .= '<td><b>Nome</b></td>';
      $html .= '<td><b>Cliente</b></td>';
      $html .= '<td><b>OCS</b></td>';
      $html .= '<td><b>Data inicial</b></td>';
      $html .= '<td><b>Data final</b></td>';
      $html .= '<td><b>Est (Dias)</b></td>';
      $html .= '<td><b>Equipamento</b></td>';
      $html .= '<td><b>Tipo Eqp</b></td>';
      $html .= '<td><b>Serviço</b></td>';
      $html .= '<td><b>Observação</b></td>';
      $html .= '<td><b>Status</b></td>';
      $html .= '</tr>';

      $sql = MySql::conectar()->prepare("SELECT * FROM `tb.historico`");
      $sql->execute();

      $info = $sql->fetchAll();

      $n = count($info);

      for ($i=0; $i < $n; $i++){ 
          # code...
          $html .= '<tr>';
          $html .= '<td>'.$info[$i]['nome'].'</td>';
          $html .= '<td>'.$info[$i]['cliente'] .'</td>';
          $html .= '<td>'.$info[$i]['ocs'] .'</td>';
          $html .= '<td>'.$info[$i]['datainicial'] .'</td>';
          $html .= '<td>'.$info[$i]['datafinal'] .'</td>';
          $html .= '<td>'.$info[$i]['dias'] .'</td>';
          $html .= '<td>'.$info[$i]['dadosEqp'] .'</td>';
          $html .= '<td>'.$info[$i]['tipoeqp'] .'</td>';
          $html .= '<td>'.$info[$i]['servico'] .'</td>';
          $html .= '<td>'.$info[$i]['obs'] .'</td>';
          $html .= '<td>'.$info[$i]['status'] .'</td>';
          $html .= '</tr>'; 
      }
      

      header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
      header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
      header ("Cache-Control: no-cache, must-revalidate");
      header ("Pragma: no-cache");
      header ("Content-type: application/x-msexcel");
      header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
      header ("Content-Description: PHP Generated Data" );
      // Envia o conteúdo do arquivo
      echo $html;
      exit; 
      
?>
</body>
</html>


