<?php
namespace App\Controllers;

require_once __DIR__ . '/../lib/database.php';
require_once __DIR__ . '/../model/post.php';

use App\Lib\DatabaseConnection;
use App\Model\PostRepository;

function homepage()
{
    $postRepository = new PostRepository(new DatabaseConnection());

    $posts = $postRepository->getPosts();

    require __DIR__ . '/../../templates/homepage.php';
}