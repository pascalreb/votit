<?php
require_once 'lib/required_files.php';

require_once 'lib/user.php';

require_once 'templates/header.php';

$errors = [];

const CSRF_SESSION_KEY = 'csrf_token';

function generateTokenCSRF() {
    $token = hash('sha256', random_bytes(32)); // Génération d'un jeton aléatoire
    $_SESSION[CSRF_SESSION_KEY] = $token; // Stockage dans la session
    return $token;
}

function verifyTokenCSRF($token) {
    return isset($_SESSION[CSRF_SESSION_KEY]) && hash_equals($_SESSION[CSRF_SESSION_KEY], $token);
}

if (isset($_POST['loginUser'])) {
    
    $user = verifyUserLoginAndPassword($pdo, $_POST['email'], $_POST['password']);
    $tokenPost = $_POST[CSRF_SESSION_KEY];

    if ($user && verifyTokenCSRF($tokenPost)) {
        // on veut connecter l'utilisateur
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        unset($_SESSION[CSRF_SESSION_KEY]); // Supprime le token CSRF après utilisation
        header('location: index.php');
    } else {
        // erreur
        $errors[] = 'Email ou mot de passe incorrect';
    }
}

?>

<h1>Connexion</h1>

<?php foreach($errors as $error) { ?>
    <div class="alert alert-danger" role="alert">
        <?=$error; ?>
    </div>
<?php } 

$tokenCSRF = generateTokenCSRF();

?>

<form method="POST">
    <div class="mb-3">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <input type="hidden" name="csrf_token" value="<?php echo $tokenCSRF; ?>">

        <input type="submit" name="loginUser" class="btn btn-primary" value="Enregistrer">

</form>


<?php require_once 'templates/footer.php'; ?>