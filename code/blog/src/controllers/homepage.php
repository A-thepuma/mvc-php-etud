<?php
namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Model\PostRepository;


function homepage()
{
    $repo = new PostRepository(new DatabaseConnection());
    $posts = $repo->getPosts();
    require 'templates/homepage.php';
}