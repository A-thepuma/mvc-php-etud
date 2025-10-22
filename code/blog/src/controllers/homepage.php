<?php
// src/controllers/homepage.php
require_once __DIR__ . '/../model/post.php';
function homepage()
{
    $postRepository = new PostRepository();
    $posts = $postRepository->getPosts();
    require('templates/homepage.php');
}