<?php
// src/controllers/homepage.php
require_once __DIR__ . '/../model/post.php';
function homepage()
{
    $posts = getPosts();
    require('templates/homepage.php');
}