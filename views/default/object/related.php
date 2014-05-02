<?php
/**
 * Elgg divelog view
 *
 * @package Divelog
 */

elgg_load_library('divelog');

$divelog = elgg_extract('entity', $vars, FALSE);
$debug = elgg_extract('verbose', $vars, FALSE);

if (!$divelog) {
	return;
}

$owner = $divelog->getOwnerEntity();
$container = $divelog->getContainerEntity();

//debug
//set_divelog_related_dives($divelog);

// Same dive, different reporter(s).
$options = array(
	'relationship_guid' => $divelog->getGUID(),
	'relationship' => 'divelog_same_dive',
	'inverse_relationship' => false, // event is end of relationship...
	'limit' => 0,
);

if($reldiveated_dives = elgg_get_entities_from_relationship($options)) {
	echo elgg_echo('divelog:same_dive:intro');
	$first = true;
	foreach($reldiveated_dives as $reldive) {
		if(! $first) echo ', '; else $first = false;
		echo elgg_view('object/dive_link', array('entity' => $reldive));
		//echo '('.$reldive->guid.')';
	}
	echo '.<br/>';
} else if($debug) {
	echo elgg_echo('divelog:no_same_dive');
	echo '<br/>';
}

// Club dives: Dives same day at same dive site, different time.
$options = array(
	'relationship_guid' => $divelog->getGUID(),
	'relationship' => 'divelog_club_dive',
	'inverse_relationship' => false, // event is end of relationship...
	'limit' => 0,
);

if($reldiveated_dives = elgg_get_entities_from_relationship($options)) {
	echo elgg_echo('divelog:club_dive:intro');
	$first = true;
	foreach($reldiveated_dives as $reldive) {
		if(! $first) echo ', '; else $first = false;
		echo elgg_view('object/dive_link', array('entity' => $reldive));
		//echo '('.$reldive->guid.')';
	}
	echo '.<br/>';
} else if($debug) {
	echo elgg_echo('divelog:no_club_dive');
	echo '<br/>';
}

// Same site
$options = array(
	'type' => 'object',
	'subtype' => 'divelog',
	'count' => true,
	'metadata_name_value_pairs' => array(
		array(
			'name' => 'dive_site',
			'value' => $divelog->dive_site,
			'operand' => '='
		),
	),
);
$count = elgg_get_entities_from_metadata($options);
if($count > 0) {
	echo '<br/>';
	echo elgg_view('output/url', array(
		'href' => elgg_get_site_url()."divelog/site/$divelog->guid",
		'text' => elgg_echo('divelog:same_site') . ' ('.$count.')',
		'title' => elgg_echo('divelog:same_site'),
	)).'.';
}