<li>
    <a href="?id=<?=$id;?>"><?=$category["title"];?></a>
    <?php if(isset($category["childs"])): ?>
        <ul>
            <?= $this->getMenuHtml($category["childs"]);//если существует ребенок, вызываем его в список?> 
        </ul>
    <?php endif; ?>
</li>