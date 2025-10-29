<?php
// index.php
require_once __DIR__ . '/src/controllers/edit_comment.php';
require_once __DIR__ . '/src/controllers/update_comment.php';

require_once __DIR__ . '/src/lib/database.php';
require_once __DIR__ . '/src/controllers/add_comment.php';
require_once __DIR__ . '/src/controllers/homepage.php';
require_once __DIR__ . '/src/controllers/post.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
});

$action = isset($_GET['action']) ? $_GET['action'] : 'listPosts';

try {
    if ($action === 'listPosts') {
        \App\Controllers\homepage();

    } elseif ($action === 'post') {
        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            throw new Exception('Identifiant de billet manquant');
        }
        \App\Controllers\post($_GET['id']);

    } elseif ($action === 'addComment') {
        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            throw new Exception('Identifiant de billet manquant');
        }
        if (empty($_POST['author']) || empty($_POST['comment'])) {
            throw new Exception('Tous les champs sont obligatoires');
        }
        \App\Controllers\addComment($_GET['id']);
    } elseif ($action === 'editComment') {
        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            throw new Exception('Identifiant de commentaire manquant');
        }
        \App\Controllers\editComment($_GET['id']);

    } elseif ($action === 'updateComment') {
        if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
            throw new Exception('Identifiant de commentaire invalide');
        }
        if (empty($_POST['author']) || empty($_POST['comment']) || empty($_POST['post_id']) || !ctype_digit($_POST['post_id'])) {
            throw new Exception('Champs obligatoires manquants');
        }
        \App\Controllers\updateComment();
    } else {
        throw new Exception("Erreur 404 : la page que vous recherchez n'existe pas.");
    }

} catch (Throwable $e) { // accepte Exception + Error
    if (!headers_sent()) {
        header('HTTP/1.1 500 Internal Server Error');
    }
    $errorMessage = $e->getMessage();
    $errorMessage .= ' [' . $e->getFile() . ':' . $e->getLine() . "]\n";
    $errorMessage .= $e->getTraceAsString();
    require __DIR__ . '/templates/error.php';
}