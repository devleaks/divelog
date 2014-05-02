<?php
/**
 * Elgg divelog view
 *
 * @package Divelog
 */
if (! is_plugin_enabled('hypeGallery'))
	return;

elgg_load_library('divelog');

$divelog = elgg_extract('entity', $vars, FALSE);
$debug = elgg_extract('verbose', $vars, FALSE);

if (!$divelog) {
	return;
}

set_divelog_galleries($divelog);

/* Get galleries through relationship "divelog_media"
 */
$options = array(
	'relationship_guid' => $divelog->guid,
	'relationship' => 'divelog_media',
	'inverse_relationship' => false, 
	'limit' => 0,
);

$galleries = array();
if($existing_rels = elgg_get_entities_from_relationship($options)) {
	foreach($existing_rels as $rel) {
		if($gallery = get_entity($rel->guid))
			$galleries[] = $gallery;
		/* else gallery not found, may be it was deleted, so we should remove relationship... */
	}
}

if ($galleries) {
	echo elgg_echo('divelog:gallery');
	if(elgg_in_context('river')) { // display just one gallery
		elgg_push_context('activity');
		echo elgg_view('object/hjalbum', array('entity' => $gallery[0], 'list_type' => 'river'));
		elgg_pop_context();
	} else //  display them all
		foreach($galleries as $gallery) {
			// display nice stream
			//echo $gallery->title;
			elgg_push_context('activity');
			echo elgg_view('object/hjalbum', array('entity' => $gallery, 'list_type' => 'river'));
			elgg_pop_context();
		}
} else if ($debug) {
	echo elgg_echo('divelog:nogallery');
}