<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../password.php');
    $db = new PDO('mysql:host=localhost;dbname=u67327', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if ($_POST['action'] == 'change') {
        $sth = $db->prepare("SELECT * FROM login_password where id = ?");
        $sth->execute([$_POST['id']]);
        $login_password = $sth->fetchAll();
        session_start();
        $_SESSION['login'] = $login_password[0]['login'];
        $_SESSION['uid'] = $_POST['id'];
        header('Location: index.php');
    }

    elseif ($_POST['action'] == 'delete') {
        try {
            $id = $_POST['id'];
            include('del_langs.php');
            $stmt = $db->prepare("DELETE FROM form where id = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("DELETE FROM login_password where id = ?");
            $stmt->execute([$id]);

            $sth = $db->prepare("SELECT * FROM form");
            $sth->execute();
            $users = $sth->fetchAll();
            $countId = count($users);
            $indexU = 0;
            for ($i = 1; $i <= $countId; $i++) {
                $tempU = intval($users[$indexU]['id']);
                $stmt = $db->prepare("UPDATE form SET id = ? where id = $tempU");
                $stmt->execute([$i]);
                $stmt = $db->prepare("UPDATE login_password SET id = ? where id = $tempU");
                $stmt->execute([$i]);
                $stmt = $db->prepare("UPDATE form_lang SET iduser = ? where iduser = $tempU");
                $stmt->execute([$i]);
                $indexU++;
            }
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
        setcookie('save', '1');
        header('Location: admin.php');
    }
}