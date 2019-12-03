<?php
require_once('../../includes/session.php');
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../includes/header.php');
if (isset($_GET['user'])) {
    $user = $_GET['user'];
    $focus = 'autofocus';
}
else {
    $user = NULL;
    $focus = NULL;
}
?>

<div class="container-fluid">
    <div class="text-center bg-primary rounded">
        <form action="../back/login.php" class="p-5" method="POST">
            <div class="bg-dark p-5 mx-auto rounded">
                <h1 class="text-center font-weight-bold">Se connecter</h1><br>
                <input type="text" name="login" placeholder="Utilisateur" style="border:0;" value="<?= $user ?>" class="bg-dark text-white rounded text-center font-weight-bold form-control" required><br><br>
                <input type="password" name="passwd" placeholder="Mot de passe" style="border:0;" class="bg-dark text-white rounded text-center font-weight-bold form-control" required <?= $focus ?>><br><br>
                <button type="submit" class="btn btn-lg btn-rounded btn-primary font-weight-bold">Se connecter</button><br>
                <?php
                    if (isset($_GET['success']) && $_GET['success'] == 1)
                        echo '<br><p class="text-success font-weight-bold">Votre mot de passe à bien été modifié.</p>';
                    if (isset($_GET['mail']) && $_GET['mail'] != 1 && $_GET['mail'] != 2)
                        echo '<br><p class="text-success font-weight-bold">Un e-mail à été envoyé a l\'adresse suivante: '.$_GET['mail'].'.</p>';
                    if (isset($_GET['mail']) && $_GET['mail'] == 1)
                        echo '<br><p class="text-success font-weight-bold">Votre compte à bien été activé.</p>';
                    if (isset($_GET['mail']) && $_GET['mail'] == 2)
                        echo '<br><p class="text-danger font-weight-bold">Erreur lors de l\'envoi de l\'e-mail.</p>';
                    if (isset($_GET['error']) && $_GET['error'] == 1)
                        echo '<br><p class="text-danger font-weight-bold">Le login ou le mot de passe est incorrect.</p>';
                    else if (isset($_GET['error']) && $_GET['error'] == 2)
                        echo '<br><p class="text-danger font-weight-bold">Veuillez remplir les champs.</p>';
                    else if (isset($_GET['error']) && $_GET['error'] == 3)
                        echo '<br><p class="text-danger font-weight-bold">Veuillez activer votre compte via l\'e-mail qui vous a été envoyé.</p>';
                    else if (isset($_GET['error']) && $_GET['error'] == 4)
                        echo '<br><p class="text-danger font-weight-bold">Votre compte est déjà actif.</p>';
                    else if (isset($_GET['error']) && $_GET['error'] == 5)
                        echo '<br><p class="text-danger font-weight-bold">Veuillez vous identifier pour accéder à cette page.</p>';
                ?>
                <br>
                <a href="signup.php" class="btn btn-sm btn-rounded btn-primary font-weight-bold">S'inscrire</a><br>
                <a href="forget.php" class="mt-1 btn btn-sm btn-rounded btn-primary font-weight-bold">Mot de passe oublié ?</a>
            </div>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>