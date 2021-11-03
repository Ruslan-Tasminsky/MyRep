<?php

namespace app\controllers; //Прописуем пространство имен.

use app\models\AppModel; //Используем модель.
use app\widgets\Currency\Currency;
use ishop\App;
use ishop\base\Controller; //Используем базовый контроллер.
use ishop\Cache;

class AppController extends Controller //Создаем класс который наследует класс базового контоллера.
{
    public function __construct($route)  //Создаем публичный метод с конструктором и с параметром текущего марщрута.
    {
        parent::__construct($route); //Подключаем родительский конструктор.
        new AppModel(); //Создаем объект модели.
        App::$app->setProperty("currencies", Currency::getCurrencies()); //Обращаемся к классу App, к объкту реестра $app и к методу setProperty который запишет ключ, значение и передаст в метод который вернет все доступные ему данные.
        App::$app->setProperty("currency", Currency::getCurrency(App::$app->getProperty("currencies")));
        App::$app->setProperty("cats", self::cacheCategory()); //Обращаемся к классу App, к объкту реестра $app и к методу setProperty который запишет ключ, значение и передаст в метод который вернет все доступные ему данные.
    }

    public static function cacheCategory()//Создаем публичный статичный метод. 
    {
        $cache = Cache::instance(); //Создаем объкт класа кэша.
        $cats = $cache->get("cats"); //Получаем данные из кэша категории.
        if(!$cats) { //Условие: если мы неполучили данные из кэша,
            $cats = \R::getAssoc("SELECT * FROM category"); //тогда получаем их из бд. 
            $cache->get("cats", $cats); //И опять кладем их в кэш.
        }
        return $cats; //Возвращаем полученые данные.
    }
}