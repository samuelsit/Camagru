<?php
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../includes/header.php');

if (!empty($_GET['key']))
    $key = "?key=".$_GET['key'];
?>

<div class="container-fluid">
    <div class="text-center bg-primary rounded">
        <form action="../back/reinit.php<?= $key ?>" class="p-5" method="POST">
            <div class="bg-dark p-5 mx-auto rounded">
                <h1 class="text-center font-weight-bold">Reinitialisation du mot de passe</h1><br>
                <?php if (empty($_GET['key'])) { ?>
                <input name="pwd-before" type="password" placeholder="Ancien mot de passe" style="border:0;" class="bg-dark text-white rounded text-center font-weight-bold form-control" required><br><br>
                <?php } ?>
                <input name="pwd-after" type="password" placeholder="Nouveau mot de passe" style="border:0;" class="bg-dark text-white rounded text-center font-weight-bold form-control" required><br><br>
                <input name="repwd" type="password" placeholder="Répeter le mot de passe" style="border:0;" class="bg-dark text-white rounded text-center font-weight-bold form-control" required><br><br>
                <button type="submit" class="btn btn-lg btn-rounded btn-primary font-weight-bold">Changer son mot de passe</button><br>
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 1)
                    echo '<br><p class="text-danger font-weight-bold">Veuillez remplir les champs.</p>';
                else if (isset($_GET['error']) && $_GET['error'] == 2)
                    echo '<br><p class="text-danger font-weight-bold">Veuillez entrer des mots de passe identiques.</p>';
                else if (isset($_GET['error']) && $_GET['error'] == 3)
                    echo '<br><p class="text-danger font-weight-bold">Votre mot de passe est incorrect.</p>';
                else if (isset($_GET['error']) && $_GET['error'] == 4)
                    echo '<br><p class="text-danger font-weight-bold">Erreur, la clé n\'existe pas.</p>';
                else if (isset($_GET['error']) && $_GET['error'] == 5)
                    echo '<br><p class="text-danger font-weight-bold">Veuillez entrer un mot de passe correct (minimum: 6 caractères, 1 caractère majuscule, 1 caractère minuscule, 1 chiffre).</p>';
                ?>
                <br>
            </div>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>