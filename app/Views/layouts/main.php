<!doctype html>
<html lang="pt-br" data-bs-theme="light">
    <head>
        <title><?= $title ?? 'Faro Animal' ?></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.css">
    </head>

    <body class="d-flex flex-column min-vh-100">
        <header>
            <?= $this->include('partials/navbar'); ?>
        </header>

        <main class="flex-grow-1 d-flex flex-column justify-content-center pt-2">
            <?= $this->renderSection('content'); ?>
        </main>

        <footer>
            <?= $this->include('partials/footer'); ?>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/locale/bootstrap-table-pt-BR.min.js"></script>
    </body>
</html>
