<?php
// src/model/comment.php
require_once __DIR__ . '/../lib/database.php';

class Comment
{
    public $id;
    public $author;
    public $comment;
    public $frenchCreationDate;
}

class CommentRepository
{
    
    public $connection; 

    public function getComments($postId)
    {
        $pdo = $this->connection->getConnection();

        $stmt = $pdo->prepare("
            SELECT
                id,
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
            $c->author             = $row['author'];
            $c->comment            = $row['comment'];
            $c->frenchCreationDate = $row['frenchCreationDate']; // alias camelCase !
            $comments[] = $c;
        }
        return $comments;
    }

    public function addComment($postId, $author, $comment)
    {
        $pdo = $this->connection->getConnection();

        $stmt = $pdo->prepare("
            INSERT INTO comments (post_id, author, comment, comment_date)
            VALUES (?, ?, ?, NOW())
        ");
        return $stmt->execute(array((int)$postId, $author, $comment));
    }
}
