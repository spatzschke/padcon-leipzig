<div id="news">
	<?php
	foreach ($news as $news):
	?>
    <p class="contentParagraph"><?php echo $news['News']['contentParagraph']; ?></p>
    <?php endforeach; ?>
</div>