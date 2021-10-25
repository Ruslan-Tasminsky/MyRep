<?php

namespace app\controllers; //Прописуем пространство имен.

use ishop\Cache;

class MainController extends AppController //Создаем класс который наследует класс AppController.
{
   public function indexAction() //Создаем публичный метод.
   {
      $posts = \R::findAll("test"); //Получаем все из таблицы в бд.
      $this->setMeta("Home page", "description", "keywords"); //В функцию базавого контроллера записываем данные.
      $name = "Ruslan"; //Присваеваем переменной значенние.
      $age = 14; //Присваеваем переменной значенние.
      $names = ["Illa", "Jonah"]; //Присваеваем переменной масив со значенниями.
      $cache = Cache::instance(); //Создаем объект класса.
      //$cache->set("test", $names); 
      //$cache->delete("test");
      $data = $cache->get("test"); //Получаем данные из кэша в переменную.
      if(!$data){ //Условие: если нечего получать,
         $cache->set("test", $names);  //тогда кладем в кэш масив.
      }
      debug($data); 
      $this->set(compact("name", "age", "names", "posts")); //Компактируем выше перечислиные данные и отпраляем в функцию базавого контроллера которая принимает пустой масив.
   }
}
