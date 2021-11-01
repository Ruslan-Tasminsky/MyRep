<?php

namespace app\controllers;

class CurrencyController extends AppController
{
    public function changeAction() //Создаем публичный метод
    {
        $currency = !empty($_GET["curr"]) ? $_GET["curr"] : null; //В переменную вкладуем условие: если непуст гет параметр со значением валюты, тогда берем его. В противном случае берем 0.
        if($currency){ //Условие: если существует гет параметр,
            $curr = \R::findOne("currency", "code = ?", [$currency]); //тогда в переменную вкладуем запрос на получение требуемой валюты.
            if(!empty($curr)) {//Условие: если непуст запрос валюты,
                setcookie("currency", $currency, time() + 3600*24*7, "/"); //тогда добавляем её в куки под названием ..., со значением ..., на время ..., для домена ...
            }
        }
        redirect(); //Используем метод переадрессации на запращуему страницу.
    }
}