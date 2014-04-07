<?php
/**
 * Add divelog page
 *
 * @package Divelog
 */

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('divelog:add');
elgg_push_breadcrumb($title);

$vars = divelog_prepare_form_vars();
$content = elgg_view_form('divelog/save', array(), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);