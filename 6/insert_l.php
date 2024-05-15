<?php
    $stmt = $db->prepare("INSERT INTO form_lang (id, iduser, idlang) VALUES (:id, :iduser, :idlang)");
    foreach ($_POST['languages'] as $idlang) {
      $stmt->bindParam(':id', $tmp_id);
      $stmt->bindParam(':iduser', $iduser);
      $stmt->bindParam(':idlang', $idlang);
      $iduser = $id;
      $stmt->execute();
      $tmp_id++;
    }