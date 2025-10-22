<?php
// src/controllers/add_comment.php
require_once __DIR__ . '/../model/comment.php';

function addComment($postId)
{
    $postId = (int)$postId;
    if ($postId <= 0) {
        throw new Exception('Identifiant invalide');
    }

    // Récupère et nettoie les champs sans utiliser ?? (compat PHP < 7)
    $author  = isset($_POST['author'])  ? trim($_POST['author'])  : '';
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    if ($author === '' || $comment === '') {
        throw new Exception('Auteur et commentaire sont requis');
    }

    // Une seule connexion partagée via DatabaseConnection
    $db = new DatabaseConnection();
    $commentRepo = new CommentRepository();
    $commentRepo->connection = $db;

    if (!$commentRepo->addComment($postId, $author, $comment)) {
        throw new Exception("Échec lors de l'ajout du commentaire");
    }

    // Redirection vers le billet
    header('Location: index.php?action=post&id=' . $postId);
    exit;
}
