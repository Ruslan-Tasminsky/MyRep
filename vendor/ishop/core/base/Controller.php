<?php

namespace ishop\base;

abstract class Controller //Создаем абстрактный класс - это такой класс, который не может быть реализован, то есть, вы не сможете создать объект класса, если он абстрактный. Вместо этого вы создаете дочерние классы от него и спокойно создаете объекты от этих дочерних классов.
{
   public $route;
   public $controller;
   public $model;
   public $view;
   public $prefix;
   public $layout;
   public $data = [];
   public $meta = ["title" => "", "desc" => "", "keywords" => ""];

   public function __construct($route) //Публичный конструктор который принимает текущий маршрут.
   {
      $this->route = $route; //Присваеваем этому свойству текущий маршрут.
      $this->controller = $route["controller"]; //Присваеваем этому свойству имя контроллера в котором она вызывается и которая хранится в свойстве с текущим маршрутом.
      $this->model = $route["controller"]; //
      $this->view = $route["action"]; //Присваеваем этому свойству вторую часть где она была вызвана.
      $this->prefix = $route["prefix"]; //Присваеваем этому свойству префикс (будет либо admin для админской части, либо ничего для пользовательской части).
   }

   public function getView()  //Публичный метод который получает объект вида и вызивать метод для формирования страницы.
   {
      $viewObject = new View($this->route, $this->layout, $this->view, $this->meta); //Создаем объект класса.
      $viewObject->render($this->data); //Вызываем метод который принемает свойство data которое является пустым масивом.
   }

   public function set($data) //Создаем публичный метод который принимает пустой масив. 
   {
      $this->data = $data; //Все что присвоено data свойству присваиваем масиву $data.
   }

   public function setMeta($title = "", $desc = "", $keywords = "") //Создаем публичную функцию в которой параметры принимают пустые значения. 
   {
      $this->meta["title"] = $title; //Все что присвоено свойству meta со значением title присваеваем объекту $meta.
      $this->meta["desc"] = $desc; //Все что присвоено свойству meta со значением desc присваеваем объекту $meta.
      $this->meta["keywords"] = $keywords; //Все что присвоено свойству meta со значением keywords присваеваем объекту $meta. 
   }
}
