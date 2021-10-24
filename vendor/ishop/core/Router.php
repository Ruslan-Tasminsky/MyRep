<?php

namespace ishop;

class Router
{
   protected static $routes = []; //Создаем защищенное статичное свойство с пустым масивом, в который будем записывать все маршруты сайта.
   protected static $route = []; //Создаем защищенное статичное свойство с пустым масивом, в который будет хранится текуший маршрут.

   public static function add($regexp, $route = []) //Создаем публичный статичный метод с объектами $regexp и $route = [].
   {
      self::$routes[$regexp] = $route; //Записуем в масив $routes с ключем $regexp соответствие для данного маршрута.
   }

   public static function getRoutes() //Создаем публичный статичный метод.
   {
      return self::$routes; //Возвращаем таблицу маршрутов.
   }

   public static function getRoute() //Создаем публичный статичный метод.
   {
      return self::$route; //Возвращает текущий маршрут.
   }

   public static function dispatch($url) //Создаем публичный статичный метод с объектом $url (который является url адресм).
   {
      $url = self::removeQueryString($url); //Параметру $url присваеваем метод.
      if (self::matchRoute($url)) { //Условие: если метод matchRoute нашел маршрут,
         $controller = "app\controllers\\" . self::$route["prefix"] . self::$route["controller"] . "Controller"; //$controller присваеваем путь к папке с контролерами. self::$route["prefix"] это нужно для админской части. self::$route["controller"], а это имя контроллера который нам нужен. "Controller" постфикс для вызова праильных классов.  
         if (class_exists($controller)) { //Условие: если класс $controller существует,
            $controllerObject = new $controller(self::$route); //тогда мы создаем его объект и передаем в него текущий маршрут, в котором содержатся складовые url.
            $action = self::lowerCameCase(self::$route["action"]) . "Action"; //Берем метод lowerCameCase, влажуем в него значене action и конкатенируем строку Action, после этого присваеваем переменной $action.
            if (method_exists($controllerObject, $action)) { //Условие: если метод $controllerObject, $action существует,
               $controllerObject->$action(); //тогда вызываем данный метод.
               $controllerObject->getView(); //Вызиваем метод который формирует страницу.
            } else { //В противном случае,
               throw new \Exception("Method $controller::$action not found", 404); //Выбрасуем исключение.
            }
         } else { //В противном случаее,
            throw new \Exception("Controller $controller not found", 404); //Выбрасуем исключение.
         }
      } else { //В противном случаее,
         throw new \Exception("Page not found", 404); //Выбрасуем исключение.
      }
   }

   public static function matchRoute($url) //Создаем публичный статичный метод с объектом $url (который является url адресм).
   {
      foreach (self::$routes as $pattern => $route) { //Перебераем масив $routes на кличи $pattern со значением $route.
         if (preg_match("#{$pattern}#", $url, $matches)) { //Условие: функция preg_match берет шаблон $pattern и если есть совпадение с переданым url адрессом тогда помешяем его в $matches,
            foreach ($matches as $k => $v) { //Перебераем масив $matches на ключ $k со значением $v.
               if (is_string($k)) { //Условие: если $k строка, 
                  $route[$k] = $v; //тогда делаем её значением значения $route присваеваем её $v.
               }
            }
            if (empty($route["action"])) { //Условие: если значение $route["action"](вторая часть url) пустая,
               $route["action"] = "index"; //тогда $route["action"] присваеваем ключ index.
            }

            if (!isset($route["prefix"])) { //Условие: если $route["prefix"] несуществует,
               $route["prefix"] = ""; //тогда создаем её и присваеваем пустую строку.
            } else { //В противном случаее,
               $route["prefix"] .= "\\"; //Добавляем к $route["prefix"] обратный слэш.
            }
            $route["controller"] = self::upperCameCase($route["controller"]); //Из текущего маршрута выбираем часть controller и присваеваем ей её же только уже обработаную функцией.
            self::$route = $route; //Значение $route которое мы получили в этом присваеваем текущему маршруту.
            return true;
         }
      }
      return false;
   }

   protected static function upperCameCase($name) //Защищенный статичный метод c объектом $name. Данный метод нужен для изменения наименования имен контроллеров (чтоб они были с большой буквы).
   {
      return str_replace(" ", "", ucwords(str_replace("-", " ", $name))); //Используя функцию ucwords делаем все символы в нижнем регистре, после ищем дифис и заменяем его на пробел в переменной $name. Потом в начале мы ищем пробел и заменяем его на пустую строку и возвращаем значение.
      debug($name);
   }

   protected static function lowerCameCase($name) //Защищенный статичный метод c объектом $name. Данный метод нужен для изменения наименования имен actions (чтоб они были с маленькой буквы).
   {
      return lcfirst(self::upperCameCase($name)); //Берем результат выполнения метода upperCameCase и используя функцию делаем все символы в нижнем регистре, после чего возвращаем значение. 
   }

   protected static function removeQueryString($url) //Создем защищенный статичный метод который принимает параметр $url.
   {
      if ($url) { //Условие: если в адрессной строке что-то есть,
         $params = explode("&", $url, 2); //тогда ищем символ & в url и разделяем его по этому символу на две части.
         if (false === strpos($params[0], "=")) { //И проверяе: если в первой части url полученой из $params нет знака =,
            return rtrim($params[0], "/"); //тогда возвращаем первую часть $params url и отсекаем слэш.
         } else { //В противном случаее,
            return ""; //возращаем пустую строку.
         }
      }
   }
}
