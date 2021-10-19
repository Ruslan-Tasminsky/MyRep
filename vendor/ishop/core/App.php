<?php

namespace ishop; //Прописуем пространство имен.

class App //Создаем класс.
{
   public static $app; //Создаем публичное статичное свойство.

   public function __construct() //Создаем публичный метод с конструктором.
   {
      $query = trim($_SERVER['QUERY_STRING'], "/"); //Свойство которое регестрирует все символы в адрессной строке (кроме слэша), которые находятся после url главной страницы. 
      session_start(); //Стартуем сессию.
      self::$app = Registry::instance(); //В контейнер ложим объект нашего регестра.
      $this->getParams(); //Обращаемся к методу.
      new ErrorHendler(); //Создаем экземпляр класса с выводом ошибок.
      Router::dispatch($query); //Обращаемся к методу dispatch со свойством $query.
   }

   protected function getParams() //Создаем защищенный статичный метод.
   {
      $params = require_once CONF . "/params.php"; //В свойство $params подключаем файл params.php.
      if (!empty($params)) { //Условие: если свойство $params непусто,
         foreach ($params as $k => $v) { //тогда пройдемся в цикле где нам нужно получить отдельно ключ и отдельно значение. 
            self::$app->setPropetry($k, $v); //Обращаемся к методу и кладем в них ключ и значение (заполняем в цикле контейнер).
         }
      }
   }
}
