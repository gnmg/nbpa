<!-- pager -->
<ul class="pagination pagination-sm">
  <?php if ($pager->hasPrev()): ?>
  <li><a href="<?php echo h($pager->prevPath()); ?>">&laquo;</a></li>
  <?php else: ?>
  <li class="disabled"><a href="#">&laquo;</a></li>
  <?php endif; ?>
  <li class="disabled"><a href="#">
      <?php echo h($pager->from()); ?> -
      <?php echo h($pager->to()); ?> /
      <?php echo h($pager->count); ?> </a></li>
  <?php if ($pager->hasNext()): ?>
  <li><a href="<?php echo h($pager->nextPath()); ?>">&raquo;</a></li>
  <?php else: ?>
  <li class="disabled"><a href="#">&raquo;</a></li>
  <?php endif; ?>
</ul>
<!-- /pager -->