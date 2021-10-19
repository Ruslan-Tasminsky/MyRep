<?php

require_once dirname(__DIR__) . "/config/init.php"; //Подключаем файл с константами.
require_once LIBS . "/functions.php"; //Подключаем файл с дебагом.
require_once CONF . "/routes.php"; //Подключаем файл с правилами для маршрутизатора.

new \ishop\App(); //Создаем экземпляр класса.
