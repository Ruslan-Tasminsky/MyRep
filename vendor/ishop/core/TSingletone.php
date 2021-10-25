<?php

namespace ishop; //Прописуем пространство имен.

trait TSingletone //Создаем трейт для создания объекта класса только 1 раз.
{
   private static $instance; //Создаем приватное статичное свойство для создания объекта класса.

   public static function instance() //Создаем публичный статичный метод.
   {
      if (self::$instance === null) { //Условие: если свойство $instance равно 0,
         self::$instance = new self; //тогда свойство $instance ложим объект данного класса.
      }
      return self::$instance; //Возвращаем свойство $instance.
   }
}
