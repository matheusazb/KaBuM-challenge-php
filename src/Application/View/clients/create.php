<?php
require_once VIEWS_PATH . '/partials/header.php';
require_once VIEWS_PATH . '/partials/_header.php';

$isUpdate = $data['client'] ? true : false;
$client = $data['client'];

$name = "";
$birthdate = "";
$phone = "";
$rg = "";
$cpf = "";

if (!is_null($client)) {
  $name = $client["name"];
  $birthdate = $client["birthdate"];
  $phone = $client["phone"];
  $rg = $client["rg"];
  $cpf = $client["cpf"];

  $birthDateSplitted = explode("-", $birthdate);
  $birthdate = sprintf("%s/%s/%s", $birthDateSplitted[2], $birthDateSplitted[1], $birthDateSplitted[0]);
  $phone = str_replace("-", "", $phone);
}

?>

<div class="o-container">
  <div class="u-mb-24 u-db u-flex@sm u-items-center">
    <a href="<?= BASEURL_CLIENT_LIST ?>" class="c-button c-button--secondary-gray u-td-none u-fs-12">
      <span class="lni lni-chevron-left"></span>
      <span class="u-dn@sm">Voltar</span>
    </a>
    <h2 class="u-fs-24 u-mt-12 u-mt-0@sm u-ml-12@sm u-ml-0"><?= $isUpdate ? 'Atualizar cliente' : 'Adicionar novo cliente' ?></h2>
  </div>

  <form action="<?= $isUpdate ? sprintf(ENDPOINT_CLIENT_UPDATE, $client['client_id']) : ENDPOINT_CLIENT_CREATE ?>" method="POST" class="js-form">
    <?php if ($isUpdate) {
    ?>
      <input type="hidden" value="<?= $client["client_id"] ?>" name="id">
    <?php
    } ?>
    <input type="hidden" value="" name="addressList" id="addressList">

    <div class="o-row">
      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input type="text" maxlength="80" value="<?= $name ?>" id="name" name="name" class="c-textfield__input js-float-input" required>
            <label for="name" class="c-textfield__label">Nome</label>
          </div>
        </div>
      </div>

      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input type="text" value="<?= $birthdate ?>" id="birthdate" name="birthdate" class="c-textfield__input js-float-input" data-mask-birthdate required>
            <label for="birthdate" class="c-textfield__label">Data de nascimento</label>
          </div>
        </div>
      </div>
    </div>

    <div class="o-row">
      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input type="text" value="<?= $phone ?>" id="phone" name="phone" class="c-textfield__input js-float-input" data-mask-phone required>
            <label for="phone" class="c-textfield__label">Telefone de contato</label>
          </div>
        </div>
      </div>

      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input type="text" maxlength="12" value="<?= $rg ?>" id="rg" name="rg" class="c-textfield__input js-float-input" required>
            <label for="rg" class="c-textfield__label">RG</label>
          </div>
        </div>
      </div>
    </div>

    <div class="o-row">
      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input type="text" value="<?= $cpf ?>" id="cpf" name="cpf" class="c-textfield__input js-float-input" data-mask-cpf required>
            <label for="cpf" class="c-textfield__label">CPF</label>
          </div>
        </div>
      </div>
    </div>

    <div class="o-row u-mt-32">
      <div class="o-column o-column-4@sm">
        <button type="submit" class="c-button c-button--primary u-w-100 js-submit"><?= $isUpdate ? "Atualizar" : "Cadastrar" ?></button>
      </div>
    </div>
  </form>
</div>

<?php
require_once VIEWS_PATH . '/partials/footer.php';
