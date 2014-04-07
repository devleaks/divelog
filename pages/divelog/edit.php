<?php
/**
 * Add divelog page
 *
 * @package Divelog
 */

$divelog_guid = get_input('guid');
$divelog = get_entity($divelog_guid);

if (!elgg_instanceof($divelog, 'object', 'divelog') || !$divelog->canEdit()) {
	register_error(elgg_echo('divelog:unknown_divelog'));
	forward(REFERRER);
}

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('divelog:edit');
elgg_push_breadcrumb($title);

$vars = divelog_prepare_form_vars($divelog);
$content = elgg_view_form('divelog/save', array(), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);