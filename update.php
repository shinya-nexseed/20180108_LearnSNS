<?php
    require('dbconnect.php');

    // ポスト送信チェック
    if (!isset($_POST['id'])) {
        header('Location: timeline.php');
        exit();
    }

    echo '<pre>';
    echo '$_POST = ';
    var_dump($_POST);
    echo '</pre>';

    // SQL
    $sql = 'UPDATE feeds SET feed=?, updated=NOW() WHERE id=?';
    $data = array($_POST['feed'], $_POST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // show.phpへ遷移
    header('Location: show.php?feed_id='.$_POST['id']);
    exit();
?>

















