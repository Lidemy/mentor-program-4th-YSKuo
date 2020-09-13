<div class="paginator">
  <div class="paginator-left">
    <?php if ($page != 1) { ?>
      <a href="index.php?page=<?php echo escape($page-1) ?>"><button class="blue-button">Previous</button></a>
    <?php }?>     
  </div>

  <div class="paginator-center">
    <?php if ($page != 1) { ?>
      <a href="index.php?page=1"><?php echo 1 ?></a>
      <span>...</span>
    <?php }?>

    <?php if ($page - 1 > 1) { ?>
      <a href="index.php?page=<?php echo escape($page-1) ?>"><?php echo escape($page-1) ?></a>
    <?php } ?>
    <span class="current-page"><?php echo escape($page) ?></span>
    <?php if ($page + 1 < $total_page) { ?>
      <a href="index.php?page=<?php echo escape($page+1) ?>"><?php echo escape($page+1) ?></a>
    <?php } ?>

    <?php if ($page != $total_page) { ?>
      <span>...</span>
      <a href="index.php?page=<?php echo escape($total_page) ?>"><?php echo escape($total_page) ?></a>
    <?php } ?>
  </div>
  <div class="paginator-right">
    <?php if ($page != $total_page) { ?>
      <a href="index.php?page=<?php echo escape($page+1) ?>"><button class="blue-button">Next</button></a>
    <?php }?>    
  </div>
</div>