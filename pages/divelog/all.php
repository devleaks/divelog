<?php
/**
 * Elgg divelog plugin everyone page
 *
 * @package Divelog
 */

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('divelog'));

elgg_register_title_button();

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'divelog',
	'full_view' => false,
	'view_toggle_type' => false,
));

if (!$content) {
	$content = elgg_echo('divelog:none');
}

$title = elgg_echo('divelog:everyone');

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('divelog/sidebar'),
));

echo elgg_view_page($title, $body);