<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <?= $this->getMeta(); ?>
</head>

<body>
   <h1>Шаблон DEFAULT</h1>

    <?= $content; ?> <!-- Подключаем динамическую часть. -->

    <?php  
      $logs = \R::getDatabaseAdapter()->getDatabase()->getLogger(); //Устанавливает адаптер базы данных, который вы хотите использовать; находим нашу бд; и находим таблицу.

      debug($logs->grep("SELECT")); //Распечатываем все что получили.
    ?>
</body>

</html>