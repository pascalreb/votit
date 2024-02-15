<?php 
require_once 'lib/required_files.php';
require_once 'lib/poll.php';

$polls = getPolls($pdo);

require_once 'templates/header.php';
?>

<h1>Les sondages</h1>

    <a href="ajout_modification_sondage.php" class="btn btn-primary mt-3 mb-3">Créer un sondage</a>

<div class="row text-center">
    <?php foreach($polls as $poll) { 
        require 'templates/poll_part.php';
    } ?>
</div>


<?php require_once 'templates/footer.php'; ?>