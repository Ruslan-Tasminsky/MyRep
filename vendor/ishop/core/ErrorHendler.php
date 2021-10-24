<?php

namespace ishop; //Прописуем пространство имен.

class ErrorHendler //Создаем класс.
{
   public function __construct() //Создаем публичный метод с конструктором.
   {
      if (DEBUG) { //Условие: если константа DEBUG имеет значение 1, тоесть проект находится в режиме разработки, 
         error_reporting(-1); //тогда выводим все ошибки.
      } else { //В противном случаее,
         error_reporting(0); //выключаем вывод ошибок.
      }
      set_exception_handler([$this, "exceptionHendler"]); //При помощи этой функции назначаем функцию которая будет обрабатывать ошибки, $this значит что функция находится в этом классе.
   }

   public function exceptionHendler($e) //Создаем публичный метод с объектом внутри.
   {
      $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine()); //Обращаемся к методу логирования ошибок присваиваем их объекту $e.
      $this->displayError("Исключение", $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode()); //Обращаемся к методу вывода ошибок и передаем ему значения объекта $e.
   }

   public function logErrors($message = '', $file = '', $line = '')  //Создаем публичный метод с параметрами которые имеют пустые значения.
   {
      error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$message} | Файл: {$file} | Строка: {$line} \n-----------------------------------------------------------------------------------------------------------------------\n", 3, ROOT . "/tmp/errors.log"); //Функция которая обрабатует ошибки: время, текст, файл и строка где она произошла, а также добавляем переносы строк и ставим разделитель, 3 говорит о том что мы хотим добавить её в файл и указываем путь к нему.
   }

   public function displayError($errno, $errstr, $errfile, $errline, $responce = 404) //Создаем публичный метод с объектами со значениями.
   {
      http_response_code($responce); //Отправляет код ошибки который зарегистрировал параметр $responce.
      if ($responce == 404 && !DEBUG) { //Условие: если зарегистрированая ошибка равна ошибке 404 и константа DEBUG имеет значение 0, тоесть выключен показ ошибок, 
         require WWW . "/errors/404.php"; //тогда подключаем файл с красивым выводом ошибок (404.php).
         die(); //Завершаем выполнение кода.
      }
      if (DEBUG) { //Условие: если константа DEBUG активна (находимся в режиме разработки),
         require WWW . "/errors/dev.php"; //тогда подключаем файл с ошибками для разработчика (dev.php).
      } else { //В противном случае,
         require WWW . "/errors/prod.php"; //подключаем файл с ошибками для пользователя (prod.php).
         die(); //Завершаем выполнение кода.
      }
   }
}