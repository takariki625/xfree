<?php 
require("../add/config.php");
$pdo=localPdo::getInstance();
$todo=new Todo($pdo);
$todo->todo();
$todoList=$todo->getTodo();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>TodoList</title>
    <link rel="stylesheet" href="../add/index.css">
  </head>
  <body>
    <main>
      <header>
        <div>
          <span id="purge">purge</span>
        </div>
        <form>
          <input type="text" name="title">
        </form>
      </header>
      <ul>
        <?php foreach($todoList as $list): ?>
          <li data-id="<?= $list["id"] ?>">
            <label>
              <input type="checkbox"
                <?= $list["is_done"]?"checked":"";?>>
              <span><?= $list["title"]; ?></span>
            </label>
            <span class="delete">x</span>
          </li>
        <?php endforeach; ?>
      </ul>
    </main>
    <script src="../add/index.js"></script>
  </body>
</html>