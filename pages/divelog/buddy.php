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

elgg_push_breadcrumb(elgg_echo('divelog:buddy'));

elgg_register_title_button();

$saname = sanitise_string($page_owner->username);
$options = array(
	'type' => 'object',
	'subtype' => 'divelog',
	'limit' => 10,
	'full_view' => false,
	'metadata_name_value_pairs' => array(
		array( // Needs cleaning, potential sql injection, in spite of sanitise_string?
			'name' => 'dive_buddies',
			'value' => "%$saname%",
			'operand' => 'like'
		)
	),
);

$content = elgg_list_entities_from_metadata($options);

if (!$content) {
	$content = elgg_echo('divelog:none');
}

$title = elgg_echo('divelog:owner', array($page_owner->name));

$vars = array(
	'filter_context' => 'buddy',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('divelog/sidebar'),
);

$body = elgg_view_layout('content', $vars);

echo elgg_view_page($title, $body);