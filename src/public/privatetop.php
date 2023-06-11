<?php
session_start();

try {
    $dbUserName = 'root';
    $dbPassword = 'password';
    $dbName = 'tq_filter';

    $pdo = new PDO("mysql:host=mysql;dbname=$dbName;charset=utf8", $dbUserName, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 初期値として新しい順に並べる
    $orderBy = "created_at DESC";
    $keyword = "";
    $dateKeyword = "";

    // もしGETパラメータで並び順が指定されている場合、それを適用
    if (isset($_GET['order'])) {
        if ($_GET['order'] === 'asc') {
            $orderBy = "created_at ASC";
        }
    }

    // もしGETパラメータでキーワードが指定されている場合、それを適用
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        $keyword = "$keyword";
    }

    // もしGETパラメータで日付が指定されている場合、それを適用
    if (isset($_GET['date_keyword'])) {
        $dateKeyword = $_GET['date_keyword'];
    }

    // ユーザーの記事を取得するクエリを準備
    $sql = "SELECT * FROM pages";

    // クエリに条件を追加
    $conditions = [];
    if (!empty($keyword)) {
        $conditions[] = "(name LIKE :keyword OR contents LIKE :keyword)";
    }
    if (!empty($dateKeyword)) {
        $conditions[] = "DATE(created_at) = :date_keyword";
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY $orderBy";

    $stmt = $pdo->prepare($sql);

    if (!empty($keyword)) {
        $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
    }
    if (!empty($dateKeyword)) {
        $stmt->bindValue(':date_keyword', $dateKeyword, PDO::PARAM_STR);
    }

    $stmt->execute();

    // 記事のデータを取得
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("データベースへの接続に失敗しました: " . $e->getMessage());
}
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
            <input type="text" name="keyword" placeholder="キーワードを入力" value="<?php echo htmlspecialchars($keyword, ENT_QUOTES); ?>">
            <input type="date" name="date_keyword" placeholder="日付を入力" value="<?php echo htmlspecialchars($dateKeyword, ENT_QUOTES); ?>">
            <button type="submit">検索</button>
        </form>
    </div>

    <div>
        <form method="GET" action="">
            <div>
                <label>
                    <input type="radio" name="order" value="desc" <?php if ($orderBy === 'created_at DESC') echo 'checked'; ?>>
                    <span>新着順</span>
                </label>
                <label>
                    <input type="radio" name="order" value="asc" <?php if ($orderBy === 'created_at ASC') echo 'checked'; ?>>
                    <span>古い順</span>
                </label>
            </div>
            <button type="submit">並び替え</button>
        </form>
    </div>

    <div>
        <table border="1">
            <tr>
                <th>タイトル</th>
                <th>作成日時</th>
                <th>内容</th>
            </tr>

            <?php foreach ($blogs as $blog): ?>
                <tr>
                    <td><?php echo $blog['name']; ?></td>
                    <td><?php echo $blog['created_at']; ?></td>
                    <td><?php echo $blog['contents']; ?></td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>
</body>

</html>
