<?php
/**
 * Divelog helper functions
 *
 * @package Divelog
 */

/**
 * List unique dive site for token input.
 *
 * @return ElggMetadata[].
 */
function tokenize_dive_sites($term, $options = array()) {
	$term = sanitize_string($term);
	// replace mysql vars with escaped strings
	$q = str_replace(array('_', '%'), array('\_', '\%'), $term);
	
	$options['metadata_names'] = array('dive_site');
	$options['wheres'] = array("v.string LIKE '%$q%'");
	$options['group_by'] = "v.string"; // trick to remove duplicates
	
	return elgg_get_metadata($options);
}
