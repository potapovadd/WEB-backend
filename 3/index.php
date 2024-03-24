<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Спасибо, результаты сохранены.');
  }
  include('form.php');
  exit();
}

$errors = FALSE;
if (empty($_POST['fio']) || !preg_match('/^[а-яА-Яa-zA-Z\s]{1,150}$/u', $_POST['fio'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}

if (empty($_POST['tel']) || !preg_match('/^\+?([0-9]{11})/', $_POST['tel'])) {
  print('Заполните телефон.<br/>');
  $errors = TRUE;
}

if (empty($_POST['email']) || !preg_match('/^[A-Za-z0-9_]+@[A-Za-z0-9_]+\.[A-Za-z0-9_]+$/', $_POST['email'])) {
  print('Заполните почту.<br/>');
  $errors = TRUE;
}

if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  print('Заполните год.<br/>');
  $errors = TRUE;
}

if (empty($_POST['month']) || !is_numeric($_POST['month']) || !preg_match('/^\d+$/', $_POST['month'])) {
  print('Заполните месяц.<br/>');
  $errors = TRUE;
}

$months = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
if (empty($_POST['day']) || $_POST['day'] > $months[$_POST['month'] - 1]) {
  print('Заполните день.<br/>');
  $errors = TRUE;
}

if (empty($_POST['radio1'])) {
  print('Заполните пол.<br/>');
  $errors = TRUE;
}

$user = 'u67327'; 
$pass = '4242183'; 
$db = new PDO('mysql:host=localhost;dbname=u67327', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 

if (empty($_POST['lang'])) {
  print('Заполните ЯП.<br/>');
  $errors = TRUE;
} else { 
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
      print('Заполните ЯП правильно.<br/>');
      $errors = TRUE;
      break;
    }
  }
}

if (empty($_POST['bio'])) {
  print('Заполните био.<br/>');
  $errors = TRUE;
}

if (empty($_POST['check-1']) || $_POST['check-1'] != 'on') {
  print('Ознакомтесь.<br/>');
  $errors = TRUE;
}

if ($errors) {
  exit();
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

header('Location: ?save=1');
