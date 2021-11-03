<?php //$parent = isset($category['childs']); // вкладуем существующего ребенка?>
<li>
    <a href="category/<?=$category['alias'];?>"><?=$category['title']; // выводим ввиде ссылки?></a>
    <?php if(isset($category['childs'])): ?>
        <ul>
            <?= $this->getMenuHtml($category['childs']);//если существует ребенок, вызываем его в список?>
        </ul>
    <?php endif; ?>
</li>