<?php
    session_start();
    require('../dbconnect.php');

    if (!isset($_SESSION['register'])) {
        header('Location: signup.php');
        exit();
    }

    // $_POSTは生きてるか？
    echo '<pre>';
    echo '$_POST = ';
    var_dump($_POST);
    echo '</pre>';

    echo '<pre>';
    echo '$_SESSION = ';
    var_dump($_SESSION);
    echo '</pre>';

    $name = $_SESSION['register']['name'];
    $email = $_SESSION['register']['email'];
    $password = $_SESSION['register']['password'];
    $img_name = $_SESSION['register']['img_name'];

    // $_POSTが空じゃなければ処理＝ユーザー登録ボタンが押されたら
    if (!empty($_POST)) {
        // パスワードのハッシュ化
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        echo $hash_password;
        echo '<br>';

        // STEP2
        $sql = 'INSERT INTO `users` SET `name`=?, `email`=?, `password`=?, `img_name`=?, `created`=NOW()';
        $data = array($name, $email, $hash_password, $img_name);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // セッションのregisterを初期化する（削除）
        $_SESSION['register'] = array();
        unset($_SESSION['register']);

        header('Location: thanks.php');
        exit();
    }

    // STEP3
    $dbh = null;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Learn SNS</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
</head>
<body style="margin-top: 60px">
  <div class="container">
    <div class="row">
      Name: <?php echo htmlspecialchars($name); ?><br>
      Email: <?php echo htmlspecialchars($email); ?><br>
      Password: ●●●●●●●●<br>
      <img src="../user_profile_img/<?php echo htmlspecialchars($img_name); ?>" width="100">

      <form method="POST" action="check.php">
        <input type="hidden" name="hoge" value="fuga">
        <a href="signup.php?action=rewrite">戻る</a>
        <input type="submit" value="ユーザー登録">
      </form>
    </div>
  </div>
  <script src="../assets/js/jquery-3.1.1.js"></script>
  <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="../assets/js/bootstrap.js"></script>
</body>
</html>















