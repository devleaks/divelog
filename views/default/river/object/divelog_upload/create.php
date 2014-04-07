<?php
/**
 * New divelog river entry
 *
 * @package Divelog
 */
$divelog_upload = $vars['item']->getObjectEntity();
$vars['excerpt'] = elgg_echo('divelog_upload_new', $divelog_upload->count);

echo elgg_view('page/components/image_block', array(
	'image' => '<img src="'.$vars['url'] . 'mod/divelog/graphics/divelog-small.png" />',
	'body' => elgg_view('river/elements/body', $vars),
	'class' => 'elgg-river-item',
));