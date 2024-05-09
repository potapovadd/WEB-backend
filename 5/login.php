<link rel="stylesheet" href="style.css">
<?php

header('Content-Type: text/html; charset=UTF-8');

$session_started = false;
if (!empty($_COOKIE[session_name()]) && session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    ?>
      <section>
        <form action="" method="post">
          <div>Пользователь уже авторизован</div><br>
          <input type="submit" name="logout" value="Выход"/>
        </form>
      </section>
    <?php
    if (isset($_POST['logout'])) {
      session_destroy();
      setcookie('PHPSESSID', '', 100000, '/');
      header('Location: ./');
      exit();
    }
    
  }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<section>
  <form action="" method="post">
    <label>
      Логин:<br>
      <input type="text" name="login" />
    </label><br>
    <label>
      Пароль:<br>
      <input type="text" name="pass" />
    </label><br>
    <input type="submit" value="Войти" />
  </form>
</section>
<?php
}

else {
  include('../password.php');
  $login = $_POST['login'];
  $pass = md5($_POST['pass']);
  $sth = $db->prepare("SELECT * FROM login_password");
  $sth->execute();
  $log_pass = $sth->fetchAll();

  $flagSign = false;
  foreach ($log_pass as $l_p) {
    if ($login == $l_p['login'] && $pass == $l_p['password']) {
      $flagSign = true;
      break;
    }
  }

  if ($flagSign == true) {
    if (!$session_started) {
      session_start();
    }
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['uid'] = count($log_pass); // было 123
    header('Location: ./');
  }
  else {
    print('Данный пользователь не найден в базе данных.<br/>');
  }
}
