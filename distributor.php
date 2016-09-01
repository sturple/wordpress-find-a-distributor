<h3 class="found-distributor-name"><?=htmlspecialchars($post->post_title);?></h3>
<div class="found-distributor-address">
	<div class="found-distributor-street-address"><?=htmlspecialchars($address);?></div>
	<div class="found-distributor-city"><?=htmlspecialchars($city);?></div>
	<?php	if (!is_null($territorial_unit)):	?>
	<div class="found-distributor-territorial-unit"><?=htmlspecialchars($territorial_unit);?></div>
	<?php	endif;	?>
	<div class="found-distributor-country"><?=htmlspecialchars($country);?></div>
</div>
<?php	if ($post->post_content!==''):	?>
<div class="found-distributor-description"><?=$post->post_content?></div>
<?php	endif;	?>