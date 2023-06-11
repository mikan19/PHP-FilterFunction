<?php
$order = filter_input(INPUT_GET, 'order');
if ($order) {
    $direction = $_GET['order'];
} else {
    $direction = 'desc';
}

$searchKeyword = filter_input(INPUT_GET, 'searchKeyword');
if ($searchKeyword) {
    $name = '%' . $_GET['searchKeyword'] . '%';
    $contents = '%' . $_GET['searchKeyword'] . '%';
} else {
    $name = '%';
    $contents = '%';
}

$dateKeyword = filter_input(INPUT_GET, 'dateKeyword');
if ($dateKeyword) {
    $nextDate = date('Y-m-d', strtotime($dateKeyword . ' 1 day'));
    $sql = "SELECT * FROM pages 
    WHERE (name LIKE :name OR contents LIKE :contents) 
    AND created_at BETWEEN :dateKeyword AND :nextDate 
    ORDER BY created_at $direction";
} else {
    $sql = "SELECT * FROM pages WHERE name LIKE :name OR contents LIKE :contents ORDER BY created_at $direction";
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=tq_filter; charset=utf8',
    $dbUserName,
    $dbPassword
);

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':contents', $contents, PDO::PARAM_STR);
if (!empty($dateKeyword)) {
    $stmt->bindValue(':dateKeyword', $dateKeyword, PDO::PARAM_STR);
    $stmt->bindValue(':nextDate', $nextDate, PDO::PARAM_STR);
}
$stmt->execute();
$memos = $stmt->fetchAll();
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
      <input type="text" name="searchKeyword" placeholder="キーワードを入力" value="<?php echo $searchKeyword; ?>">

      <input type="date" name="dateKeyword" placeholder="日付を入力" value="<?php if (
          $dateKeyword
      ) {
          echo $dateKeyword;
      } ?>">

      <div>
        <label>
          <input type="radio" name="order" value="desc" <?php if (
              $direction == 'desc'
          ) {
              echo 'checked';
          } ?>>
          <span>新着順</span>
        </label>
        <label>
          <input type="radio" name="order" value="asc" <?php if (
              $direction == 'asc'
          ) {
              echo 'checked';
          } ?>>
          <span>古い順</span>
        </label>
      </div>

      <button type="submit">検索</button>
    </form>
  </div>

  <div>
    <table border="1">
      <tr>
        <th>タイトル</th>
        <th>作成日時</th>
        <th>内容</th>
      </tr>

      <?php foreach ($memos as $memo): ?>
      <tr>
        <td><?php echo $memo['name']; ?></td>
        <td><?php echo $memo['created_at']; ?></td>
        <td><?php echo $memo['contents']; ?></td>
      </tr>
      <?php endforeach; ?>

    </table>
  </div>
</body>

</html>