<?php
require_once('session.php');
require_once('dbconnect.php');

if (!isset($_SESSION['cardio_userid'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['cardio_userid'];

$stmt = $db->prepare("SELECT * FROM registo WHERE registo_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "Utilizador não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('head.php'); ?>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <?php require_once('top_menu.php'); ?>
    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <?php require_once('dashboard.php'); ?>
    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <section class="section profile">
            <div class="row">
                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Visão Geral</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Perfil</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Detalhes do Perfil</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Nome Completo</div>
                                        <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['nome']) ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Idade</div>
                                        <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['idade']) ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Instituição</div>
                                        <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['instituicao']) ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Telefone</div>
                                        <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['telefone']) ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['email']) ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Categoria</div>
                                        <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['categoria']) ?></div>
                                    </div>

                                    <?php if (!empty($user['especialidade_especialista'])) : ?>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Especialidade (Especialista)</div>
                                            <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['especialidade_especialista']) ?></div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($user['especialidade_residente'])) : ?>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Especialidade (Residente)</div>
                                            <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['especialidade_residente']) ?></div>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form action="editar_perfil.php" method="POST">
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nome Completo</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nome" type="text" class="form-control" id="fullName" value="<?= htmlspecialchars($user['nome']) ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="idade" class="col-md-4 col-lg-3 col-form-label">Idade</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="idade" type="text" class="form-control" id="idade" value="<?= htmlspecialchars($user['idade']) ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="instituicao" class="col-md-4 col-lg-3 col-form-label">Instituição</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="instituicao" type="text" class="form-control" id="instituicao" value="<?= htmlspecialchars($user['instituicao']) ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="telefone" class="col-md-4 col-lg-3 col-form-label">Telefone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="telefone" type="text" class="form-control" id="telefone" value="<?= htmlspecialchars($user['telefone']) ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="Email" value="<?= htmlspecialchars($user['email']) ?>">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->

                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <?php require_once('footer.php'); ?>
    </footer><!-- End Footer -->

</body>

</html>
