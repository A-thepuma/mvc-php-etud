<?php
// src/model/comment.php


class Comment {
    public $author;
    public $frenchCreationDate;
    public $comment;
}
function commentDbConnect() {
    try {
        $db = new PDO(
            'mysql:host=127.0.0.1;port=3307;dbname=blog;charset=utf8',
            'root',
            'root',
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            )
        );
        return $db;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function getComments($postId) {
    $db = commentDbConnect();
    $st = $db->prepare(
        "SELECT id, author, comment,
                DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date
         FROM comments
         WHERE post_id = ?
         ORDER BY comment_date DESC"
    );

    $st->execute([$postId]);

    $comments = [];

    while ($row = $st -> fetch(PDO::FETCH_ASSOC)) {
        $c = new Comment();
        $c->author             = $row['author'];
        $c->comment            = $row['comment'];
        $c->frenchCreationDate = $row['frenchCreationDate'];
        $comments[] = $c;
    }
    return $comments;
}

function createComment($postId, $author, $comment) {
    $db = commentDbConnect();
    $st = $db->prepare(
        "INSERT INTO comments(post_id, author, comment, comment_date)
         VALUES(?, ?, ?, NOW())"
    );
    return $st->execute(array((int)$postId, $author, $comment)) > 0;
}
