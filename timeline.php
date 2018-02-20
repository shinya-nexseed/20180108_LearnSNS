<?php
    session_start();
    require('dbconnect.php');

    // echo '<pre>';
    // echo '$_SESSION = ';
    // var_dump($_SESSION);
    // echo '</pre>';

    require('signin_user.php');

    echo '<pre>';
    echo '$_POST = ';
    var_dump($_POST);
    echo '</pre>';

    // バリデーション用エラー配列初期化
    $errors = array();

    // ユーザーが投稿ボタンを押したら発動（$_POSTが空じゃないとき＝ユーザーがボタンを押したとき）
    if (!empty($_POST)) {
        echo '投稿処理<br>';
        echo '<br>';

        // ①投稿処理（C）
        // ②投稿データの全件表示（R）
        // ③UDの処理

        $feed = $_POST['feed']; // 投稿データ

        // フィードの空チェック
        if ($feed != '') {
            $sql = 'INSERT INTO `feeds` SET `feed`=?, `user_id`=?, `created`=NOW()';
            $data = array($feed, $signin_user['id']);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            header('Location: timeline.php');
            exit();
        } else {
            $errors['feed'] = 'blank';
        }

    }


    // 投稿データを全件取得
    $sql = 'SELECT f.*,u.name,u.img_name FROM feeds AS f LEFT JOIN users AS u ON f.user_id=u.id WHERE 1 ORDER BY f.created DESC'; // ASCがデフォルト
    $data = array();
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // fetch
    $feeds = array();

    while (true) {
        $feed = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($feed == false) {
            break;
        }

        $feeds[] = $feed;
    }

    // while ($feed = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //     $feeds[] = $feed;
    // }


    // echo '<pre>';
    // echo '$feeds = ';
    // var_dump($feeds);
    // echo '</pre>';
    $c = count($feeds);

    // ①投稿フォームにバリデーション（空チェック）
    // ②タイムライン情報にユーザー情報を追加
        // テーブルリレーション（１対多）
        // LEFT JOIN句

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
      <!-- ユーザー情報 -->
      <div class="col-xs-3">
        <a href="signout.php" class="btn btn-danger btn-xs">サインアウト</a><br>
        id: <?php echo $signin_user['id']; ?> <?php echo $signin_user['name']; ?><br>
        <img src="user_profile_img/<?php echo $signin_user['img_name']; ?>" width="100">
        <form method="POST" action="" class="form-group">
          <textarea name="feed" class="form-control"></textarea>
          <?php if(isset($errors['feed'])){ ?>
            <p class="alert alert-danger">投稿データを入力してください</p>
          <?php } ?>
          <input type="submit" value="投稿" class="btn btn-primary">
        </form>
      </div>

      <!-- 投稿情報（タイムライン） -->
      <div class="col-xs-9">
        <?php for($i=0;$i<$c;$i++){ ?>
          <div>
            <img src="user_profile_img/<?php echo $feeds[$i]['img_name']; ?>" width="60">
            <?php echo $feeds[$i]['name']; ?><br>
            <a href="show.php?feed_id=<?php echo $feeds[$i]['id']; ?>"><?php echo $feeds[$i]['created']; ?></a>
            <br>
            <?php echo $feeds[$i]['feed']; ?>
          </div>
          <hr>
        <?php } ?>
      </div>

    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>















