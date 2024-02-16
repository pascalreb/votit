<?php
require_once 'lib/config.php';
require_once 'lib/pdo.php';
require_once 'lib/user.php';

require_once 'templates/header.php';

$errors = [];
$messages = [];
if (isset($_POST['addUser'])) {
    /*
        @todo ajouter la vérification sur les champs
    */
    $res = addUser($pdo, $_POST['email'], $_POST['password'], $_POST['nickname']);
    if ($res) {
        $messages[] = 'Merci pour votre inscription.';
    } else {
        $errors[] = 'Une erreur s\'est produite lors de votre inscription.';
    }
}

?>
<h1>Inscription</h1>

<?php foreach ($messages as $message) { ?>
    <div class="alert alert-success" role="alert">
        <?= $message; ?>
    </div>
<?php } ?>
<?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger" role="alert">
        <?= $error; ?>
    </div>
<?php } ?>
<form method="POST">
    <div class="mb-3">
        <label for="nickname" class="form-label">Surnom</label>
        <input type="text" class="form-control" id="nickname" name="nickname">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <input type="submit" name="addUser" class="btn btn-primary" value="Enregistrer">

</form>

<?php
require_once 'templates/footer.php';
?>