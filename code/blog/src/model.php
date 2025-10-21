<?php


function db() {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=127.0.0.1;port=3307;dbname=blog',
            'root',
            'root',
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            )
        );
    }
    return $pdo;
}

function getPosts()
{
    try {
        $bdd = new PDO(
            'mysql:host=127.0.0.1;port=3307;dbname=blog', 
            'root',
            'root',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    $statement = $bdd->query(
        "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 5"
    );
    $posts = [];
    while (($row = $statement->fetch())) {
        $post = [
            'title' => $row['title'],
            'french_creation_date' => $row['french_creation_date'],
            'content' => $row['content'],
            'identifier' => $row["id"],
        ];

        $posts[] = $post;
    }

    return $posts;
}

function getPost($id)
{
    $id = (int)$id;
    $bdd = db();
    $sql = "SELECT id, title, content,
                   DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date
            FROM posts
            WHERE id = ?";
    $st = $bdd->prepare($sql);
    $st->execute([$id]);
    $post = $st->fetch();
    if (!$post) {
        throw new Exception('Billet introuvable');
    }
    return $post;
}

function getComments($postId)
{
    $postId = (int)$postId;
    $bdd = db();
    $sql = "SELECT author,
                   comment,
                   DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date
            FROM comments
            WHERE post_id = ?
            ORDER BY comment_date ASC";
    $st = $bdd->prepare($sql);
    $st->execute(array($postId)); 
    return $st->fetchAll();
}

