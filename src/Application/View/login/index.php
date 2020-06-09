<?php
require_once VIEWS_PATH . '/partials/header.php';
?>

<div class="o-container">
  <div class="o-row u-vh-100 u-items-center">
    <div class="o-column o-column-6@sm o-column-5@md">
      <section class="c-login">
        <h1 class="u-fs-24 u-mb-32">Painel Administrativo</h1>
        <form action="<?= ENDPOINT_AUTH ?>" method="POST">
          <div class="c-textfield js-float-field">
            <div class="c-textfield u-mb-24">
              <input type="text" value="" id="username" name="username" class="c-textfield__input js-float-input" required>
              <label for="username" class="c-textfield__label">Usuário</label>
            </div>
          </div>
          <div class="c-textfield js-float-field">
            <div class="c-textfield u-mb-24">
              <input type="password" value="<?= $cpf ?>" id="password" name="password" class="c-textfield__input js-float-input" required>
              <label for="password" class="c-textfield__label">Senha</label>
            </div>
          </div>

          <div class="">
            <button type="submit" class="c-button c-button--primary u-w-100 js-submit">Acessar painel</button>
          </div>
        </form>
      </section>
    </div>
    <div class="o-column o-column-6@sm o-column-7@md u-dn u-flex@sm u-login-background u-vh-100 u-items-center">
      <!-- CONTEUDO AQUI -->
    </div>
  </div>
</div>

<?php
require_once VIEWS_PATH . '/partials/footer.php';
