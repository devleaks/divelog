<?php
/**
 * New divelog river entry
 *
 * @package Divelog
 */
elgg_load_library('divelog');

$divelog = $vars['item']->getObjectEntity();
$vars['excerpt'] = elgg_view('object/dive_text', array('entity'=>$divelog, 'mode'=>'river'));

if (is_plugin_enabled('hypeGallery')) {
	$attachments = elgg_view('object/gallery', array('entity' => $divelog));
	$vars['attachments'] = $attachments;
}

$body = elgg_view('river/elements/body', $vars);

echo elgg_view('page/components/image_block', array(
	'image' => '<img src="'.$vars['url'] . 'mod/divelog/graphics/divelog-small.png" />',
	'body' => $body,
	'class' => 'elgg-river-item',
));