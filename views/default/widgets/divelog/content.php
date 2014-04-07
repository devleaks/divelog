<?php
/**
 * Elgg divelog widget
 *
 * @package Divelog
 */

$max = (int)$vars['entity']->num_display;

$options = array(
	'type' => 'object',
	'subtype' => 'divelog',
	'container_guid' => $vars['entity']->owner_guid,
	'limit' => $max,
	'full_view' => FALSE,
	'pagination' => FALSE,
);
$content = elgg_list_entities($options);

echo $content;

if ($content) {
	$more_link = elgg_view('output/url', array(
		'href' => "divelog/owner/" . elgg_get_page_owner_entity()->username,
		'text' => elgg_echo('divelog:more'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('divelog:none');
}
