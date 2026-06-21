<nav class="navbar bg-body-tertiary fixed-top">
    <div class="container justify-content-between">
        <a class="navbar-brand" href="<?= url_to('home') ?>">
            <img src="<?= base_url('assets/logo_total.png') ?>" alt="Bootstrap" height="30">
        </a>

        <div class="navbar-nav d-flex flex-row gap-4">
            <a class="nav-link active" aria-current="page" href="<?= url_to('home') ?>">Início</a>
            <a class="nav-link disabled" aria-disabled="true" href="<?= url_to('dashboard') ?>">Painel</a>
            <a class="nav-link disabled" aria-disabled="true" href="#">Pets</a>
            <a class="nav-link disabled" aria-disabled="true">Consultas</a>
        </div>

        <ul class="nav justify-content-end gap-2 align-items-center">
            <li class="nav-item">
                <form action="<?= url_to('register') ?>" class="d-flex">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Cadastre-se</button>
                </form>
            </li>
            <li class="nav-item">
                <form action="<?= url_to('login') ?>" class="d-flex">
                    <button type="submit" class="btn btn-primary btn-sm px-3">Entrar</button>
                </form>
            </li>
        </ul>
    </div>
</nav>