<?php
    session_start();
    require('dbconnect.php');
    require('signin_user.php');

    // パラメータチェック
    if (!isset($_REQUEST['feed_id'])) {
        header('Location: timeline.php');
        exit();
    }

    // パラメータを取得
    // echo $_GET['feed_id'];
    // echo '<br>';
    // echo $_REQUEST['feed_id'];

    // データベースに接続・データを取得


    $sql = 'SELECT f.*,u.name,u.img_name FROM feeds AS f LEFT JOIN users AS u ON f.user_id=u.id WHERE f.id=?';
    $data = array($_REQUEST['feed_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // Fetch→配列にする
    $feed = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // echo '$feed = ';
    // var_dump($feed);
    // echo '</pre>';

    // echo '<pre>';
    // echo '$_SESSION = ';
    // var_dump($_SESSION);
    // echo '</pre>';


    // 表示する
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Learn SNS</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
</head>
<body style="margin-top: 60px">
  <div class="container">
    <div class="row">
      <!-- ここにコンテンツ -->
      <div class="col-xs-6 col-xs-offset-3">
        <?php if($feed != false){ ?>
          <img src="user_profile_img/<?php echo $feed['img_name']; ?>" width="60">
          <?php echo $feed['name']; ?><br>
          <?php echo $feed['created']; ?><br>
          <?php echo $feed['feed']; ?><br>
          
          <?php if($feed['user_id'] == $_SESSION['user']['id']){ ?>
            <a href="edit.php?feed_id=<?php echo $feed['id']; ?>" class="btn btn-success btn-xs">編集</a>
            <a href="delete.php?feed_id=<?php echo $feed['id']; ?>" class="btn btn-danger btn-xs">削除</a>
          <?php } ?>
        
        <?php } else { ?>
          <div class="thumbnail text-danger">
            この投稿は削除されたか、URLが間違っています。
          </div>
        <?php } ?>
        <br>
        <br>
        <a href="timeline.php">タイムラインへ</a>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>
















