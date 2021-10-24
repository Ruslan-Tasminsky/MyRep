<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ошибка</title>
</head>
<body>

   <h1>Произошла ошибка!</h1> <!-- Выводим ошибки. -->
   <p><b>Код ошибки: </b><?= $errno . "."; ?></p> <!-- Выводим код ошибки. -->
   <p><b>Текст ошибки: </b><?= $errstr . "."; ?></p> <!-- Выводим текст ошибки. -->
   <p><b>Файл, в котором произошла ошибка: </b><?= $errfile . "."; ?></p> <!-- Выводим файл где произошла ошибка. -->
   <p><b>Строка, в которой произошла ошибка: </b><?= $errline . "."; ?></p> <!-- Выводим строку где произошла ошибка. -->
</body>
</html>