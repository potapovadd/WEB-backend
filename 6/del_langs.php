<?php
    $stmt = $db->prepare("DELETE FROM form_lang where iduser = ?");
    $stmt->execute([$id]);
    $sth = $db->prepare("SELECT * FROM form_lang");
    $sth->execute();
    $users_langs = $sth->fetchAll();
    $countId = count($users_langs);
    $index = 0;
    
    for ($i = 1; $i <= $countId; $i++) {
        $tempUL = intval($users_langs[$index]['id']);
        $stmt = $db->prepare("UPDATE form_lang SET id = ? where id = $tempUL");
        $stmt->execute([$i]);
        $index++;
    }
