<?php
namespace App\Controllers;

require_once __DIR__ . '/../lib/database.php';
require_once __DIR__ . '/../model/comment.php';

use App\Lib\DatabaseConnection;
use App\Model\CommentRepository;

function addComment($postId)
{
    $postId = (int)$postId;
    if ($postId <= 0) {
        throw new \Exception('Identifiant invalide');
    }

    $author  = isset($_POST['author'])  ? trim($_POST['author'])  : '';
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    if ($author === '' || $comment === '') {
        throw new \Exception('Auteur et commentaire sont requis');
    }

    // ✅ Passer la connexion via le constructeur
    $commentRepo = new CommentRepository(new DatabaseConnection());

    if (!$commentRepo->addComment($postId, $author, $comment)) {
        throw new \Exception("Échec lors de l'ajout du commentaire");
    }

    header('Location: index.php?action=post&id=' . $postId);
    exit;
}