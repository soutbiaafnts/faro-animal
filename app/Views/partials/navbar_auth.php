<nav class="navbar bg-body-tertiary">
    <div class="container justify-content-between">
        <a class="navbar-brand" href="<?= url_to('home') ?>">
            <img src="<?= base_url('assets/logo_total.png') ?>" alt="Bootstrap" height="30">
        </a>
        
        <div class="navbar-nav d-flex flex-row gap-4">
            <a class="nav-link active" aria-current="page" href="<?= url_to('home') ?>">Início</a>
            <a class="nav-link" href="<?= url_to('dashboard') ?>">Painel</a>
            <a class="nav-link" href="#">Pets</a>
            <a class="nav-link">Consultas</a>
        </div>

        <ul class="nav justify-content-end gap-2 align-items-center">
            <li class="nav-item">
                <form action="<?= url_to('me') ?>" class="d-flex">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Perfil</button>
                </form>
            </li>
            <li class="nav-item">
                <form action="<?= url_to('logout') ?>" class="d-flex">
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>