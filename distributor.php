<h3 class="found-distributor-name"><?=htmlspecialchars($post->post_title);?></h3>
<div class="found-distributor-address">
	<ul>
		<li class="found-distributor-street-address"><?=htmlspecialchars($address);?></li>
		<li class="found-distributor-city"><?=htmlspecialchars($city);?></li>
		<?php	if (!is_null($territorial_unit)):	?>
		<li class="found-distributor-territorial-unit"><?=htmlspecialchars($territorial_unit);?></li>
		<?php	endif;	?>
		<li class="found-distributor-country"><?=htmlspecialchars($country);?></li>
	</ul>
</div>
<?php	if ($post->post_content!==''):	?>
<div class="found-distributor-description"><?=$post->post_content?></div>
<?php	endif;	?>