<?php if($this->Paginator->numbers()){ ?>
<nav>
  <ul class="pagination">
    <li>
      <span aria-hidden="true"><?php echo $this->Paginator->prev('<<', array(), null, array('class' => 'prev disabled')); ?></span>
    </li>
    <?php echo $this->Paginator->numbers(array('before' => '<li>', 'after' => '</li>', 'separator' => '')); ?>
    <li>
        <span aria-hidden="true"><?php echo $this->Paginator->next(' >>', array(), null, array('class' => 'next disabled')); ?></span>
     
    </li>
  </ul>
</nav>
<?php } ?>