<link rel="stylesheet" href="style.css">
<?php

include('../password.php');
$db = new PDO('mysql:host=localhost;dbname=u67327', $user, $pass,
[PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$sth = $db->prepare("SELECT * FROM login_admin");
$sth->execute();
$login_admin = $sth->fetchAll();
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $login_admin[0]['login'] ||
    md5($_SERVER['PHP_AUTH_PW']) != $login_admin[0]['password']) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

print('Вы авторизованы.');
if (!empty($_COOKIE['save'])) {
  print('<br>');
  print('Операция выполнена успешно.');
  setcookie('save', '', 100000);
  setcookie('PHPSESSID', '', 100000, '/');
  setcookie('fio_value', '', 100000);
  setcookie('tel_value', '', 100000);
  setcookie('email_value', '', 100000);
  setcookie('year_value', '', 100000);
  setcookie('month_value', '', 100000);
  setcookie('day_value', '', 100000);
  setcookie('radio1_value', '', 100000);
  setcookie('lang_value', '', 100000);
  setcookie('bio_value', '', 100000);
  setcookie('check-1_value', '', 100000);
}
setcookie('admin', $login_admin[0]['password'], time() + 24 * 60 * 60);

include('../password.php');
$db = new PDO('mysql:host=localhost;dbname=u67327', $user, $pass,
[PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$sth = $db->prepare("SELECT * FROM form");
$sth->execute();
$users = $sth->fetchAll();
?>

<h2>Таблица пользователей</h2>
<table class="users">
  <tr>
    <th>Id</th>
    <th>ФИО</th>
    <th>Телефон</th>
    <th>Email</th>
    <th>Дата рождения</th>
    <th>Пол</th>
    <th>Биография</th>
    <th class="nullCell"></th>
    <th class="nullCell"></th>
  </tr>
  <?php
    foreach($users as $user) {
      printf('<tr>
      <td>%d</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td class="nullCell">
        <form 
          style="background-color: white;"
          action="action.php" method="POST">
          <input type="hidden" name="action" value="change">
          <input type="hidden" name="id" value="%d">
          <input type="submit" value="Изменить"/>
        </form>
      </td>
      <td class="nullCell">
        <form
          style="background-color: white;" 
          action="action.php" method="POST">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="%d">
          <input type="submit" value="Удалить"/>
        </form>
      </td>
      </tr>',
      $user['id'], $user['fio'], $user['tel'], $user['email'],
      $user['date'], $user['gender'], $user['bio'],
      $user['id'], $user['id']);
    }
  ?>
</table>

<?php
$sth = $db->prepare("SELECT form_lang.iduser, lang.name 
FROM form_lang join lang on form_lang.idlang = lang.id");
$sth->execute();
$users_lang = $sth->fetchAll();
?>

<h2>Таблица языков программирования</h2>
<table>
  <tr>
    <th>Id пользователя</th>
    <th>Язык программирования</th>
  </tr>
  <?php
    foreach($users_lang as $user_lang) {
      printf('<tr>
      <td>%s</td>
      <td>%s</td>
      </tr>',
      $user_lang['iduser'], $user_lang['name']);
    }
  ?>
</table>

<h2>Статистика по языкам</h2>
<table>
  <tr>
    <th>Язык программирования</th>
    <th>Количество</th>
  </tr>
  <?php
    $sth = $db->prepare("SELECT name, COUNT(form_lang.iduser) AS user_count FROM lang LEFT JOIN form_lang ON lang.id = form_lang.idlang GROUP BY name");
    $sth->execute();
    $user_count = $sth->fetchAll();
    foreach($user_count as $u_c) {
      printf('<tr>
      <td>%s</td>
      <td>%s</td>
      </tr>',
      $u_c['name'], $u_c['user_count']);
    }
  ?>
</table>

<form 
  style="background-color: white;"
  action="index.php" method="POST">
  <input type="submit" name="exit_admin" value="Выход">
</form>
