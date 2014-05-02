<?php
/**
 * Elgg divelog plugin everyone page
 *
 * @package Divelog
 */

$divelog = get_entity(get_input('guid'));
if (!$divelog) {
	register_error(elgg_echo('noaccess'));
	$_SESSION['last_forward_from'] = current_page_url();
	forward('');
}

elgg_push_breadcrumb(elgg_echo('divelog:same_site'));

$options = array(
	'type' => 'object',
	'subtype' => 'divelog',
	'limit' => 20,
	'full_view' => false,
	'metadata_name_value_pairs' => array(
		array(
			'name' => 'dive_site',
			'value' => $divelog->dive_site,
			'operand' => '='
		),
	),
);
	
$content .= elgg_list_entities_from_metadata($options);	

if (!$content) {
	$content = elgg_echo('divelog:none');
}

$vars = array(
	'filter_context' => $filter_context,
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('divelog/sidebar'),
);

$body = elgg_view_layout('content', $vars);

echo elgg_view_page($title, $body);