<?php
$dis_email = htmlspecialchars($email);
$email_parts = explode('@', $dis_email);
?>
<a href="javascript:void(0)"><h3 class="found-distributor-name"><?=htmlspecialchars($post->post_title);?></h3></a>
<div class="found-distributor-address">
	<div class="found-distributor-street-address"><?=htmlspecialchars($address);?></div>
	<div class="found-distributor-city"><?=htmlspecialchars($city);?></div>
	<div>
		<?php	if (!is_null($territorial_unit)):	?>
		<span class="found-distributor-territorial-unit"><?=htmlspecialchars($territorial_unit);?></span>
		<?php	endif;	?>
		<span class="found-distributor-country"><?=htmlspecialchars($country);?></span>
	</div>
</div>
<div style="" class="found-distributor-contact"><?=htmlspecialchars($first_name);?> <?=htmlspecialchars($last_name);?></div>
<div class="found-distributor-phone"><?=htmlspecialchars($phone);?></div>
<div class="found-distributor-web">
	<?php if (count($email_parts) == 2) : ?>
	<a href="mailto:<?=htmlspecialchars($email);?>" ><?=htmlspecialchars($email);?></a>
	<?php	endif;	?>
	<?php if (strlen($website) > 3) : ?>
		<span class="seperator"> | </span>
		<a target="_blank" href="http://<?=str_replace('http://','',htmlspecialchars($website));?>">Website</a>
	<?php	endif;	?>
</div>
<div class="found-distributor-tags"><?=htmlspecialchars($tags);?></div>
<?php	if ($post->post_content!==''):	?>
<div class="found-distributor-description"><?=$post->post_content?></div>
<?php	endif;	?>