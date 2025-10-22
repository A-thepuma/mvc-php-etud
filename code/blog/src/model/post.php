<?php
// src/model/post.php

class Post
{
    public $identifier;         
    public $title;
    public $content;
    public $frenchCreationDate;
}

function getPosts()
{
 
    $db = commentDbConnect();

    $sql = "
        SELECT
            id AS identifier,
            title,
            content,
            DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS frenchCreationDate
        FROM posts
        ORDER BY creation_date DESC
    ";
    $st = $db->query($sql);

    $posts = [];
    while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
        $p = new Post();
        $p->identifier         = (int)$row['identifier'];
        $p->title              = $row['title'];
        $p->content            = $row['content'];
        $p->frenchCreationDate = $row['frenchCreationDate'];
        $posts[] = $p;
    }
    return $posts;
}

function getPost($id)
{
    $db = commentDbConnect();
    $st = $db->prepare("
        SELECT
            id AS identifier,
            title,
            content,
            DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS frenchCreationDate
        FROM posts
        WHERE id = ?
    ");
    $st->execute([$id]);
    $row = $st->fetch(PDO::FETCH_ASSOC);

    if (!$row) return null;

    $p = new Post();
    $p->identifier         = (int)$row['identifier'];
    $p->title              = $row['title'];
    $p->content            = $row['content'];
    $p->frenchCreationDate = $row['frenchCreationDate'];
    return $p;
}
