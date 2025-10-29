<?php
namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Model\CommentRepository;

// ajoute ces require_once si tu n'as pas d'autoloader (sinon, supprime-les)
require_once __DIR__ . '/../lib/database.php';
require_once __DIR__ . '/../model/comment.php';

function updateComment()
{
    if (!isset($_POST['id'], $_POST['author'], $_POST['comment'])) {
        throw new \Exception('Champs requis manquants');
    }

    $id      = (int)$_POST['id'];
    $author  = trim($_POST['author']);
    $content = trim($_POST['comment']);

    if ($id <= 0 || $author === '' || $content === '') {
        throw new \Exception('Identifiant/auteur/contenu invalides');
    }

    $repo = new CommentRepository(new DatabaseConnection());
    $c = $repo->getComment($id);
    if ($c === null) {
        throw new \Exception('Commentaire introuvable');
    }

    if (!$repo->updateComment($id, $author, $content)) {
        throw new \Exception('Échec de la mise à jour du commentaire');
    }

    // Retour au billet d’origine
    header('Location: index.php?action=post&id=' . (int)$c->postId);
    exit;
}
