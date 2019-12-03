<?php
$title = ucfirst(substr(basename(__FILE__), 0, -4));
require_once('../../includes/header.php');
?>

<div class="container-fluid">
    <div class="text-center bg-primary rounded">
        <form action="../back/forget.php" class="p-5" method="POST">
            <div class="bg-dark p-5 mx-auto rounded">
                <h1 class="text-center font-weight-bold">E-mail pour la reinitialisation du mot de passe</h1><br>
                <input name="email" type="text" placeholder="Votre e-mail" style="border:0;" class="bg-dark text-white rounded text-center font-weight-bold form-control" required><br><br>
                <button type="submit" class="btn btn-lg btn-rounded btn-primary font-weight-bold">Recevoir un e-mail</button><br>
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 1)
                    echo '<br><p class="text-danger font-weight-bold">Veuillez remplir le champ e-mail.</p>';
                else if (isset($_GET['error']) && $_GET['error'] == 2)
                    echo '<br><p class="text-danger font-weight-bold">L\'e-mail renseigné n\'existe pas dans la base de données.</p>';
                ?>
                <br>
            </div>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>