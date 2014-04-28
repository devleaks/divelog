<?php
/**
 * Elgg divelog view
 *
 * @package Divelog
 */

elgg_load_library('divelog');

$full = elgg_extract('full_view', $vars, FALSE);
$divelog = elgg_extract('entity', $vars, FALSE);

if (!$divelog) {
	return;
}

$dive_in_future = ($divelog->dive_date > time());

//Author
$owner = $divelog->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => "divelog/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

//Date
$date = elgg_view_friendly_time($divelog->time_created);

//Comments
$comments_count = $divelog->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $divelog->getURL() . '#comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

//Categories
$categories = elgg_view('output/categories', $vars);

//Description
$description = elgg_view('object/dive_text', array('entity'=>$divelog, 'mode'=>'full'));

//Metadata
if (elgg_in_context('widgets')) {
	// do not show the metadata and controls in widget view
	$metadata = '';
} else {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'divelog',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

//////////////////
//Views
//
$subtitle = "$author_text $date $comments_link $categories";

//////////////////
//Full no gallery
//
if ($full && !elgg_in_context('gallery')) {
	// full view
	$params = array(
		'entity' => $divelog,
		//'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	$divelog_icon = elgg_view_icon('divelog');
	$body = <<<HTML
<div class="divelog elgg-content mts">
	$divelog_icon
	$description
</div>
HTML;

	echo elgg_view('object/elements/full', array(
		'entity' => $divelog,
		'icon' => $owner_icon,
		'summary' => $summary,
		'body' => $body,
	));

	if (!$dive_in_future && is_plugin_enabled('hypeGallery')) {
		echo elgg_view('object/gallery', array('entity' => $divelog));
	}
	
//////////////////
//Gallery
//
} elseif (elgg_in_context('gallery')) {

	echo <<<HTML
<div class="divelog-gallery-item">
	<h3>$divelog->title</h3>
	<p class='subtitle'>$owner_link $date</p>
</div>
HTML;

//////////////////
//Brief
//
} else {

	$content = elgg_view_icon('divelog') . " " . elgg_view('object/dive_text', array('entity'=>$divelog, 'mode'=>'short'));
	$params = array(
		'entity' => $divelog,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $content,
	);
	$params = $params + $vars;
	$body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($owner_icon, $body);
}