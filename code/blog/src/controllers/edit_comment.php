<?php
namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Model\CommentRepository;

require_once __DIR__ . '/../lib/database.php';
require_once __DIR__ . '/../model/comment.php';

function editComment($commentId)
{
    $repo = new CommentRepository(new DatabaseConnection());
    $comment = $repo->getComment((int)$commentId);
    if ($comment === null) {
        throw new \Exception('Commentaire introuvable');
    }

    // 👇 le require du template doit être ICI, pas au niveau global
    require __DIR__ . '/../../templates/edit_comment.php';
}
