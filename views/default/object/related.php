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
$container = $divelog->getContainerEntity();

// Same dive.
$options = array(
	'relationship_guid' => $divelog_guid,
	'relationship' => 'divelog_same_dive',
	'inverse_relationship' => false, // event is end of relationship...
	'limit' => 0,
);

if($existing_rels = elgg_get_entities_from_relationship($options)) {
	elgg_echo('divelog:same_dive');
	foreach($existing_rels as $rel) {
		echo elgg_view('object/dive_link', array('entity' => $rel->guid));
	}
}


// Club dives: Dives same day at same dive site.
$options = array(
	'relationship_guid' => $divelog_guid,
	'relationship' => 'divelog_club_dive',
	'inverse_relationship' => false, // event is end of relationship...
	'limit' => 0,
);

if($existing_rels = elgg_get_entities_from_relationship($options)) {
	elgg_echo('divelog:club_dive');
	foreach($existing_rels as $rel) {
		echo elgg_view('object/dive_link', array('entity' => $rel->guid));
	}
}