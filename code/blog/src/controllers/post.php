<?php
require_once __DIR__ . '/../model/post.php';
require_once __DIR__ . '/../model/comment.php';

function post($identifier)
{
    $id = (int)$identifier;
    if ($id <= 0) {
        throw new Exception('Identifiant invalide');
    }

    $db = new DatabaseConnection();

    $postRepo = new PostRepository();
    $postRepo->connection = $db;

    $commentRepo = new CommentRepository();
    $commentRepo->connection = $db;

    $post = $postRepo->getPost($id);
    if ($post === null) {
        throw new Exception('Billet introuvable');
    }

    $comments = $commentRepo->getComments($id);

    require __DIR__ . '/../../templates/post.php';
}
