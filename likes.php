<?php
    session_start();
    require('dbconnect.php');
    require('signin_user.php');

    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';

    echo 'user id:' . $_SESSION['user']['id'] . 'のユーザーが feed id:' . $_POST['feed_id'] . 'の投稿にいいね！する';

    $sql = 'INSERT INTO `likes` SET `user_id`=?, `feed_id`=?';
    $data = array($_SESSION['user']['id'], $_POST['feed_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    
?>

























