<?php
namespace App\Model;

use App\Lib\DatabaseConnection;
use PDO;

class Comment
{
    public $id;
    public $postId;
    public $author;
    public $comment;
    public $frenchCreationDate;
}

class CommentRepository
{
    private $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }
    
    /**
     * @param int $postId
     * @return Comment[]
     */
    public function getComments($postId)
    {
        $pdo = $this->connection->getConnection();

        $stmt = $pdo->prepare("
            SELECT
                id,
                post_id,                                  
                author,
                comment,
                DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS frenchCreationDate
            FROM comments
            WHERE post_id = ?
            ORDER BY comment_date DESC
        ");
        $stmt->execute(array((int)$postId));

        $comments = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $c = new Comment();
            $c->id                 = (int)$row['id'];
            $c->postId             = (int)$row['post_id'];
            $c->author             = $row['author'];
            $c->comment            = $row['comment'];
            $c->frenchCreationDate = $row['frenchCreationDate'];
            $comments[] = $c;
        }
        return $comments;
    }

    /**
     * @param int $id
     * @return Comment|null
     */
    public function getComment($id)
    {
        $pdo = $this->connection->getConnection();
        $stmt = $pdo->prepare("
            SELECT id, post_id, author, comment,
                   DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS frenchCreationDate
            FROM comments
            WHERE id = ?
        ");
        $stmt->execute(array((int)$id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        $c = new Comment();
        $c->id                 = (int)$row['id'];
        $c->postId             = (int)$row['post_id'];
        $c->author             = $row['author'];
        $c->comment            = $row['comment'];
        $c->frenchCreationDate = $row['frenchCreationDate'];
        return $c;
    }

    /**
     * @param int $id
     * @param string $author
     * @param string $comment
     * @return bool
     */
    public function updateComment($id, $author, $comment)
    {
        $pdo = $this->connection->getConnection();
        $stmt = $pdo->prepare("UPDATE comments SET author = ?, comment = ? WHERE id = ?");
        return (bool)$stmt->execute(array($author, $comment, (int)$id));
    }

    /**
     * @param int $postId
     * @param string $author
     * @param string $comment
     * @return bool
     */
    public function addComment($postId, $author, $comment)
    {
        $pdo = $this->connection->getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO comments (post_id, author, comment, comment_date)
            VALUES (?, ?, ?, NOW())
        ");
        return (bool)$stmt->execute(array((int)$postId, $author, $comment));
    }
}
