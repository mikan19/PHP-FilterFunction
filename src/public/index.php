<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=tq_filter; charset=utf8',
    $dbUserName,
    $dbPassword
);

// 検索ワードの取得
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

if (!empty($keyword)) {
  $stmt = $pdo->prepare("SELECT * FROM pages WHERE name LIKE :keyword OR contents LIKE :keyword");
  $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
} else {
  $stmt = $pdo->prepare("SELECT * FROM pages");
}
$stmt->execute();
$pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
      <div>
        <form method="GET" action="">
          <p>絞り込み検索</p>
          <input type="text" name="keyword" placeholder="キーワードを入力" value="<?php echo htmlspecialchars($keyword, ENT_QUOTES); ?>">
          <button type="submit">検索</button>
        </form>
      </div>
      
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