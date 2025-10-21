<?php


function db()
{
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=127.0.0.1;port=3307;dbname=blog',
                'root',
                'root',
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                )
            );

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    return $pdo;
}
function getPosts()
{
    $bdd = db();
    $sql = "SELECT id, title, content,
                   DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date
            FROM posts
            ORDER BY creation_date DESC
            LIMIT 0, 5";
    $statement = $bdd->query($sql);

    $posts = array();
    while ($row = $statement->fetch()) {
        $posts[] = array(
            'id' => (int) $row['id'],
            'title' => $row['title'],
            'french_creation_date' => $row['french_creation_date'],
            'content' => $row['content'],
        );
    }
    return $posts;
}


function getPost($id)
{
    $id = (int) $id;
    $bdd = db();
    $sql = "SELECT id, title, content,
                   DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date
            FROM posts
            WHERE id = ?";
    $st = $bdd->prepare($sql);
    $st->execute([$id]);
   

    $row = $st->fetch();
    if (!$row) {
        throw new Exception('Billet introuvable');
    }

    $post = [
        'identifier' => $row['id'],
        'title' => $row['title'],
        'french_creation_date' => $row['french_creation_date'],
        'content' => $row['content'],
    ];
    return $post;
}


