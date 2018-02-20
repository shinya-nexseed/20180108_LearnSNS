<?php
    session_start();

    echo '<pre>';
    echo '$_POST = ';
    var_dump($_POST);
    echo '</pre>';

    echo '<pre>';
    echo '$_SESSION = ';
    var_dump($_SESSION);
    echo '</pre>';

    // もしセッションにユーザーのidが存在すれば
    if (isset($_SESSION['user']['id'])) {
        header('Location: timeline.php');
        exit();
    }

    require('dbconnect.php');

    // 送信ボタンが押されたとき発動（$_POSTが空じゃないとき）
    if (!empty($_POST)) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // $emailが空じゃない且つ$passwordが空じゃないとき
        if ($email != '' && $password != '') {
            $sql = 'SELECT * FROM `users` WHERE `email`=?';
            $data = array($email);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            echo '<pre>';
            echo '$record = ';
            var_dump($record);
            echo '</pre>';

            if ($record == false) {
                // メールアドレスミス
            } else {
                // パスワードが一致しているとき
                echo $record['password'];
                echo '<br>';
                echo $password;
                echo '<br>';
                // password_verify(普通文字列パスワード, ハッシュ文字列パスワード);
                // 一致してればtrueを、そうでなければfalseを返す
                $verify = password_verify($password, $record['password']);

                if ($verify == true) {
                    // サインイン処理

                    // ①セッションにサインインユーザーのidを保存
                    // ②timeline.phpに遷移
                    // ③timeline.phpを作成
                    // ④サインインユーザーの情報表示
                    // ⑤もしサインインせずにtimeline.phpをロードした場合はsignin.phpへ強制遷移

                    $_SESSION['user']['id'] = $record['id'];

                    header('Location: timeline.php');
                    exit();
                }
            }
        }
    }
    
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
      <h2>サインイン</h2>
      <form method="POST" action="signin.php">
        <div>
          <span>メールアドレス</span><br>
          <input type="email" name="email">
        </div>

        <div>
          <span>パスワード</span><br>
          <input type="password" name="password">
        </div>

        <input type="submit" value="サインイン">
      </form>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>














