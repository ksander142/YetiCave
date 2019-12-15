
<?php if ($pages_count > 1 ) :?>
    <div class="pagination-list">
        <ul class="pagination-list">

            <?php foreach ($pages as $page) :?>
                <li class="pagination-item <?php if ($page == $current_page): ?>pagination-item-active<?php endif;?> ">
                    <a href="search.php?search=<?=$search;?>&find=Найти&page=<?=$page;?>"><?=$page;?></a>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif;?>