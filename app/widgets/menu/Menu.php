<?php

namespace app\widgets\menu;

use ishop\Cache;
use ishop\App;

class Menu
{
    protected $data; //Масив данных.
    protected $tree; //Масив дерева который мы будем строить из данных.
    protected $menuHtml; //Готовый код Html меню.
    protected $tpl; //Шаблон меню.
    protected $container = "ul"; //Контейнер в виде списка.
    protected $class = "menu"; //Класс контейнера.
    protected $table = "category"; //Таблица из которой получаем данные.
    protected $cache = 3600; //Время на которое кэшируем данные.
    protected $cacheKey = "ishop_menu"; //Ключ кэша.
    protected $attrs = []; //Пустой массив дополнительных атрибутов.
    protected $prepend = "";

    public function __construct($options = []) //Конструктор получает некие настройки.
    {
        $this->tpl = WWW . "/menu/menu.php"; //Вызываем свойство в которое влажуем путь к шаблону меню. 
        $this->getOptions($options); //Вызываем метод который влажует в соответствующий ключ значение
        $this->run(); //Вызываем метод который формирует страницу.
    }

    protected function getOptions($options) //Метод который принимает некие настройки
    {
        foreach ($options as $k => $v) { // перебираем масив с настройками на ключ и значение.
            if (property_exists($this, $k)) { //Условие: если ключ который мы получили является свойством в этом классе,
                $this->$k = $v; //тогда вызывае ключ (свойство этого класса) влаживаем значение.
            }
        }
    }

    protected function run()
    {
        $cache = Cache::instance(); //Создаем объект кэша.
        $this->menuHtml = $cache->get($this->cacheKey); //Вызываем свойство, в которое влажуем кэш по имени которое лежит в свойстве.
        if (!$this->menuHtml) { //Условие: если мы не получили данные из кэша, 
            $this->data = App::$app->getProperty("cats"); //тогда вызываем масив и влажуем данные из контейнера с категориями.
            if (!$this->data) { //Условие: если мы не получили данные,
                $this->data = $cats = \R::getAssoc("SELECT * FROM {$this->table}"); //тогда в него влажуем данные из таблицы бд которая прописана в свойстве.
            }
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
            if ($this->cache) { //Условие: если свойство активно,
                $cache->set($this->cacheKey, $this->menuHtml, $this->cache); //тогда кэшируем свойство которое является шаблоном меню
            }
        }
        $this->output(); //Вызываем метод.
    }

    protected function output(){
        $attrs = "";
        if(!empty($this->attrs)){
            foreach($this->attrs as $k => $v){
                $attrs .= " $k='$v' ";
            }
        }
        echo "<{$this->container} class='{$this->class}' $attrs>";
            echo $this->prepend;
            echo $this->menuHtml;
        echo "</{$this->container}>";
    }

    protected function getTree()
    {
        $tree = []; //Создаем пустой масив дерева.
        $data = $this->data; //В переменную вкладуем масив с категориями.
        foreach ($data as $id => &$node) { //Перебераем масив на ключ(id) и значение(все остальое с бд) символ & показует что если мы присвоим новое значение переменной то оно сохранится в масив data.
            if (!$node["parent_id"]) { //Условие: если не сушествует отцовского ключа,
                $tree[$id] = &$node; //тогда в масив, в ключ мы вкладуем полученое из цыкла значение (мы можем присвоить другое значение и тогда оно сохранится).
            } else { //В противном случаее,
                $data[$node["parent_id"]]["childs"][$id] = &$node; //Из масива с категориями с значения со столбца отцовского ключа, в масив "дети" под значение ключ мы влажуем значения из масива с категориями. 
            }
        }
        return $tree; //возвращаем полученое дерево.
    }

    protected function getMenuHtml($tree, $tab = "") //Метод с параметрами для создания дерева из масива и со знаком отступа.
    {
        $str = ""; //Переменной присваеваем пустую строку.
        foreach ($tree as $id => $category) { //Перебераем масив дерева на ключ и категории.
            $str .= $this->catToTamplate($category, $tab, $id); //Дополняем переменную методом который возвращает шаблон меню и он получает данные из перебраного масива.
        }
        return $str; //Возвращаем переменную с шаблоном.
    }

    protected function catToTamplate($category, $tab, $id) //Метод с параметрами категории, со знаком отступа и индификатором.
    {
        ob_start();
        require $this->tpl; //подключаем шаблон
        return ob_get_clean(); //Возвращаем его.
    }
}
