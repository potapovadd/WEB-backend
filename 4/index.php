<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();

  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
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
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['tel'] = empty($_COOKIE['tel_value']) ? '' : $_COOKIE['tel_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['month'] = empty($_COOKIE['month_value']) ? '' : $_COOKIE['month_value'];
  $values['day'] = empty($_COOKIE['day_value']) ? '' : $_COOKIE['day_value'];
  $values['radio1'] = empty($_COOKIE['radio1_value']) ? '' : $_COOKIE['radio1_value'];
  $values['lang'] = empty($_COOKIE['lang_value']) ? '' : unserialize($_COOKIE['lang_value']);
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['check-1'] = empty($_COOKIE['check-1_value']) ? '' : $_COOKIE['check-1_value'];

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

  if (empty($_POST['month']) || !is_numeric($_POST['month']) || !preg_match('/^\d+$/', $_POST['month'])) {
    setcookie('month_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('month_value', $_POST['month'], time() + 30 * 24 * 60 * 60 * 12);

  if (empty($_POST['day']) || !is_numeric($_POST['month']) || $_POST['day'] > $months[$_POST['month'] - 1]) {
    setcookie('day_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('day_value', $_POST['day'], time() + 30 * 24 * 60 * 60 * 12);

  if (empty($_POST['radio1'])) {
    setcookie('radio1_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('radio1_value', $_POST['radio1'], time() + 30 * 24 * 60 * 60 * 12);

    include('../password.php');
    if (!empty($_COOKIE[session_name()]) &&
    session_start() && !empty($_SESSION['login'])){
        $userLogin = $_SESSION['login'];
    }
    $db = new PDO('mysql:host=localhost;dbname=u67327', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 

  $errorlang = FALSE;
  if (empty($_POST['lang'])) {
    setcookie('lang', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
    $errorlang = TRUE;
  }
  else {
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

  setcookie('save', '1');

  header('Location: index.php');
}
