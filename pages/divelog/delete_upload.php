<?php
/**
 * Upload divelogs page
 *
 * @package Divelog
 */

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('divelog:delete_upload');
elgg_push_breadcrumb($title);

$content = elgg_view_form('divelog/delete_upload',
							array('enctype' => 'multipart/form-data',
								  'method' => 'POST',
								  'id' => 'divelog-upload-admin-form'),
							$data);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);