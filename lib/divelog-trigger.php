<?php
/**
 * Divelog helper functions
 *
 * @package Divelog
 */

/**
 * Triggered on relationship creation or deletion.
 * only interested in 'personal_event' relationships.
 *
 * @return true
 */
function create_from_event_handler($event, $object_type, $object) {
	if($object_type != 'relationship') return true;
	if(! in_array($event, array('create','delete'))) return true;
	if($object->relationship != 'personal_event') return true;
	$owner_guid = elgg_get_logged_in_user_guid();
	if($object->guid_one != $owner_guid) return true;
	$settings = elgg_get_all_plugin_user_settings($owner_guid, 'divelog');
	$create_from_event = false;
	if($settings)
		if($settings['create_from_event'])
			$create_from_event = $settings['create_from_event'];

	if($create_from_event) {
		$event = get_entity($object->guid_two);
		if (elgg_instanceof($event, 'object', 'event_calendar') && ($event->event_type == 'divelog') ) {

			function if_print($w, $s) { // small utility function
				return ($w == '') ? '' :
					elgg_echo("divelog:briefing:".$s) . ": " . $w . '.<br/>';
			}

			$briefing = "";
			$briefing .= if_print($event->fees, 'fees');
			$briefing .= if_print($event->contact, 'contact');
			$briefing .= if_print($event->organiser, 'organiser');
			$briefing .= if_print($event->long_description, 'long_description');

			$divelog = new ElggObject;
			$divelog->subtype = "divelog";
			$divelog->container_guid = (int)get_input('container_guid', $_SESSION['user']->getGUID());
			$divelog->dive_site = $event->venue;
			$divelog->dive_date = $event->start_date - ($event->start_time*60);
			$divelog->dive_start_time = $event->start_time;
			$divelog->dive_briefing = $briefing;
			$divelog->dive_suggestor = $event->container_guid;
			$divelog->units = get_user_units();
			$divelog->tags = $event->event_tags;

			$divelog->title = elgg_view('object/dive_text', array('entity'=>$divelog, 'mode'=>'title'));
			$divelog->description = $event->brief_description;

			if ($divelog->save()) {
				if (!check_entity_relationship($divelog->getGUID(), "divelog_event_calendar", $event->getGUID()))
					add_entity_relationship($divelog->getGUID(), "divelog_event_calendar", $event->getGUID());
				add_to_river('river/object/divelog/create','create', elgg_get_logged_in_user_guid(), $divelog->getGUID());
				//elgg_trigger_event('publish','object',$divelog);
			}
		}
	}
	return true;
}