<h1>Hello</h1>
<p><?= $name; ?></p> <!-- Выводим переменную. -->
<p><?= $age; ?></p> <!-- Выводим переменную. -->
<?= debug($names); ?> <!-- Распичатываем масив. -->
<?php foreach($posts as $post): ?> <!-- Перебираем таблицу бд на отдельные столбцы. -->
    <h3><?= $post->title; ?></h3> <!-- Из таблицы бд выводим столбец title. -->
<?php endforeach; ?> <!-- Завершаем цикл. -->   