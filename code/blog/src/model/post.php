<?php
// src/model/post.php

class Post
{
    public $identifier;
    public $title;
    public $content;
    public $frenchCreationDate;
}

class PostRepository
{
    public $database = null; // PDO

    
    private function dbConnect()
    {
        if ($this->database === null) {
            try {
                $this->database = new PDO(
                    'mysql:host=localhost;dbname=blog',
                    'blog',
                    'password'
                );
                $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
    }

    public function getPosts()
    {
        $this->dbConnect();

        $sql = "
            SELECT
                id AS identifier,
                title,
                content,
                DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS frenchCreationDate
            FROM posts
            ORDER BY creation_date DESC
        ";
        $st = $this->database->query($sql);

        $posts = array();
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

    public function getPost($id)
    {
        $this->dbConnect();

        $st = $this->database->prepare("
            SELECT
                id,
                title,
                content,
                DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS frenchCreationDate
            FROM posts
            WHERE id = ?
        ");
        $st->execute(array((int)$id));
        $row = $st->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null; 
        }

        $post = new Post();
        $post->identifier         = (int)$row['id'];
        $post->title              = $row['title'];
        $post->content            = $row['content'];
        $post->frenchCreationDate = $row['frenchCreationDate'];
        return $post;
    }
}
