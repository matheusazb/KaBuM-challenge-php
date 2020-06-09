<?php
require_once VIEWS_PATH . '/partials/header.php';
require_once VIEWS_PATH . '/partials/_header.php';

$isUpdate = $data['address'] ? true : false;
$address = $data['address'];

$cep = "";
$street = "";
$number = "";
$complement = "";
$neighborhood = "";
$city = "";
$state = "";

if (!is_null($address)) {
  $cep = $address["cep"];
  $street = $address["street"];
  $number = $address["number"];
  $complement = $address["complement"];
  $neighborhood = $address["neighborhood"];
  $city = $address["city"];
  $state = $address["state"];
}

?>

<div class="o-container">
  <div class="u-mb-24 u-db u-flex@sm u-items-center">
    <a href="<?= sprintf(BASEURL_CLIENT_ADDRESS_LIST, $data['client']['client_id']) ?>" class="c-button c-button--secondary-gray u-td-none u-fs-12">
      <span class="lni lni-chevron-left"></span>
      <span class="u-dn@sm">Voltar</span>
    </a>
    <div class="u-justify-between u-ml-0 u-ml-12@sm u-db u-fs-14 u-dn u-mb-24 u-mb-0@sm u-flex-column">
      <h2 class="u-fs-24 u-mb-0@sm"><?= $isUpdate ? 'Atualizar endereço' : 'Adicionar novo endereço' ?></h2>
      <span class="c-badge c-badge--blue">Cliente:</span> <span><?= $data['client']['name'] ?></span>
    </div>
  </div>

  <form action="<?= $isUpdate ? sprintf(ENDPOINT_ADDRESS_UPDATE, $address['address_id']) : ENDPOINT_ADDRESS_CREATE ?>" method="POST" class="js-form">
    <input type="hidden" value="<?= $data['client']['client_id'] ?>" name="client_id">

    <div class="o-row">
      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input required type="text" value="<?= $cep ?>" id="cep" name="cep" class="c-textfield__input js-float-input" data-mask-cep data-cep-field>
            <label for="cep" class="c-textfield__label">CEP</label>
          </div>
        </div>
      </div>


      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input required type="text" maxlength="128" value="<?= $street ?>" id="street" name="street" class="c-textfield__input js-float-input">
            <label for="street" class="c-textfield__label">Rua</label>
          </div>
        </div>
      </div>

      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input required type="text" maxlength="6" value="<?= $number ?>" id="number" name="number" class="c-textfield__input js-float-input">
            <label for="number" class="c-textfield__label">Número</label>
          </div>
        </div>
      </div>


      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input type="text" maxlength="32" value="<?= $complement ?>" id="complement" name="complement" class="c-textfield__input js-float-input">
            <label for="complement" class="c-textfield__label">Complemento</label>
          </div>
        </div>
      </div>


      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input required type="text" maxlength="64" value="<?= $neighborhood ?>" id="neighborhood" name="neighborhood" class="c-textfield__input js-float-input">
            <label for="neighborhood" class="c-textfield__label">Bairro</label>
          </div>
        </div>
      </div>


      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input required type="text" maxlength="64" value="<?= $city ?>" id="city" name="city" class="c-textfield__input js-float-input">
            <label for="city" class="c-textfield__label">Cidade</label>
          </div>
        </div>
      </div>

      <div class="o-column o-column-6@sm o-column-6@md">
        <div class="c-textfield js-float-field">
          <div class="c-textfield u-mb-24">
            <input required type="text" maxlength="2" value="<?= $state ?>" id="state" name="state" class="c-textfield__input js-float-input">
            <label for="state" class="c-textfield__label">Estado</label>
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
