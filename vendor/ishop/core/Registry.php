<?php

namespace ishop; //Прописуем пространство имен.

class Registry //Создаем класс.
{
   use TSingletone; //Используем трейт TSingletone.

   protected static $properties = []; //Создаем защищенное статичное свойство.

   public function setProperty($name, $value) //Создаем публичный статичный метод со значениями $name и $value.
   {
      self::$properties[$name] = $value; //Обращаемся к свойству $properties к его значению $name и присваиваем ему значение $value.
   }

   public static function getProperty($name) //Создаем публичный статичный метод со значением $name.
   {
      if (isset(self::$properties[$name])) { //Условие: если свойство $properties со значением $name существует,
         return self::$properties[$name]; //тогда возвращаем его.
      }
      return null; //В противном случаее возвращаем 0.
   }

   public static function getProperties() //Создаем публичный статичный метод.
   {
      return self::$properties; //Возвращаем все доступные свойства для дебага.
   }


}
