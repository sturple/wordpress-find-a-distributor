<?php

require_once(__DIR__.'/../../../wp-load.php');
call_user_func(function () {
	set_time_limit(120);
	$arr=require(__DIR__.'/vmac_ssf_wp_stores.php');
	foreach ($arr as $dist) {
		//	Core post stuff (title/name & content/description)
		$post=[
			'post_title' => $dist['ssf_wp_store'],
			'post_content' => $dist['ssf_wp_description'],
			'post_type' => 'distributor',
			'post_status' => 'publish',
			'comment_status' => 'closed',
			'ping_status' => 'closed'
		];
		$id=wp_insert_post($post);
		if ($id instanceof \WP_Error) throw new \RuntimeException(implode(', ',$id->get_error_messages()));
		if ($id===0) throw new \RuntimeException('wp_insert_post failed');
		//	Add metadata
		update_post_meta($id,'fgms-distributor-address',$dist['ssf_wp_address']);
		update_post_meta($id,'fgms-distributor-city',$dist['ssf_wp_city']);
		update_post_meta($id,'fgms-distributor-territorial-unit',$dist['ssf_wp_state']);
		update_post_meta($id,'fgms-distributor-country',$dist['ssf_wp_country']);
		update_post_meta($id,'fgms-distributor-postal-code',$dist['ssf_wp_zip']);
		update_post_meta($id,'fgms-distributor-website',$dist['ssf_wp_url']);
		update_post_meta($id,'fgms-distributor-phone',$dist['ssf_wp_phone']);
		update_post_meta($id,'fgms-distributor-fax',$dist['ssf_wp_fax']);
		update_post_meta($id,'fgms-distributor-email',$dist['ssf_wp_email']);
		//	Lat/lng
		$lat=floatval($dist['ssf_wp_latitude']);
		$lng=floatval($dist['ssf_wp_longitude']);
		global $wpdb;
		$wpdb->replace(
			$wpdb->prefix.'fgms_distributor',
			['ID' => $id,'lat' => $lat,'lng' => $lng],
			['%d','%f','%f']
		);
		if ($wpdb->last_error!=='') throw new \RuntimeException($wpdb->last_error);
	}
});