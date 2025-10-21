<?php
// src/controllers/post.php
require_once __DIR__ . '/../model.php';

function post($identifier) {
    $id = (int)$identifier;
    if ($id <= 0) {
        throw new Exception('Identifiant invalide');
    }
    $post     = getPost($id);
    $comments = getComments($id);
    require __DIR__ . '/../../templates/post.php';
}