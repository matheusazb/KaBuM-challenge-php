<?php
require_once VIEWS_PATH . '/partials/header.php';
require_once VIEWS_PATH . '/partials/_header.php';
?>

<div class="o-container">

  <div class="u-justify-between u-db u-flex@sm u-mb-32">
    <div class="u-justify-between u-db u-fs-14 u-dn u-mb-24 u-mb-0@sm u-flex-column">
      <h2 class="u-fs-24 u-mb-0@sm u-fw-800">Lista de clientes</h2>
      <?php if ($data['hasRecords']) { ?>
        <div class="u-mb-24 u-mb-0@sm u-mt-4 u-justify-between u-db u-mt-4 u-flex@sm u-fs-14 u-dn u-flex@sm u-fw-200">
          Mostrando <?= $data['count'] ?> registr<?= $data['count'] === 1 ? 'o' : 'os' ?>
        </div>
      <?php } ?>
    </div>
    <div class="u-flex u-items-center">
      <a href="<?= BASEURL_CLIENT_CREATE ?>" class="c-button c-button--primary u-w-100"><span class="lni lni-plus u-mr-4 u-fs-12 u-fw-600"></span> Adicionar cliente</a>
    </div>
  </div>
  <?php
  if (!$data['hasRecords']) { ?>
    <span>Não existem registros cadastrados</span>
  <?php } else { ?>
    <ul class="o-list c-list">
      <li class="c-list__header">
        <div class="o-row">
          <div class="o-column o-column-5@sm u-fs-14 u-fw-600">
            Nome
          </div>
          <div class="o-column o-column-4@sm u-fs-14 u-fw-600">
            CPF
          </div>
          <div class="o-column o-column-3@sm u-dn u-db@sm"></div>
        </div>
      </li>
      <?php
      foreach ($data['list'] as $item) {
        $updateLink = sprintf(BASEURL_CLIENT_UPDATE, $item['client_id']);
        $addressListLink = sprintf(BASEURL_CLIENT_ADDRESS_LIST, $item['client_id']);
      ?>
        <li class="c-list__item">
          <div class="o-row">
            <div class="o-column o-column-5@sm u-flex u-items-center u-fs-14">
              <?= $item['name'] ?>
            </div>
            <div class="o-column o-column-4@sm u-flex u-items-center u-fs-14">
              <?
                $cpf = $item['cpf'];
                $maskedCpf = sprintf("%s.%s.%s-%s", substr($cpf,0, 3), substr($cpf,3, 3), substr($cpf,6, 3), substr($cpf,9, 2));
                echo $maskedCpf;
              ?>
            </div>

            <div class="o-column o-column-3@sm c-list__actions u-tr@sm u-mt-8 u-mt-0@sm">
              <a href="<?= $updateLink ?>" class="u-pd-8"><span class="lni lni-pencil"></span></a>
              <a href="<?= $addressListLink ?>" class="u-pd-8"><span class="lni lni-cog"></span></a>
              <a href="javascript:;" class="js-list-remove u-pd-8" data-id="<?= $item['client_id'] ?>"><span class="lni lni-trash"></span></a>
            </div>
          </div>
        </li>
      <?php } ?>
    </ul>
  <?php } ?>
</div>

<?php
require_once VIEWS_PATH . '/partials/footer.php';
