<?php
$title = "Le blog de l'AVBN";
ob_start();
?>
<h1>Le super blog de l'AVBN !</h1>
<p>Derniers billets du blog :</p>

<?php foreach ($posts as $post): ?>
  <div class="news">
    <h3>
      <?= htmlspecialchars($post->title, ENT_QUOTES, 'UTF-8') ?>
      <em>le <?= htmlspecialchars($post->frenchCreationDate, ENT_QUOTES, 'UTF-8') ?></em>
    </h3>
    <p>
      <?= nl2br(htmlspecialchars($post->content, ENT_QUOTES, 'UTF-8')) ?>
      <br />
      <em>
        <a href="index.php?action=post&id=<?= (int)$post->identifier ?>">Commentaires</a>
      </em>
    </p>
  </div>
<?php endforeach; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
