<?php
/**
 * Create a personal copy of a friends's divelog
 * Dive parameters are not copied, just metadata.
 *
 * @package Divelog
 */

elgg_load_library('divelog');

$guid = get_input('guid');
$divelog_src = get_entity($guid);

if (elgg_instanceof($divelog_src, 'object', 'divelog')) {

	$divelog 					= new ElggObject;
	$divelog->subtype 			= "divelog";
	$divelog->container_guid	= (int)get_input('container_guid', $_SESSION['user']->getGUID());
	$divelog->dive_site			= $divelog_src->dive_site;
	$divelog->dive_date 		= $divelog_src->dive_date;
	$divelog->dive_start_time 	= $divelog_src->dive_start_time;
	$divelog->dive_briefing		= $divelog_src->dive_briefing;
	$divelog->dive_suggestor	= $divelog_src->dive_suggestor;
	$divelog->units 			= get_user_units();

	$divelog->tags 				= $divelog_src->tags;
	//$divelog->access_id = ACCESS_DEFAULT;

	$divelog->title 			= divelog_prettyprint($divelog_src, 'title');
	$divelog->description		= divelog_prettyprint($divelog_src, 'desc');

	if ($divelog->save()) {
		if (is_array($shares) && sizeof($shares) > 0) {
			foreach($shares as $share) {
				$share = (int) $share;
				add_entity_relationship($divelog->getGUID(), 'share', $share);
			}
		}
		
		if (!check_entity_relationship($divelog->getGUID(), "divelog_club_dive", $divelog_src->getGUID()))
			add_entity_relationship($divelog->getGUID(), "divelog_club_dive", $divelog_src->getGUID());
		
		system_message(elgg_echo('divelog:save:success'));
		
		add_to_river('river/object/divelog/create','create', elgg_get_logged_in_user_guid(), $divelog->getGUID());
		//elgg_trigger_event('publish','object',$divelog);
		forward($divelog->getURL());
	} else {
		register_error(elgg_echo('divelog:save:failed'));
		forward("divelog");
	}
}

register_error(elgg_echo("divelog:copy:failed"));
forward(REFERER);
