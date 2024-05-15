<html lang="ru">
  <head>
  <link rel="stylesheet" href="style.css">
    <style>
      .error {
        border: 2px solid red;
      }
    </style>
    <title>6</title>
  </head>

  <body>
  <?php
  if (!empty($messages['success'])) {
    print('<div id="messages">');
    print($messages['success']);
    print('</div>');
    print('<br>');
  }
  if (!empty($messages['session'])) {
    print('<div id="messages">');
    print($messages['session']);
    print('</div>');
    print('<br>');
  }
  if (!empty($messages['admin'])) {
    print('<div id="messages">');
    print($messages['admin']);
    print('</div>');
    print('<br>');
  }
  ?>

    <form action="index.php" method="POST">

    <label>
    ФИО:<br>
    <input name="fio" type="text" 
    <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>" 
    placeholder="Введите ваши ФИО" />
    </label><br>

    <label>
    Номер телефона:<br>
    <input name="tel" type="tel" 
    <?php if ($errors['tel']) {print 'class="error"';} ?> value="<?php print $values['tel']; 
    ?>" placeholder="Введите ваш номер телефона" />
    </label><br>
    
    <label>
    Email:<br>
    <input name="email" type="email" 
    <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; 
    ?>" placeholder="Введите вашу почту" />
    </label><br>

    <label>
      Дата рождение:<br>
      <select name="year" 
      <?php if ($errors['year']) {print 'class="error"';} ?>>
        <?php
        for ($i = 1922; $i <= 2024; $i++) {
          printf('<option %s value="%d">%d год</option>', $values['year'] == $i ? 'selected' : '', $i, $i);
        }
        ?>
      </select><br>
      
      <br>
      <select name="month" 
      <?php if ($errors['month']) {print 'class="error"';} ?>>
        <?php
        for ($i = 1; $i <= 12; $i++) {
          printf('<option %s value="%d">%d месяц</option>', $values['month'] == $i ? 'selected' : '', $i, $i);
        }
        ?>
      </select><br>
      
      <br>
      <select name="day" <?php if ($errors['day']) {print 'class="error"';} ?>>
        <?php
        for ($i = 1; $i <= 31; $i++) {
          printf('<option %s value="%d">%d день</option>', $values['day'] == $i ? 'selected' : '', $i, $i);
        }
        ?>
      </select><br>
    </label>

    <label class="
    <?php if ($errors['radio1']) {print " error";} ?>">
      Пол:
      <input type="radio" name="radio1" value="woman" 
      <?php if ($values['radio1'] == 'woman') print('checked'); ?>/> Женский
      <input type="radio" name="radio1" value="man" 
      <?php if ($values['radio1'] == 'man') print('checked'); ?>/> Мужской
    </label><br>

    <label>
      Любимый язык программирования:
      <br>
      <select name="lang[]" multiple="multiple" 
      <?php if ($errors['lang']) {print 'class="error"';} ?>>

        <option <?php if (!empty($values) && !empty($values['lang'])) {
        foreach($values['lang'] as $value) {
          if ($value == "1") {
            print("selected");
            }
          }
        }
        ?> value="1">Pascal</option>
        
        <option <?php if (!empty($values) && !empty($values['lang'])) {
        foreach($values['lang'] as $value) {
          if ($value == "2") {
            print("selected");
            }
          }
        }
        ?> value="2">C</option>

        <option <?php if (!empty($values) && !empty($values['lang'])) {
        foreach($values['lang'] as $value) {
          if ($value == "3") {
            print("selected");
            }
          }
        }
        ?> value="3">C++</option>

        <option <?php if (!empty($values) && !empty($values['lang'])) {
        foreach($values['lang'] as $value) {
          if ($value == "4") {
            print("selected");
            }
          }
        }
        ?> value="4">JavaScript</option>

        <option <?php if (!empty($values) && !empty($values['lang'])) {
        foreach($values['lang'] as $value) {
          if ($value == "5") {
            print("selected");
            }
          }
        }
        ?> value="5">PHP</option>

        <option <?php if (!empty($values) && !empty($values['lang'])) {
        foreach($values['lang'] as $value) {
          if ($value == "6") {
            print("selected");
            }
          }
        }
        ?> value="6">Python</option>

        <option <?php if (!empty($values) && !empty($values['lang'])) {
        foreach($values['lang'] as $value) {
          if ($value == "7") {
            print("selected");
            }
          }
        }
        ?> value="7">Java</option>

        <option <?php if (!empty($values) && !empty($values['lang'])) {
        foreach($values['lang'] as $value) {
          if ($value == "8") {
            print("selected");
            }
          }
        }
        ?> value="8">Haskel</option>

        <option <?php if (!empty($values) && !empty($values['lang'])) {
        foreach($values['lang'] as $value) {
          if ($value == "9") {
            print("selected");
            }
          }
        }
        ?> value="9">Clojure</option>

        <option <?php if (!empty($values) && !empty($values['lang'])) {
        foreach($values['lang'] as $value) {
          if ($value == "10") {
            print("selected");
            }
          }
        }
        ?> value="10">Prolog</option>

        <option <?php if (!empty($values) && !empty($values['lang'])) {
        foreach($values['lang'] as $value) {
          if ($value == "11") {
            print("selected");
            }
          }
        }
        ?> value="11">Scala</option>
      </select> 
    </label><br>

    <label>
      Биография:<br>
      <textarea name="bio">
      <?php if ($errors['bio']) {print 'class="error"';} ?> 
      <?php print $values['bio']; ?> </textarea>
    </label><br>

    <label class=" 
      <?php if ($errors['check-1']) {print "error";} ?>">
      С контрактом ознакомлен(а):
      <input type="checkbox" 
      <?php if (!empty($values['check-1'])) {print('checked');} ?> 
      name="check-1" />
    </label><br>

    <input type="submit" 
    value="Ок" 
    name="button"/>
  </form>

  </body>
</html>
