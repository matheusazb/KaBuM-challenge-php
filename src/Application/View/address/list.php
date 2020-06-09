<?php
require_once VIEWS_PATH . '/partials/header.php';
require_once VIEWS_PATH . '/partials/_header.php';
?>

<div class="o-container">
  <div class="u-mb-24 u-db u-flex@sm u-items-center">
    <a href="<?= BASEURL_CLIENT_LIST ?>" class="c-button c-button--secondary-gray u-td-none u-fs-12 u-fs-12 u-fw-600">
      <span class="lni lni-chevron-left"></span>
      <span>Voltar</span>
    </a>
  </div>
  <div class="u-justify-between u-db u-flex@sm u-mb-32">
    <div class="u-justify-between u-db u-fs-14 u-dn u-mb-24 u-mb-0@sm u-flex-column">
      <h2 class="u-fs-24 u-mb-0@sm">Lista de endereços</h2>
      <span class="c-badge c-badge--blue u-mt-4">Cliente:</span> <span><?= $data['client']['name'] ?></span>
    </div>
    <div>
      <a href="<?= sprintf(BASEURL_CLIENT_ADDRESS_CREATE, $data['client_id']) ?>" class="u-flex u-items-center u-justify-center c-button c-button--primary u-td-none"><span class="lni lni-plus u-mr-4"></span> Adicionar endereço</a>
    </div>
  </div>

  <?php if ($data['hasRecords']) { ?>
    <ul class="o-list c-list">
      <li class="c-list__header">
        <div class="o-row">
          <div class="o-column o-column-10@sm">
            Endereço
          </div>
          <div class="o-column o-column-2@sm u-dn u-db@sm"></div>
        </div>
      </li>
      <?php
      foreach ($data['list'] as $item) {
        $updateLink = sprintf(BASEURL_CLIENT_ADDRESS_UPDATE, $item['address_id']);
      ?>
        <li class="c-list__item">
          <div class="o-row">
            <div class="o-column o-column-10@sm u-flex u-items-center">
              <?= $item['cep'] ?>, <?= $item['street'] ?>, nº <?= $item['number'] ?>, <?= $item['city'] ?> / <?= $item['state'] ?>
            </div>
            <div class="o-column o-column-2@sm c-list__actions u-tr@sm u-mt-8 u-mt-0@sm">
              <a href="<?= $updateLink ?>" class="u-pd-8"><span class="lni lni-pencil"></span></a>
              <a href="javascript:;" class="js-list-remove u-pd-8" data-id="<?= $item['address_id'] ?>"><span class="lni lni-trash"></span></a>
            </div>
          </div>
        </li>
      <?php } ?>
    </ul>
  <?php } else { ?>
    <span>Não existem registros cadastrados</span>
  <?php } ?>
</div>

<?php
require_once VIEWS_PATH . '/partials/footer.php';
