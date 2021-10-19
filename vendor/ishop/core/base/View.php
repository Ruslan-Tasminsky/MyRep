<?php

namespace ishop\base;

class View
{
   public $route;
   public $controller;
   public $model;
   public $view;
   public $prefix;
   public $layout;
   public $data = [];
   public $meta = [];

   public function __construct($route, $layout = "", $view = "", $meta) //Публичный конструктор который принимает текущий маршрут, два пустых параметра и пустой масив.
   {
      $this->route = $route; //Присваеваем этому свойству текущий маршрут.
      $this->controller = $route["controller"]; //Присваеваем этому свойству имя контроллера в котором она вызывается и которая хранится в свойстве с текущим маршрутом.
      $this->model = $route["controller"]; //
      $this->view = $view; //Присваеваем этому свойству то что было присвоено параметру который принял конструктор.
      $this->prefix = $route["prefix"]; //Присваеваем этому свойству префикс (будет либо admin для админской части, либо ничего для пользовательской части).
      $this->meta = $meta; //Присваеваем этому свойству пустой масив.

      if ($layout === false) { //Условие: если параметр $layout строго равен false (пустая строка в этом случаее false-ом не счетается),
         $this->layout = false; //тогда свойство layout также равняем false.
      } else { //В противном случаее,
         $this->layout = $layout ?: LAYOUT; //если в параметр $layout передан шаблон мы возьмем его, в противном случаее (если передана пустая строка) берем значение константы LAYOUT и присваеваем это свойству layout.
      }
   }

   public function render($data) //Публичный метод который будет формировать страницу для пользователя, также он принимает данные переданые в переменную и вызивать будем его в классе Controller.
   {
      $viewFile = APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php"; //Путь к файлу с видом присваеваем переменной. 

      if (is_file($viewFile)) { //Условие: если $viewFile является файлом,
         ob_start(); //Стартуем буферизацию.
         require_once $viewFile; //тогда подключаем его.
         $content = ob_get_clean(); //Присваеваем данные из буфера переменной и очищаем буфер (это для того что вид нам сразу не нужен, сначала нам нужно вставить его в шаблон).
      } else { //В противном случаее,
         throw new \Exception("View {$viewFile} not found", 500); //Выбрасываем исключение.
      }

      if (false !== $this->layout) { //Условие: если свойство layout тоесть шаблон, не является false-ом,
         $layoutFile = APP . "/views/layouts/{$this->layout}.php"; //тогда переменной присваеваем путь к шаблону
         if (is_file($layoutFile)) { //и делаем условие: если переменная $layoutFile является файлом,
            require_once $layoutFile; //тогда подключаем его,
         } else { //в противном случаее,
            throw new \Exception("Layout {$this->layout} not found, 500"); //выбрасывем исключение.
         }
      }
   }

   public function getMeta() //Создаем публичный метод который будет подключать в разметку DOCTYPE нужные данные.
   {
      $output = '<title>' . $this->meta["title"] . '</title>';
      $output .= '<meta name="description" content="' . $this->meta["desc"] . '">';
      $output .= '<meta name="keywords" content="' . $this->meta["keywords"] . '">';
      return $output;
   }
}
