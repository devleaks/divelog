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

elgg_push_breadcrumb(elgg_echo('divelog:Planned'));

elgg_register_title_button();

$options = array(
	'type' => 'object',
	'subtype' => 'divelog',
//	'container_guid' => elgg_get_logged_in_user_guid(),
	'limit' => 10,
	'metadata_name_value_pairs' => array(
		array( // Needs cleaning. Should include dives today.
			'name' => 'dive_date',
			'value' => time(),
			'operand' => '>'
		)
	),
);

// $content =  elgg_list_entities_from_metadata($options);
$divelogs =  elgg_get_entities_from_metadata($options);

$divelog_guids = array();
if ($divelogs) {
	$content = elgg_view_entity_list($divelogs, array('full_view' => false));
	foreach($divelogs as $dive)
		$divelog_guids[] = $dive->getGUID();
}

if (is_plugin_enabled('event_calendar'))
	if($fde = get_future_divelog_events($divelog_guids))
		$content .= $fde;

if (!$content) {
	$content = elgg_echo('divelog:none');
}

$title = elgg_echo('divelog:owner', array($page_owner->name));

$vars = array(
	'filter_context' => 'planned',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('divelog/sidebar'),
);

$body = elgg_view_layout('content', $vars);

echo elgg_view_page($title, $body);