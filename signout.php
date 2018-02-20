<?php
    // サインインしている状態＝$_SESSOIN['user']['id']に値が存在している
    // サインアウトは単純に$_SESSOIN['user']['id']を破棄するだけ

    // セッションの初期化
    // session_name("something")を使用している場合は特にこれを忘れないように!
    session_start();

    // セッション変数を全て解除する
    $_SESSION = array();

    // セッションを切断するにはセッションクッキーも削除する。
    // Note: セッション情報だけでなくセッションを破壊する。
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // 最終的に、セッションを破壊する
    session_destroy();

    // サインイン画面に遷移
    header('Location: signin.php');
    exit();
?>

























