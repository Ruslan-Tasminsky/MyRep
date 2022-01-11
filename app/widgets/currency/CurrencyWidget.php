<?php

namespace app\widgets\currency;

use ishop\App;

class CurrencyWidget
{

    protected $tpl;
    protected $currencies;
    protected $currency;

    public function __construct() //Описываем конструктор.
    {
        $this->tpl = __DIR__ . "/currency_tpl/currency.php"; //Вызиваем и в свойство вкладуем путь к выпадающему списку валют.
        $this->run(); //Вызиваем метод.
    }

    protected function run() //Создаем защищенный метод
    {
        $this->currencies = App::$app->getProperty("currencies"); //Вызываем свойство со всеми валютами присваемаем методу который возвращает параметр который мы передаем.
        $this->currency = App::$app->getProperty("currency"); //Вызываем свойство с текущей валютой присваемаем методу который возвращает параметр который мы передаем.
        echo $this->getHtml(); //Выводим метод.
    }

    public static function getCurrencies() //Создаем публичный статичный метод.
    {
        return \R::getAssoc("SELECT code, title, symbol_left, symbol_right, value, base FROM currency ORDER BY base DESC"); //Возвращаем масив с валютами из бд.
    }

    public static function getCurrency($currencies)//Создаем публичный статичный метод с всеми валютами.
    {
        if (isset($_COOKIE["currency"]) && array_key_exists($_COOKIE["currency"], $currencies)) { //Условие: если сществует кука под названием currency и он также является ключем масива с валютами.
            $key = $_COOKIE["currency"]; //тогда в переменную вкладуем куки currency.
        } else { //В противном случаее,
            $key = key($currencies); //Берем первый ключ из масива с валютами.
        }
        $currency = $currencies[$key]; //В переменную вкладуем полученый ключ из всех валют.
        $currency["code"] = $key; //В переменную со здачением код из бд вкладуем полученый ключ. 
        return $currency; //Возвращаем переменную с текущей валютой.
    }

    protected function getHtml() //Создаем защищенный метод
    {
        ob_start(); //Стартуем буферизацию.
        require_once $this->tpl; //Подключаем путь к выпадающему списку валют.
        return ob_get_clean(); //Возвращаем отчистку буфера.
    }
}
