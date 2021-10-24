<?php

namespace app\controllers; //Прописуем пространство имен.

use app\models\AppModel; //Используем модель.
use ishop\base\Controller; //Используем базовый контроллер.

class AppController extends Controller //Создаем класс который наследует класс базового контоллера.
{
    public function __construct($route)  //Создаем публичный метод с конструктором и с параметром текущего марщрута.
    {
        parent::__construct($route); //Подключаем родительский конструктор.
        new AppModel(); //Создаем объект модели.
    }
}