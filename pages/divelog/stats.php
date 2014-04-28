<?php
/**
 * Elgg divelog plugin everyone page
 *
 * @package Divelog
 */
$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	//forward('', '404');
	$page_owner = elgg_get_logged_in_user_entity();
}

elgg_push_breadcrumb(elgg_echo('divelog:statistics'));

elgg_register_title_button();

$options = array(
	'type' => 'object',
	'subtype' => 'divelog',
	'container_guid' => elgg_get_logged_in_user_guid(),
	'limit' => 0,
	'metadata_name_value_pairs' => array(
		array(
			'name' => 'dive_date',
			'value' => time(),
			'operand' => '<'
		)
	),	);
$divelogs = elgg_get_entities_from_metadata($options);

if (!$divelogs) {
	$content = elgg_echo('divelog:none');
} else {
	$divelog_count = 0;
	$divelog_totaltime = 0;
	foreach($divelogs as $dive) {
		$depth_metric = ($dive->units == 'metric') ? $dive->dive_depth : $dive->dive_depth / (12*0.254);
		if($divelog_count == 0) { // first dive
			$divelog_longuest = $dive;
			$divelog_deepest  = $dive;
			$deepest_metric   = $depth_metric;
		}
		if ($dive->dive_duration > $divelog_longuest->dive_duration)
			$divelog_longuest = $dive;
		if ($depth_metric > $deepest_metric) {
			$divelog_deepest = $dive;
			$deepest_metric  = $depth_metric;
		}
		$divelog_count++;
		$divelog_totaltime += $dive->dive_duration;
	}

	$content .= '<div class="divelog-stat"><span class="divelog-stat-prompt">' . elgg_echo('divelog:statistics:count') . ': </span>';
	$content .= '<span class="divelog-stat-data">' . $divelog_count . '.</span></div>';
	
	$d = floor($divelog_totaltime / (24 * 60));
	$dr = $divelog_totaltime - $d * 24 * 60;
	$h = floor($dr / 60);
	$m = $dr - $h * 60;
	$dstr = ' ('.$d.' '.elgg_echo("divelog:duration_unit:days").', '.$h.' '.elgg_echo("divelog:duration_unit:hours").', '.$m.elgg_echo("divelog:duration_unit:minutes").')';
	
	$content .= '<div class="divelog-stat"><span class="divelog-stat-prompt">' . elgg_echo('divelog:statistics:totaltime') . ': </span>';
	$content .= '<span class="divelog-stat-data">' . $divelog_totaltime . " " . elgg_echo("divelog:duration_unit") . $dstr . '.</span></div>';
	if($divelog_count != 0) {
	$content .= '<div class="divelog-stat"><span class="divelog-stat-prompt">' . elgg_echo('divelog:statistics:averagetime') . ': </span>';
	$content .= '<span class="divelog-stat-data">' . round($divelog_totaltime / $divelog_count) . " " . elgg_echo("divelog:duration_unit") . '.</span></div>';
	}
	
	$diveurl = elgg_view('output/url', array(
										'href' => elgg_get_site_url()."divelog/view/$divelog_longuest->guid",
										'text' => elgg_view('object/dive_text', array('entity'=>$divelog_longuest, 'mode'=>'stats')),
										'title' => elgg_echo('divelog:statistics:longest'),
									));
	$content .= '<div class="divelog-stat"><span class="divelog-stat-prompt">' . elgg_echo('divelog:statistics:longest') . ': </span>';
	$content .= '<span class="divelog-stat-data">' . $divelog_longuest->dive_duration . " " . elgg_echo("divelog:duration_unit")
					. ', ' . $diveurl . '.</span></div>';

	$diveurl = elgg_view('output/url', array(
										'href' => elgg_get_site_url()."divelog/view/$divelog_deepest->guid",
										'text' => elgg_view('object/dive_text', array('entity'=>$divelog_deepest, 'mode'=>'stats')),
										'title' => elgg_echo('divelog:statistics:longest'),
									));
	$content .= '<div class="divelog-stat"><span class="divelog-stat-prompt">' . elgg_echo('divelog:statistics:deepest') . ': </span>';
	$content .= '<span class="divelog-stat-data">' . $divelog_deepest->dive_depth . " " . elgg_echo("divelog:depth_".$divelog_deepest->units);
	
	$user_units = get_user_units();
	if($divelog_deepest->units != $user_units) {
		$unit_factor = ($user_units == 'metric') ? 1 / (12*0.254) : (12*0.254) ;
		$content .=  ' (' . round($divelog_deepest->dive_depth * $unit_factor, 1) . " " . elgg_echo("divelog:depth_".$user_units) . ')';
	}

	$content .= ', ' . $diveurl . '.</span></div>';

	$content .= '<div class="divelog-stat-warning">' . elgg_echo('divelog:statistics:warning') . '</div>';
}

$title = elgg_echo('divelog:owner', array($page_owner->name));

$vars = array(
	'filter_context' => 'stats',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('divelog/sidebar'),
);

$body = elgg_view_layout('content', $vars);

echo elgg_view_page($title, $body);