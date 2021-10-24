<?php

namespace app\controllers; //Прописуем пространство имен.

class MainController extends AppController //Создаем класс который наследует класс AppController.
{
   public function indexAction() //Создаем публичный метод.
   {
      $posts = \R::findAll("test"); //Получаем все из таблицы в бд.
      $this->setMeta("Home page", "description", "keywords"); //В функцию базавого контроллера записываем данные.
      $name = "Ruslan"; //Присваеваем переменной значенние.
      $age = 14; //Присваеваем переменной значенние.
      $names = ["Illa", "Jonah"]; //Присваеваем переменной масив со значенниями.
      $this->set(compact("name", "age", "names", "posts")); //Компактируем выше перечислиные данные и отпраляем в функцию базавого контроллера которая принимает пустой масив.
   }
}
