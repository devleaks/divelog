<?php
/**
 * Convert a event_calendar of type divelog to a divelog
 *
 * @package Divelog
 */

elgg_load_library('divelog');

$guid = get_input('guid');
$event = get_entity($guid);

if (	elgg_instanceof($event, 'object', 'event_calendar')
	 && ($event->event_type == 'divelog') ) {

	function if_print($w, $s) { // small utility function
		return ($w == '') ? '' :
			elgg_echo("divelog:briefing:".$s) . ": " . $w . '.<br/>';
	}

	/* event_calendar data: 'title','venue','start_time','start_date','end_time','end_date',
	 *    'brief_description','region','event_type','fees','contact','organiser','event_tags',
	 *    'long_description','spots','personal_manage'
	 */
	$briefing = "";
	$briefing .= if_print($event->fees, 'fees');
	$briefing .= if_print($event->contact, 'contact');
	$briefing .= if_print($event->organiser, 'organiser');
	$briefing .= if_print($event->long_description, 'long_description');

	$divelog = new ElggObject;
	$divelog->subtype = "divelog";
	$divelog->container_guid = (int)get_input('container_guid', $_SESSION['user']->getGUID());
	$divelog->dive_site = $event->venue;
	$divelog->dive_date = $event->start_date;
	$divelog->dive_start_time = $event->start_time;
	$divelog->dive_briefing = $briefing;
	$divelog->dive_suggestor = $event->container_guid;
	$divelog->units = get_user_units();

	$divelog->tags = $event->event_tags;
	//$divelog->access_id = ACCESS_DEFAULT;

	$divelog->title = divelog_prettyprint($divelog, 'title');
	$divelog->description = $event->brief_description;

	if ($divelog->save()) {
		if (is_array($shares) && sizeof($shares) > 0) {
			foreach($shares as $share) {
				$share = (int) $share;
				add_entity_relationship($divelog->getGUID(), 'share', $share);
			}
		}
		
		if (!check_entity_relationship($divelog->getGUID(), "divelog_event_calendar", $event->getGUID()))
			add_entity_relationship($divelog->getGUID(), "divelog_event_calendar", $event->getGUID());
		
		system_message(elgg_echo('divelog:save:success'));
		
		add_to_river('river/object/divelog/create','create', elgg_get_logged_in_user_guid(), $divelog->getGUID());
		//elgg_trigger_event('publish','object',$divelog);
		forward($divelog->getURL());
	} else {
		register_error(elgg_echo('divelog:save:failed'));
		forward("divelog");
	}
}

register_error(elgg_echo("divelog:convert:failed"));
forward(REFERER);
