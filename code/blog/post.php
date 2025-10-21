<?php
// post.php (contrôleur)
require __DIR__ . '/src/model.php';

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $identifier = (int) $_GET['id'];
} else {
    echo 'Erreur : aucun identifiant de billet envoyé';
    exit;
}

$post     = getPost($identifier);
$comments = getComments($identifier);

require __DIR__ . '/templates/post.php';