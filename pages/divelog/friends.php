<?php
/**
 * Elgg divelog plugin friends page
 *
 * @package Divelog
 */

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	forward('', '404');
}

elgg_push_breadcrumb($page_owner->name, "divelog/owner/$page_owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$title = elgg_echo('divelog:friends');

$content = list_user_friends_objects($page_owner->guid, 'divelog', 10, false);
if (!$content) {
	$content = elgg_echo('divelog:none');
}

$params = array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
