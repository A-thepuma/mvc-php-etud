<?php
// src/controllers/post.php
require_once('src/model.php');
require_once('src/model/comment.php');


function post($identifier)
{
    $id = (int)$identifier;
    if ($id <= 0) {
        throw new Exception('Identifiant invalide');
    }

    $post     = getPost($id);
    $comments = getComments($id);

    require __DIR__ . '/../../templates/post.php';
}