<?php
// src/controllers/add_comment.php
require_once('src/model/comment.php');

function addComment($identifier, $author, $comment)
{
    $postId = (int) $identifier;
    if ($postId <= 0) {
        throw new Exception('Identifiant de billet invalide');
    }
    if (!createComment($postId, $author, $comment)) {
        throw new Exception("Impossible d'ajouter le commentaire.");
    }
    
    header('Location: index.php?action=post&id=' . $postId);
    exit;
}