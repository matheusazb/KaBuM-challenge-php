<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= ($data['metatags'] && $data['metatags']['title']) ? $data['metatags']['title'] : 'Painel KaBuM' ?></title>
  <?php applyCssFiles($data['CSS']); ?>
</head>

<body>
  <script>
    window.ENDPOINT_CLIENT_DELETE = "<?= ENDPOINT_CLIENT_DELETE ?>";
    window.ENDPOINT_CLIENT_CREATE = "<?= ENDPOINT_CLIENT_CREATE ?>";
    window.ENDPOINT_CLIENT_LIST = "<?= ENDPOINT_CLIENT_LIST ?>";

    window.ENDPOINT_ADDRESS_DELETE = "<?= ENDPOINT_ADDRESS_DELETE ?>";
    window.ENDPOINT_ADDRESS_CREATE = "<?= ENDPOINT_ADDRESS_CREATE ?>";
    window.ENDPOINT_ADDRESS_LIST = "<?= ENDPOINT_ADDRESS_LIST ?>";
    window.ENDPOINT_AUTH = "<?= ENDPOINT_AUTH ?>";
  </script>