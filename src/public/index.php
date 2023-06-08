<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=tq_filter; charset=utf8',
    $dbUserName,
    $dbPassword
);

$order = isset($_GET['order']) ? $_GET['order'] : 'desc'; // デフォ
$sql = 'SELECT * FROM pages';

// ラジオボタンの選択状態に応じて
if ($order === 'asc') {
    $sql .= ' ORDER BY created_at ASC'; // 作成日時の昇順で並び替え
} else {
    $sql .= ' ORDER BY created_at DESC'; // 作成日時の降順（新着順）で並び替え（デフォ）
}

$statement = $pdo->prepare($sql);
$statement->execute();
$pages = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>top画面</title>
</head>

<body>
  <div>
    <div>
      <form action="index.php" method="get">
        <div>
          <label>
            <input type="radio" name="order" value="desc" class="">
            <span>新着順</span>
          </label>
          <label>
            <input type="radio" name="order" value="asc" class="">
            <span>古い順</span>
          </label>
        </div>
        <button type="submit">送信</button>
      </form>
    </div>

    <div>
      <table border="1">
        <tr>
          <th>タイトル</th>
          <th>内容</th>
          <th>作成日時</th>
        </tr>
        <?php foreach ($pages as $page): ?>
          <tr>
            <td><?php echo htmlspecialchars($page['name'], ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($page['contents'], ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($page['created_at'], ENT_QUOTES); ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</body>

</html>
