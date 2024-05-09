<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();

  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    $messages['success'] = 'Спасибо, результаты сохранены.';
    if (!empty($_COOKIE['pass'])) {
      $messages['session'] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
  }

  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['tel'] = !empty($_COOKIE['tel_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['month'] = !empty($_COOKIE['month_error']);
  $errors['day'] = !empty($_COOKIE['day_error']);
  $errors['radio1'] = !empty($_COOKIE['radio1_error']);
  $errors['lang'] = !empty($_COOKIE['lang_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['check-1'] = !empty($_COOKIE['check-1_error']);

  if ($errors['fio']) {
    setcookie('fio_error', '', 100000);
    setcookie('fio_value', '', 100000);
    $messages[] = '<div class="error">Заполните имя. Допустимые символы: строчные и заглавные буквы.</div>';
  }
  if ($errors['tel']) {
    setcookie('tel_error', '', 100000);
    setcookie('tel_value', '', 100000);
    $messages[] = '<div class="error">Заполните телефон. Допустимые символы: цифры и "+".</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    setcookie('email_value', '', 100000);
    $messages[] = '<div class="error">Заполните почту. Допустимые символы:строчные и заглавные буквы, цифры, специальные символы "@, _, -, .".</div>';
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    setcookie('year_value', '', 100000);
    $messages[] = '<div class="error">Заполните год. Допустимые символы: цифры.</div>';
  }
  if ($errors['month']) {
    setcookie('month_error', '', 100000);
    setcookie('month_value', '', 100000);
    $messages[] = '<div class="error">Заполните месяц. Допустимые символы: цифры.</div>';
  }
  if ($errors['day']) {
    setcookie('day_error', '', 100000);
    setcookie('day_value', '', 100000);
    $messages[] = '<div class="error">Заполните день. Допустимые символы: цифры.</div>';
  }
  if ($errors['radio1']) {
    setcookie('radio1_error', '', 100000);
    setcookie('radio1_value', '', 100000);
    $messages[] = '<div class="error">Заполните пол.</div>';
  }
  if ($errors['lang']) {
    setcookie('lang_error', '', 100000);
    setcookie('lang_value', '', 100000);
    $messages[] = '<div class="error">Заполните язык программирования.</div>';
  }
  if ($errors['bio']) {
    setcookie('bio_error', '', 100000);
    setcookie('bio_value', '', 100000);
    $messages[] = '<div class="error">Заполните биографию. Допустимые символы: строчные и заглавные буквы, цифры, специальные символы.</div>';
  }
  if ($errors['check-1']) {
    setcookie('check-1_error', '', 100000);
    setcookie('check-1_value', '', 100000);
    $messages[] = '<div class="error">Ознакомьтесь с контрактом.</div>';
  }

  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : strip_tags($_COOKIE['fio_value']);
  $values['tel'] = empty($_COOKIE['tel_value']) ? '' : strip_tags($_COOKIE['tel_value']);
  $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
  $values['year'] = empty($_COOKIE['year_value']) ? '' : strip_tags($_COOKIE['year_value']);
  $values['month'] = empty($_COOKIE['month_value']) ? '' : strip_tags($_COOKIE['month_value']);
  $values['day'] = empty($_COOKIE['day_value']) ? '' : strip_tags($_COOKIE['day_value']);
  $values['radio1'] = empty($_COOKIE['radio1_value']) ? '' : strip_tags($_COOKIE['radio1_value']);
  $values['lang'] = empty($_COOKIE['lang_value']) ? '' : unserialize($_COOKIE['lang_value']);
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : strip_tags($_COOKIE['bio_value']);
  $values['check-1'] = empty($_COOKIE['check-1_value']) ? '' : strip_tags($_COOKIE['check-1_value']);



include('../password.php');
if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])){
    $userLogin = $_SESSION['login'];
}
$db = new PDO('mysql:host=localhost;dbname=u67327', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
  $uid = $_SESSION['uid'];
  $sth = $db->prepare("SELECT * FROM form where id = $uid");
  $sth->execute();
  $user = $sth->fetchAll();
  $values['fio'] = strip_tags($user[0]['fio']);
  $values['tel'] = strip_tags($user[0]['tel']);
  $values['email'] = strip_tags($user[0]['email']);
  $pos1 = strpos(strip_tags($user[0]['date']),'.');
  $values['day']=strip_tags(intval(substr($user[0]['date'], 0, $pos1)));

  $pos2 = strrpos(strip_tags($user[0]['date']),'.');
  $values['month']=strip_tags(intval(substr($user[0]['date'], $pos1 + 1, $pos2 - $pos1 - 1)));
  $values['year']=strip_tags(intval(substr($user[0]['date'], $pos2 + 1, 4)));
  $values['radio1'] = strip_tags($user[0]['gender']);

  $sth = $db->prepare("SELECT idlang FROM form_lang where iduser = $uid");
  $sth->execute();
  $languages = $sth->fetchAll();
  $values['lang'] = array();
  foreach($languages as $l) {
    array_push($values['lang'], strip_tags($l['idlang']));
  }
  $values['bio'] = strip_tags($user[0]['bio']);
  $values['check-1'] = strip_tags($user[0]['checkbox']);
  printf('Вход с логином %s, ID пользователя %d', $_SESSION['login'], $_SESSION['uid']);
  
}
include('form.php');

}
else {
  $errors = FALSE;
  if (empty($_POST['fio']) || !preg_match('/^[а-яА-Яa-zA-Z\s]{1,150}$/u', $_POST['fio'])) {
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60 * 12);

  if (empty($_POST['tel']) || !preg_match('/^\+?([0-9]{11})/', $_POST['tel'])) {
    setcookie('tel_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('tel_value', $_POST['tel'], time() + 30 * 24 * 60 * 60 * 12 );

  if (empty($_POST['email']) || !preg_match('/^[A-Za-z0-9_]+@[A-Za-z0-9_]+\.[A-Za-z0-9_]+$/', $_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60 * 12);

  if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60 * 12);

  $months = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  if (empty($_POST['month']) || !is_numeric($_POST['month']) || !preg_match('/^\d+$/', $_POST['month'])) {
    setcookie('month_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('month_value', $_POST['month'], time() + 30 * 24 * 60 * 60 * 12);

  if (empty($_POST['day']) || !is_numeric($_POST['day']) || $_POST['day'] > $months[$_POST['month'] - 1]) {
    setcookie('day_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('day_value', $_POST['day'], time() + 30 * 24 * 60 * 60 * 12);

  if (empty($_POST['radio1'])) {
    setcookie('radio1_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('radio1_value', $_POST['radio1'], time() + 30 * 24 * 60 * 60 * 12); 

  $errorlang = FALSE;
  if (empty($_POST['lang'])) {
    setcookie('lang', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
    $errorlang = TRUE;
  }
  else {
    include('../password.php');
    $db = new PDO('mysql:host=localhost;dbname=u67327', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    $sth = $db->prepare("SELECT id FROM lang");
    $sth->execute();
    $langs = $sth->fetchAll();
    foreach ($_POST['lang'] as $idlang) {
        $errorlang = TRUE;
        foreach ($langs as $lang) {
        if ($idlang == $lang[0]) {
            $errorlang = FALSE;
            break;
            }
        }
        if ($errorlang == TRUE) {
            setcookie('lang_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
            break;
        }
    }
  }
  setcookie('lang_value', serialize($_POST['lang']), time() + 30 * 24 * 60 * 60 * 12);

  if (empty($_POST['bio'])) {
    setcookie('bio', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60 * 12);

  if (empty($_POST['check-1']) || $_POST['check-1'] != 'on') {
    setcookie('check-1', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('check-1_value', $_POST['bio'], time() + 30 * 24 * 60 * 60 * 12);

  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    setcookie('fio_error', '', 100000);
    setcookie('tel_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('month_error', '', 100000);
    setcookie('day_error', '', 100000);
    setcookie('radio1_error', '', 100000);
    setcookie('lang_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('check-1_error', '', 100000);
  }

  if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
    $id = intval($_SESSION['uid']);
    try {
      $stmt = $db->prepare("UPDATE form SET fio = ?, tel = ?, email = ?, date = ?, gender = ?, bio = ?, checkbox = ? where id = $id");
      $stmt->execute([$_POST['fio'], $_POST['tel'], $_POST['email'], $_POST['day'] . ':' . $_POST['month'] . ':' . $_POST['year'], $_POST['radio1'], $_POST['bio'], true]);

      $sth = $db->prepare("SELECT id FROM form_lang where iduser = ?");
      $sth->execute([$id]);
      $all_id = $sth->fetchAll();
      $first_id = intval($all_id[0]['id']);

      print(strval($id) . '  '. strval($first_id));
      
      $stmt = $db->prepare("DELETE FROM form_land where iduser = ?");
      $stmt->execute([$id]);

      $stmt = $db->prepare("INSERT INTO form_lang (id, iduser, idlang) VALUES (:id, :iduser, :idlang)");
      foreach ($_POST['languages'] as $idlang) {
        $stmt->bindParam(':id', $first_id);
        $stmt->bindParam(':iduser', $iduser);
        $stmt->bindParam(':idlang', $idlang);
        $iduser = $id;
        $stmt->execute();
        $first_id++;
    }
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
  }
  else {
    $login = uniqid();
    $password = uniqid();
    setcookie('login', $login, time() + 12 * 30 * 24 * 60 * 60);
    setcookie('pass', $password, time() + 12 * 30 * 24 * 60 * 60);
  
  try {
    $stmt = $db->prepare("INSERT INTO form SET fio = ?, tel = ?, email = ?, date = ?, gender = ?, bio = ?, checkbox = ?");
    $stmt->execute([$_POST['fio'], $_POST['tel'], $_POST['email'], $_POST['day'] . ':' . $_POST['month'] . ':' . $_POST['year'], $_POST['radio1'], $_POST['bio'], true]);
  
    $id = $db->lastInsertId();
  
    $stmt = $db->prepare("INSERT INTO form_lang (iduser, idlang) VALUES (:iduser, :idlang)");
    foreach ($_POST['lang'] as $idlang) {
      $stmt->bindParam(':iduser', $iduser);
      $stmt->bindParam(':idlang', $idlang);
      $iduser = $id;
      $stmt->execute();
    }
  }
  catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
  }
  }
  setcookie('save', '1');

  header('Location: index.php');
}
