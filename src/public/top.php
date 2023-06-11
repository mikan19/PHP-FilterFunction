<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=tq_filter; charset=utf8',
    $dbUserName,
    $dbPassword
);
//検索ワードの取得
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// クエリの基本形を定義
$sql = 'SELECT * FROM pages';

// 日付が指定された場合はクエリに日付の条件を追加
if (!empty($keyword)) {
  $sql .= ' WHERE DATE(created_at) = :keyword'; // 作成日の日付が一致する条件を追加
}
$statement = $pdo->prepare($sql);

if (!empty($keyword)) {
    $statement->bindValue(':keyword', $keyword, PDO::PARAM_STR); // 日付のバインド値を設定
}

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
    <form method="GET" action="">
        <p>絞り込み検索</p>
        <input type="date" name="keyword" placeholder="日付を入力" value="<?php echo htmlspecialchars($keyword, ENT_QUOTES); ?>">
        <button type="submit">検索</button>
    </form>
</div>

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
            <td><?php echo $page['name']; ?></td>
            <td><?php echo $page['contents']; ?></td>
            <td><?php echo $page['created_at']; ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</body>

</html>
