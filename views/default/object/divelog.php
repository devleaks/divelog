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

$owner = $divelog->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$container = $divelog->getContainerEntity();
$categories = elgg_view('output/categories', $vars);

$description = divelog_prettyprint($divelog, "full");// elgg_view('output/longtext', array('value' => $divelog->description, 'class' => 'pbl'));

$owner_link = elgg_view('output/url', array(
	'href' => "divelog/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

$date = elgg_view_friendly_time($divelog->time_created);

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

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'divelog',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

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

} elseif (elgg_in_context('gallery')) {

	// gallery view	
	echo <<<HTML
<div class="divelog-gallery-item">
	<h3>$divelog->title</h3>
	<p class='subtitle'>$owner_link $date</p>
</div>
HTML;

} else {

	// brief view
	$content = elgg_view_icon('divelog') . " " . divelog_prettyprint($divelog, "short");
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
