<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3</title>
</head>
<body>

    <form action="index.php"
        method="POST">

        <label>
            ФИО: <br />
            <input name="fio"
            type="text"
            placeholder="Введите ваше ФИО" />
        </label> <br />

        <label id = "telephone"> 
            Номер телефона: <br />
            <input name="tel"
            type="tel"
            placeholder="Введите ваш номер" />
        </label> <br />
        
        <label>
            Email: <br />
            <input name="email"
            type="email"
            placeholder="Введите вашу почту" />
        </label> <br />
        
        <label>
            Дата рождения: <br />
            <select name="year">
            <?php 
            for ($i = 1922; $i <= 2022; $i++) {
            printf('<option value="%d">%d год</option>', $i, $i);
            }
            ?>
            </select>

            <select name="month">
            <?php 
            for ($i = 1; $i <= 12; $i++) {
            printf('<option value="%d">%d месяц</option>', $i, $i);
            }
            ?>
            </select>

            <select name="day">
            <?php 
            for ($i = 1; $i <= 31; $i++) {
            printf('<option value="%d">%d день</option>', $i, $i);
            }
            ?>
            </select>
        </label> <br />
        
        <label>
            Пол: <br />
            <input type="radio" 
            name="radio1" value="woman" />
            Женский</label>
        <label>
            <input type="radio"
            name="radio1" value="man" />
            Мужской</label> <br />

        <label>
        Любимый язык программирования: <br />
        <select name="lang[]"
        multiple="multiple">
        <option value="1">Pascal</option>
        <option value="2">C</option>
        <option value="3">C++</option>
        <option value="4">JavaScript</option>
        <option value="5">PHP</option>
        <option value="6">Python</option>
        <option value="7">Java</option>
        <option value="8">Haskel</option>
        <option value="9">Clojure</option>
        <option value="10">Prolog</option>
        <option value="11">Scala</option>
        </select>
        </label> <br />

        <label>
            Биография: <br />
            <textarea name="bio">Я программист</textarea>
        </label> <br />
        
        <label>
            С контрактом ознакомлен(а): <br />
            <input type="checkbox"
            name="check-1" />
        </label> <br />

        <label>
            <input type="submit" value="Сохранить"
            name="button" />
        </label> <br />

    </form>

</body>
</html>