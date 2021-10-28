<?php

namespace app\controllers; //Прописуем пространство имен.

use ishop\Cache;

class MainController extends AppController //Создаем класс который наследует класс AppController.
{
   public function indexAction() //Создаем публичный метод.
   {
      $brands = \R::find("brand", "LIMIT 3"); //Из бд выбираем таблицу и первых 3 елемента.
      $hits = \R::find("product", "hit = '1' AND status = '1' LIMIT 8"); //Из бд выбираем таблицу и первых 3 елемента.
      $this->setMeta("Home page", "description", "keywords"); //В функцию базавого контроллера записываем данные.
      $this->set(compact("brands", "hits")); //компактируем и отправляем в вид масив.
   }
}
