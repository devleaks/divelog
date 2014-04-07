<?php
/**
 * New divelog river entry
 *
 * @package Divelog
 */
elgg_load_library('divelog');

$divelog = $vars['item']->getObjectEntity();
$vars['excerpt'] = divelog_prettyprint($divelog, "river");

echo elgg_view('page/components/image_block', array(
	'image' => '<img src="'.$vars['url'] . 'mod/divelog/graphics/divelog-small.png" />',
	'body' => elgg_view('river/elements/body', $vars),
	'class' => 'elgg-river-item',
));