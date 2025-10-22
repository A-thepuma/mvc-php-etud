<?php
// index.php
require_once('src/controllers/add_comment.php');
require_once('src/controllers/homepage.php');
require_once('src/controllers/post.php');
require_once __DIR__ . '/src/model/comment.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'listPosts';

try {
    if ($action === 'listPosts') {
        homepage();

    } elseif ($action === 'post') {
        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            throw new Exception('Identifiant de billet manquant');
        }
        post($_GET['id']);

    } elseif ($action === 'addComment') {
        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            throw new Exception('Identifiant de billet manquant');
        }
        if (empty($_POST['author']) || empty($_POST['comment'])) {
            throw new Exception('Tous les champs sont obligatoires');
        }
       addComment($_GET['id']);

    } else {
        throw new Exception("Erreur 404 : la page que vous recherchez n'existe pas.");
    }

} catch (Exception $e) {
    if (!headers_sent()) {
        header('HTTP/1.1 500 Internal Server Error');
    }
    $errorMessage = $e->getMessage();
    require __DIR__ . '/templates/error.php';
}
