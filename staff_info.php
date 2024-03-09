<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['staff_login']) == false) {
    echo 'ログインしてください。<br>';
    echo '<br>';
    echo '<a href="staff_login.html">ログイン画面へ</a>';
    exit;
} else {
    $login_id = $_SESSION['login_id'];
    echo '従業員ID: ' . $login_id . ' 操作中';
    echo '----------------';
    echo '<a href="./logout/staff_logout.php">ログアウト</a>';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お知らせ一覧編集画面</title>
</head>
<body>
    <h1>【従業員専用】お知らせ編集画面</h1>
    <?php
    try {
        require_once('./common/security.php');
        require_once('./common/db_config.php');
        
        $login_id = $_SESSION['login_id'];

        $sql = 'SELECT * FROM ryusenkaku_info';
    } catch (PDOException $e) {
        echo 'エラー発生: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES);
        exit;
    }
    ?>
    <!-- ここから追加（2024/03/09） -->
    <?php
    try {      
        $user = 'suzuki';
        $pass = 'suzukitest';
        $dsn = 'mysql:host=localhost;dbname=ryusenkaku;charset=utf8';
        $dbh = new PDO($dsn, $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM comment_keep';
        $stmt = $dbh->query($sql);
        $result = $dbh->fetchALL(PDO::FETCH_ASSOC);
        $dbh = null;
    } catch (PDOException $e) {
        echo 'エラー発生' . htmlspecialchars($e->getMessage(), ENT_QUOTES);
    }
    ?>
    <h1>投稿一覧</h1>
    <table border=1>
        <tr>
            <th>投稿日</th>
            <th>タイトル</th>
            <th>内容</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php
        foreach ($result as $row) {
            echo '<tr>';
            echo '<td>' . $result['date'] . '</td>';
            echo '<td>' . $result['title'] . '</td>';
            echo '<td>' . $result['body'] . '</td>';
            echo '<td><a href="detail.php?id=' . $result['id'] . '">詳細</a></td>';
            echo '<td><a href="edit.php?id=' . $result['id'] . '">変更</a></td>';
            echo '<td><a href="delete.php?id=' . $result['id'] . '">削除</a></td>';
            echo '</tr>';
        }       
        ?>
    </table>
</body>
</html>