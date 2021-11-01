<?php

namespace app\controllers; //Прописуем пространство имен.

use app\models\AppModel; //Используем модель.
use app\widgets\Currency\Currency;
use ishop\App;
use ishop\base\Controller; //Используем базовый контроллер.


class AppController extends Controller //Создаем класс который наследует класс базового контоллера.
{
    public function __construct($route)  //Создаем публичный метод с конструктором и с параметром текущего марщрута.
    {
        parent::__construct($route); //Подключаем родительский конструктор.
        new AppModel(); //Создаем объект модели.
        App::$app->setProperty("currencies", Currency::getCurrencies()); //Обращаемся к классу App, к объкту реестра $app и к методу setProperty который запишет ключ, значение и передаст в метод который вернет все доступные ему данные.
        App::$app->setProperty("currency", Currency::getCurrency(App::$app->getProperty("currencies")));
        
        
    }
}