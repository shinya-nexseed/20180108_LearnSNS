<?php
    session_start();

    $errors = array();

    // 戻ってきた場合の処理
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite') {
        // $_GET = array('action'=>'rewrite');
        // $_POSTを偽造します
        $_POST['input_name'] = $_SESSION['register']['name'];
        $_POST['input_email'] = $_SESSION['register']['email'];
        $_POST['input_password'] = $_SESSION['register']['password'];

        // バリデーションメッセージ用
        $errors['rewrite'] = true;
    }

    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';


    // 変数を空定義
    $name = '';
    $email = '';

    // $_POSTが空じゃない時
    // ↓↓↓
    // ユーザーがformの送信ボタンを押した時
    if (!empty($_POST)) {
        echo '送信<br>';

        // 変数定義
        $name = $_POST['input_name'];
        $email = $_POST['input_email'];
        $password = $_POST['input_password'];

        // ユーザー名の空チェック
        if ($name == '') {
            $errors['name'] = 'blank';
        }

        // メールアドレスの空チェック
        if ($email == '') {
            $errors['email'] = 'blank';
        }

        // パスワードの空チェック
        $str_c = strlen($password);
        if ($password == '') {
            $errors['password'] = 'blank';
        } elseif ($str_c < 4 || 16 < $str_c) {
            $errors['password'] = 'length';
        }

        // type=fileの情報を受取るには$_FILESスーパーグローバル変数が必要
        if (!isset($_REQUEST['action'])) {
            $file_name = $_FILES['input_img_name']['name'];
        }
        
        if (!empty($file_name)) {
            // JPG/PNG/GIFの三種類のみに制限
            $file_type = substr($file_name,-3);
            $file_type = strtolower($file_type);

            if ($file_type != 'jpg' && $file_type != 'png' && $file_type != 'gif') {
                $errors['img_name'] = 'type';
            }

        } else {
            $errors['img_name'] = 'blank';
        }

        if (isset($_REQUEST['action'])) {
            $errors['img_name'] = 'rewrite';
        }

        // バリデーションを通過すれば次のページへ遷移
        if (empty($errors)) {
            $date_str = date('YmdHis');
            $submit_file_name = $date_str . $file_name;
            move_uploaded_file($_FILES['input_img_name']['tmp_name'],'../user_profile_img/'.$submit_file_name);

            $_SESSION['register']['name'] = $name;
            $_SESSION['register']['email'] = $email;
            $_SESSION['register']['password'] = $password;
            $_SESSION['register']['img_name'] = $submit_file_name;
            // $_SESSION['register'] = $_POST;
            header('Location: check.php');
            exit();
        }
        
    }

    echo '<pre>';
    var_dump($errors);
    echo '</pre>';

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
      <form method="POST" action="signup.php" enctype="multipart/form-data">
        <span>ユーザー名</span><br>
        <input type="text" name="input_name" value="<?php echo $name; ?>"><br>
        <?php if(isset($errors['name'])){ ?>
          <span style="color: red;">ユーザー名を入力してください</span><br>
        <?php } ?>

        <span>メールアドレス</span><br>
        <input type="email" name="input_email" value="<?php echo $email; ?>"><br>
        <?php if(isset($errors['email'])){ ?>
          <span style="color: red;">メールアドレスを入力してください</span><br>
        <?php } ?>

        <span>パスワード</span><br>
        <input type="password" name="input_password"><br>
        <?php if(isset($errors['password']) && $errors['password'] == 'blank'){ ?>
          <span style="color: red;">パスワードを入力してください</span><br>
        <?php } ?>
        <?php if(isset($errors['password']) && $errors['password'] == 'length'){ ?>
          <span style="color: red;">パスワードは4 ~ 16文字で入力してください</span><br>
        <?php } ?>
        <?php if(isset($errors['rewrite'])){ ?>
          <span style="color: red;">パスワードを再入力してください</span><br>
        <?php } ?>

        <span>プロフィール画像</span><br>
        <input type="file" name="input_img_name" accept="image/*">
        <?php if(isset($errors['img_name']) && $errors['img_name'] == 'blank'){ ?>
          <span style="color: red;">プロフィール画像を入力してください</span><br>
        <?php } ?>
        <?php if(isset($errors['img_name']) && $errors['img_name'] == 'type'){ ?>
          <span style="color: red;">プロフィール画像にはjpg / png / gifのいずれかを指定してください</span><br>
        <?php } ?>
        <?php if(isset($errors['img_name']) && $errors['img_name'] == 'rewrite'){ ?>
          <span style="color: red;">プロフィール画像を再入力してください</span><br>
        <?php } ?>

        <input type="submit" value="確認">
      </form>
    </div>
  </div>
  <script src="../assets/js/jquery-3.1.1.js"></script>
  <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="../assets/js/bootstrap.js"></script>
</body>
</html>
















