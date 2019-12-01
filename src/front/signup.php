<?php
require_once('../../includes/session.php');
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../includes/header.php');
?>

<div class="container-fluid">
    <div class="text-center bg-primary rounded">
        <form action="../back/signup.php" class="p-5" method="POST">
            <div class="bg-dark p-5 mx-auto rounded">
                <h1 class="text-center font-weight-bold">S'inscrire</h1><br>
                <input type="text" name="pseudo" minlength="3" maxlength="16" placeholder="Pseudo" style="border:0;" class="bg-dark text-white form-control mt-1 rounded text-center font-weight-bold" required><br>
                <input type="text" name="nom" maxlength="30" placeholder="Nom" style="border:0;" class="bg-dark text-white rounded text-center font-weight-bold form-control" required><br>
                <input type="text" name="prenom" maxlength="30" placeholder="Prénom" style="border:0;" class="bg-dark text-white form-control mt-1 rounded text-center font-weight-bold" required><br>
                <input type="password" name="passwd" minlength="6" placeholder="Mot de passe" style="border:0;" class="bg-dark text-white form-control mt-1 rounded text-center font-weight-bold" required><br>
                <input type="password" name="repasswd" minlength="6" placeholder="Mot de passe" style="border:0;" class="bg-dark text-white form-control mt-1 rounded text-center font-weight-bold" required><br>
                <input type="text" name="phone" maxlength="20" placeholder="Téléphone" style="border:0;" class="bg-dark text-white form-control mt-1 rounded text-center font-weight-bold" required><br>
                <input type="text" name="mail" maxlength="30" placeholder="E-mail" style="border:0;" class="bg-dark text-white form-control mt-1 rounded text-center font-weight-bold" required><br>
                <button type="submit" class="mt-1 btn btn-lg btn-rounded btn-primary font-weight-bold">S'inscrire</button><br>
                <?php
                    if (isset($_GET['error']) && $_GET['error'] == 1)
                        echo '<br><p class="text-danger font-weight-bold">Certains champs sont manquants.</p>';
                    else if (isset($_GET['error']) && $_GET['error'] == 2)
                        echo '<br><p class="text-danger font-weight-bold">Veuillez entrer des mots de passe identiques.</p>';
                    else if (isset($_GET['error']) && $_GET['error'] == 3)
                        echo '<br><p class="text-danger font-weight-bold">Veuillez réessayer.</p>';
                    else if (isset($_GET['error']) && $_GET['error'] == 4)
                        echo '<br><p class="text-danger font-weight-bold">Veuillez entrer un mot de passe correct (minimum: 6 caractères, 1 caractère majuscule, 1 caractère minuscule, 1 chiffre).</p>';
                ?>
            </div>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>