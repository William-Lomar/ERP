<div>
  <?php
    use chillerlan\QRCode\QRCode;
    use chillerlan\QRCode\QROptions;

    $data = $_SESSION['QRCode'];

    echo '<img src="'.(new QRCode)->render($data).'" alt="QR Code" />';
  ?>
</div>
