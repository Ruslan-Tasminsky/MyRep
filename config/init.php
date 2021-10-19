<?php

define("DEBUG", 1); //Константа режима разработки, 1 режим где мы видим все ошибки.
define("ROOT", dirname(__DIR__)); //Константа указывает на корень нашего сайта.
define("WWW", ROOT . "/public"); //Константа указывает на папку public.
define("APP", ROOT . "/app"); //Константа указывает на папку app.
define("CORE", ROOT . "/vendor/ishop/core"); //Константа указывает на папку core.
define("LIBS", ROOT . "/vendor/ishop/core/libs"); //Константа указывает на папку libs.
define("CACHE", ROOT . "/tmp/cache"); //Константа указывает на папку cache.
define("CONF", ROOT . "/config"); //Константа указывает на папку config.
define("LAYOUT", "default"); //Константа с шаблоном сайта поумолчанию (если шаблон нужно изменить, тогда меняем "default" на значение с иным шаблоном).

//http://ishop.loc/public/index.php
$app_path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}"; //Получаем данные из адрессной строки.
//http://ishop.loc/public/
$app_path = preg_replace("#[^/]+$#", '', $app_path); //Ишем все кроме слэша, начиная с конца строки и заменяяем пустой строкой.
//http://ishop.loc
$app_path = str_replace("/public/", '', $app_path); //Ишем строку /public/ и заменяяем пустой строкой, в итоге получаем url главной страницы.

define("PATH", $app_path); //Константа в которую записана переменная $app_path.
define("ADMIN", PATH . '/admin'); //Константа которая ведет на админку сайта.

require_once ROOT . "/vendor/autoload.php"; //Подключаем автозагрузчик композера.