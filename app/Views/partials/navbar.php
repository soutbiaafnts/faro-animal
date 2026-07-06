<?php $logged = session()->has('user_id'); ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container justify-content-between">
        <a class="navbar-brand" href="<?= url_to('home') ?>">
            <img src="<?= base_url('assets/logo_total.png') ?>" alt="Bootstrap" height="30">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= url_to('home') ?>">Início</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Espécies
                    </a>
                    <ul class="dropdown-menu ">
                        <li><a class="dropdown-item" href="<?= url_to('species') ?>">Listar todas</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= url_to('species.create') ?>">Nova espécie</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Raças
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?= url_to('breeds') ?>">Listar todas</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= url_to('breeds.create') ?>">Nova raça</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Pets
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= url_to('pets') ?>">Listar todos</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= url_to('pets.create') ?>">Novo pet</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Consultas
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= url_to('appointments') ?>">Listar todas</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= url_to('appointments.create') ?>">Nova consulta</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav justify-content-end gap-2 align-items-center">

                <?php if ($logged): ?>

                    <li class="nav-item">
                        <form action="<?= url_to('me') ?>" class="d-flex">
                            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-person-circle"></i></button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <form action="<?= url_to('logout') ?>" class="d-flex">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-escape"></i></button>
                        </form>
                    </li>

                <?php else: ?>

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

                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>