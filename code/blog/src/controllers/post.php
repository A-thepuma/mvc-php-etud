<?php
// src/controllers/post.php
namespace App\Controllers;

require_once __DIR__ . '/../lib/database.php';
require_once __DIR__ . '/../model/post.php';
require_once __DIR__ . '/../model/comment.php';

use App\Lib\DatabaseConnection;
use App\Model\PostRepository;
use App\Model\CommentRepository;

function post($identifier)
{
    $id = (int) $identifier;
    if ($id <= 0) {
        throw new \Exception('Identifiant invalide');
    }

    $db = new DatabaseConnection();

    $postRepo = new PostRepository($db);
    $commentRepo = new CommentRepository($db);

    $post = $postRepo->getPost($id);
    if ($post === null) {
        throw new \Exception('Billet introuvable');
    }

    $comments = $commentRepo->getComments($id);

    require __DIR__ . '/../../templates/post.php';
}

