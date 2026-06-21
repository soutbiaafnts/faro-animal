<nav class="navbar bg-body-tertiary">
    <div class="container justify-content-between">
        <a class="navbar-brand" href="<?= url_to('home') ?>">
            <img src="<?= base_url('assets/logo_total.png') ?>" alt="Bootstrap" height="30">
        </a>
        
        <ul class="nav justify-content-end gap-2 align-items-center">
            <li class="nav-item">
                <form action="#" class="d-flex">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Cadastrar</button>
                </form>
            </li>
            <li class="nav-item">
                <form action="<?= url_to('login') ?>" class="d-flex">
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </li>
        </ul>
    </div>
</nav>