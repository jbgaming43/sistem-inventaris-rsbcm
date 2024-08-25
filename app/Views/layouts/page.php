<?= $this->include('layouts/header') ?>
<div class="page">

    <?= $this->include('layouts/menubar') ?>

    <div class="page-wrapper">

        <?= $this->renderSection('content') ?>


        <?= $this->include('layouts/footer_page') ?>

    </div>
</div>

<?= $this->include('layouts/footer') ?>