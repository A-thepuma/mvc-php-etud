<?php
// src/model/post.php
require_once __DIR__ . '/../lib/database.php'; // chemin robuste

class Post
{
    public $identifier;
    public $title;
    public $content;
    public $frenchCreationDate;
}

class PostRepository
{

    public $connection;

    public function getPosts()
    {
        $pdo = $this->connection->getConnection();

        $sql = "
        SELECT
            id AS identifier,
            title,
            content,
            DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS frenchCreationDate
        FROM posts
        ORDER BY creation_date DESC
        LIMIT 0, 5
    ";

        $statement = $pdo->query($sql);

        $posts = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $p = new Post();
            $p->identifier = (int) $row['identifier'];
            $p->title = $row['title'];
            $p->content = $row['content'];
            $p->frenchCreationDate = $row['frenchCreationDate'];
            $posts[] = $p;
        }

        return $posts;
    }

    public function getPost($identifier)
    {
        $pdo = $this->connection->getConnection();

        $statement = $pdo->prepare("
            SELECT
                id,
                title,
                content,
                DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS frenchCreationDate
            FROM posts
            WHERE id = ?
        ");
        $statement->execute(array((int) $identifier));
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $post = new Post();
        $post->identifier = (int) $row['id'];
        $post->title = $row['title'];
        $post->content = $row['content'];
        $post->frenchCreationDate = $row['frenchCreationDate'];
        return $post;
    }
}
