<?php
namespace App\Model;

use App\Lib\DatabaseConnection;
use PDO;

class Post
{
    public $identifier;
    public $title;
    public $content;
    public $frenchCreationDate;
}

class PostRepository
{
    private $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    /** @return Post[] */
    public function getPosts()
    {
        $pdo = $this->connection->getConnection();
        $stmt = $pdo->query("
            SELECT
              id AS identifier,
              title,
              content,
              DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS frenchCreationDate
            FROM posts
            ORDER BY creation_date DESC
            LIMIT 0,5
        ");

        $posts = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $p = new Post();
            $p->identifier         = (int)$row['identifier'];
            $p->title              = $row['title'];
            $p->content            = $row['content'];
            $p->frenchCreationDate = $row['frenchCreationDate'];
            $posts[] = $p;
        }
        return $posts;
    }

    /** @return Post|null */
    public function getPost($id)
    {
        $pdo = $this->connection->getConnection();
        $stmt = $pdo->prepare("
            SELECT
              id AS identifier,
              title,
              content,
              DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS frenchCreationDate
            FROM posts
            WHERE id = ?
            LIMIT 1
        ");
        $stmt->execute(array((int)$id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        $p = new Post();
        $p->identifier         = (int)$row['identifier'];
        $p->title              = $row['title'];
        $p->content            = $row['content'];
        $p->frenchCreationDate = $row['frenchCreationDate'];
        return $p;
    }
}
