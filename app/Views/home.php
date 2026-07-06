<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="container py-5">

    <div class="d-flex align-items-center justify-content-between gap-5">

        <div class="w-50">
            <h1 class="display-2 fw-bold text-primary">Faro Animal</h1>
            <h2 class="fw-bold text-secondary mb-4">Cuidando de quem faz parte da família</h2>

            <p class="lead text-secondary mb-4">Um sistema desenvolvido para facilitar o gerenciamento da nossa clínica veterinária, oferecendo praticidade no cadastro de espécies, raças, pets e consultas.</p>

            <a id="" class="btn btn-primary w-25 fw-bold" href="#about" role="button">Saiba mais</a>
        </div>

        <div class="w-50 text-center">
            <img src="<?= base_url('assets/img/pets-hero.webp') ?>" class="img-fluid w-100" alt="5 cachorros e 1 gato">
        </div>

    </div>

    <div class="py-5">

        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">
                Funcionalidades
            </h1>

            <p class="lead text-secondary w-75 mx-auto">
                Gerencie completamente os registros da clínica, desde espécies
                atendidas a agendamentos e controle de consultas.
            </p>
        </div>

        <div class="d-flex justify-content-center gap-4 flex-wrap">

            <div class="card" style="width: 18rem;">
                <img src="<?= base_url('assets/img/new-specie.webp') ?>" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold"><i class="bi bi-diagram-3-fill"></i> Espécies</h5>
                    <p class="card-text text-secondary">Cadastre todas as espécies que a clínica atende.</p>
                    <a href="<?= url_to('species.create') ?>" class="btn btn-primary">Cadastrar</a>
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <img src="<?= base_url('assets/img/new-breed.webp') ?>" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold"><i class="bi bi-tags-fill"></i> Raças</h5>
                    <p class="card-text text-secondary">Organize todas as raças de cada espécie.</p>
                    <a href="<?= url_to('breeds.create') ?>" class="btn btn-primary">Cadastrar</a>
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <img src="<?= base_url('assets/img/new-pet.webp') ?>" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold"><i class="bi bi-heart-fill"></i> Pets</h5>
                    <p class="card-text text-secondary">Mantenha todas as informações dos pacientes.</p>
                    <a href="<?= url_to('pets.create') ?>" class="btn btn-primary">Cadastrar</a>
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <img src="<?= base_url('assets/img/new-appointment.webp') ?>" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold"><i class="bi bi-calendar-fill"></i> Consultas</h5>
                    <p class="card-text text-secondary">Mantenha todas as informações dos pacientes.</p>
                    <a href="<?= url_to('appointments.create') ?>" class="btn btn-primary">Cadastrar</a>
                </div>
            </div>

        </div>


    </div>

    <div class="d-flex align-items-center justify-content-between gap-5 py-5">

        <div class="w-50 text-center">
            <img src="<?= base_url('assets/img/system.png') ?>" class="img-fluid w-100" alt="5 cachorros e 1 gato">
        </div>

        <div class="w-50">
            <h1 id="about" class="display-4 fw-bold text-primary">Sobre o sistema</h1>

            <p class="lead text-secondary mt-4">O Faro Animal é um sistema web desenvolvido para auxiliar o gerenciamento interno de uma clínica veterinária.</p>
            <p class="lead text-secondary">A aplicação permite que veterinários autenticados realizem o cadastro e gerenciamento de animais, organizem consultas veterinárias e mantenham um histórico básico de atendimentos. </p>
            <p class="lead text-secondary">O sistema foi desenvolvido utilizando o framework CodeIgniter 4 e segue a arquitetura MVC (Model-View-Controller), com utilização de Services para centralização das regras de negócio.</p>

        </div>

    </div>

</div>


<?= $this->endSection('content'); ?>