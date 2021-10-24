<?php

namespace ishop; //Прописуем пространство имен.

class Db //Создаем класс.
{
   use TSingletone; //Используем трейт который создает объект класса.

   protected function __construct() //Создаем защищенный конструктор.
   {
      $db = require_once CONF . "/config_db.php"; //Подключаем файл с данными для подключения к бд.
      class_alias("\RedBeanPHP\R", "\R"); //Сокращаем обращение к библиотеке.
      \R::setup($db["dsn"], $db["user"], $db["password"]); //Получаем настройки бд.

      if(!\R::testConnection()){ //Условие: если есть проблемы при подключении к бд,
         throw new \Exception("No connection with database", 500); //тогда выбрасуем исключение.
      }
      \R::freeze(true); //Отменяем заморозку бд.
      if(DEBUG){ //Условие: если проект находится в режиме разроботки,
         \R::debug(true, 1); //тогда показуем все ошибки и тд и тп.
      }
   }
}