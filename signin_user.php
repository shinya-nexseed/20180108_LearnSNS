<?php
    // サインインチェック
    if (!isset($_SESSION['user']['id'])) {
        header('Location: signin.php');
        exit();
    }

    // サインインユーザー取得
    $sql = 'SELECT * FROM `users` WHERE `id`=?';
    $data = array($_SESSION['user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // fetch
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);
?>