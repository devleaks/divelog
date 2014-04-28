<?php
/**
 * Elgg divelog view
 *
 * @package Divelog
 */

elgg_load_library('divelog');

$divelog = elgg_extract('entity', $vars, FALSE);

if (!$divelog) {
	return;
}

$owner = $divelog->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$text = $owner->name;

echo elgg_view('output/url', array(
	'href' => $divelog->getURL(),
	'text' => $text,
	'icon' => $owner_icon,
	'is_trusted' => true,
));
