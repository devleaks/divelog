<?php
/**
 * Divelog helper functions
 *
 * @package Divelog
 */
if (is_plugin_enabled('event_calendar'))
	elgg_load_library('elgg:event_calendar');

/**
 * Get a user unit sysmtem preference. If none exists for user, use system default.
 * If system default is not set, defaults to metric.
 *
 * @param Elgg User Identifier.
 * @return [metric|imperial]
 */
function get_user_units() {
	// Get system-wide default value ($divelog_units)
	$system_units = $vars['entity']->divelog_units;
	if (!$system_units)
		$system_units = 'metric';

	// get previously saved settings for user, if any
	if(!$guid = elgg_get_logged_in_user_guid())
		return $system_units;

	$settings = elgg_get_all_plugin_user_settings($guid, 'divelog');

	$user_units = '';
	if($settings)
		if($settings['user_units'])
			$user_units = $settings['user_units'];

	// if not set, defaults to system default
	return ($user_units == '') ? $system_units : $user_units;
}


/**
 * Prepare the add/edit form variables
 *
 * @param ElggObject $divelog A divelog object.
 * @return array
 */
function divelog_prepare_form_vars($divelog = null) {
	// input names => defaults
	$values = array(
		'dive_site' => '',
		'dive_date' => '',
		'dive_start_time' => '',
		'dive_depth' => '',
		'dive_duration' => '',
		'dive_buddies' => '',
		'dive_briefing' => '',
		'dive_debriefing' => '',
		'dive_media' => '',
		'units' => '',		
		'tags' => '',		
		'access_id' => ACCESS_DEFAULT,
		'shares' => array(),
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $divelog,
	);

	if ($divelog) {
		foreach (array_keys($values) as $field) {
			if (isset($divelog->$field)) {
				$values[$field] = $divelog->$field;
			}
		}
	}

	if (elgg_is_sticky_form('divelog')) {
		$sticky_values = elgg_get_sticky_values('divelog');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('divelog');

	return $values;
}


/**
 * Return events of event_calendar of type 'divelog' that are in the future.
 *
 * @return [ready to print entity list|false] 
 */
function get_future_divelog_events($existing_planned_divelog_guids) {
	// check whether user already has a planned dive for this event
	// add_entity_relationship($divelog->getGUID(), "divelog_event_calendar", $event->getGUID());
	function has_planned_dive($event, $divelog_list) {
		$options = array(
		    'relationship_guid' => $event->getGUID(),
		    'relationship' => 'divelog_event_calendar',
			'inverse_relationship' => true, // event is end of relationship...
		);
		
		if($existing_rels = elgg_get_entities_from_relationship($options))
			foreach($existing_rels as $rel)
				if(in_array($rel->getGUID(), $divelog_list))
					return true; // we found the corresponding divelog in the list of divelogs that are already displayed.
		
		return false;
	}
	
	if (! is_plugin_enabled('event_calendar'))
		return false;

	// get event_calendar in the future of type 'divelog'.
	$options = array(
		'type' => 'object',
		'subtype' => 'event_calendar',
		'limit' => 10,
		'metadata_name_value_pairs' => array(
			array( // Needs cleaning.
				'name' => 'start_date',
				'value' => time(),
				'operand' => '>'
			),
			array(
				'name' => 'event_type',
				'value' => 'divelog'
			),
		),
	);
	$events = elgg_get_entities_from_metadata($options);
	if(!$events)
		return false;
	
	$icon = '<img src="'.elgg_get_site_url().'mod/divelog/graphics/divelog.png" />';

	$body = '<ul class="elgg-list elgg-list-entity">';
	foreach($events as $event) {
		
		if(! has_planned_dive($event, $existing_planned_divelog_guids)) {
		$owner = $event->getOwnerEntity();
		$owner_icon = elgg_view_entity_icon($owner, 'tiny');
		$container = $event->getContainerEntity();
		$categories = elgg_view('output/categories', $vars);
		$owner_link = elgg_view('output/url', array(
			'href' => "divelog/owner/$owner->username",
			'text' => $owner->name,
			'is_trusted' => true,
		));
		$author_text = elgg_echo('byline', array($owner_link));

		$date = elgg_view_friendly_time($event->time_created);

		$comments_count = $event->countComments();
		//only display if there are commments
		if ($comments_count != 0) {
			$text = elgg_echo("comments") . " ($comments_count)";
			$comments_link = elgg_view('output/url', array(
				'href' => $event->getURL() . '#comments',
				'text' => $text,
				'is_trusted' => true,
			));
		} else {
			$comments_link = '';
		}
	
		$subtitle = "$author_text $date $comments_link $categories";

		$metadata = elgg_view_menu('entity', array(	// regular event entity menu to register to dive, etc.
			'entity' => $event,
			'handler' => 'event_calendar',
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz',
		));
		$metadata .= elgg_view_menu('entity', array(// "Convert event(in future) to dive(planned)"
			'entity' => $event,
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz',
			'handler' => 'divelog_convert',
		));
	
		list($dive_date_fmt_long, $dive_date_fmt_short, $dive_time_fmt) = format_date($event->start_date);	

		$title  = $event->venue . ', ' . elgg_echo('divelog:dive_on') . " " . $dive_date_fmt_short;
		$title .= " "  . elgg_echo('divelog:dive_at') . " "  . $dive_time_fmt;

		$info  = elgg_view_icon('divelog');
		$info .= ' ' . elgg_echo('divelog:prompt:newdive') . " " . elgg_echo('divelog:dive_at') . " " . $event->venue;
		$info .= ' ' . elgg_echo("divelog:dive_on") . " " . $dive_date_fmt_short;
		$info .= ', ' . $dive_time_fmt;
		$info .= ' ('. elgg_echo('divelog:planned').', '. $event->title .').';

		$params = array(
			'entity' => $event,
			'metadata' => $metadata,
			'title' => $title,
			'subtitle' => $subtitle,
			'content' => $info,
		);
		$summary = elgg_view('object/elements/summary', $params);

		$body .= '<li class="elgg-item">';
		$body .= elgg_view('object/elements/full', array(
			'entity' => $event,
			'icon' => $owner_icon,
			'summary' => $summary,
		));
		$body .= '</li>';
		}//planned_dive
	}//foreach event
	return $body . '</ul>';
}


/**
 * Establish relationships "divelog_club_dive" and "divelog_same_dive" to other divelogs.
 *
 * @param ElggObject $divelog A divelog object.
 */
function set_divelog_related_dives($divelog) {
	//todo
}


/**
 * Create relationship "divelog_media" between divelog and hype galleries.
 *
 * @param ElggObject $divelog A divelog object.
 */
function set_divelog_galleries($divelog) {
	if (! is_plugin_enabled('hypeGallery'))
		return;

	$dive_date = strftime(elgg_echo('divelog:hypeGallery:date_format'), $divelog->dive_date);

	$options = array(
		'type' => 'object',
		'subtype' => 'hjalbum',
		'limit' => 10,
		'metadata_name_value_pairs' => array(
			array(
				'name' => 'date',
				'value' => $dive_date,
				'operand' => '='
			),
			array(
				'name' => 'categories',
				'value' => elgg_echo('divelog:hypeGallery:category'),
				'operand' => '=' //to be corrected. should be 'IN'?
			)
		),
	);

	if ($galleries =  elgg_get_entities_from_metadata($options)) {
		foreach($galleries as $gallery) {
			if (!check_entity_relationship($divelog->getGUID(), "divelog_media", $gallery->getGUID())) {
				add_entity_relationship($divelog->getGUID(), "divelog_media", $gallery->getGUID());
			}
		}
	}
}

/**
 * Print dive parameters or nothing ('').
 *
 * @param ElggObject $divelog A divelog object.
 * @param String $mode Pretty Print mode: {full|short|river}
 * @return String
 */
function dive_params($divelog, $mode) {
	if(		($divelog->dive_date > time() )
		 || ($divelog->dive_depth    == '')
		 || ($divelog->dive_duration == '')		) return ''; // dive in future or no param entered.
	$short = ($mode == "full") ? '' : 'short:';
	return $divelog->dive_duration. " " . elgg_echo("divelog:".$short."duration_unit")
		. " " . elgg_echo("divelog:dive_at") . " " . $divelog->dive_depth . " " . elgg_echo("divelog:".$short."depth_".$divelog->units);
}


/**
 * Print value (with prompts) if not empty or alternate string if empty.
 *
 * @param String $value Value to print.
 * @param String $before Value to print before prompt.
 * @param String $prompt Value to print before value.
 * @param String $after  Value to print after value.
 * @param String $alternate Value to print is $value is empty.
 * @return String
 */
function print_null($value, $before = '', $prompt = '', $after = '', $alternate = '') {
	return ($value != '') ? $before . ( ($prompt != '') ? "<span class='divelog-data-label'>" .$prompt ."</span>" . " " : '' ) . "<span class='divelog-data-value'>" . $value ."</span>" . $after
			              : ( ($alternate != '') ? $before . $alternate . $after : '' );
}


/**
 * Format date in time in long and short form depending on local preferences and international settings.
 *
 * @param Date with date and time information.
 * @return Array of 3 strings for date_long, date_short, and time formats. (there is no time in long or short format.)
 */
function format_date($date_in) {
	$num_days = floor((time()-$date_in)/(24*60*60));
	$oldLocale = setlocale(LC_TIME, elgg_echo('divelog:locale'));
	$date_long  = strftime(elgg_echo('divelog:full:date_format'), $date_in);
	//if date more than 170 days, repeat date year in short form '14.
	$date_short = strftime(elgg_echo('divelog:short:date_format').(($num_days < 170) ? '' : " '%g"), $date_in);
	$date_time  = strftime(elgg_echo('divelog:time_format'), $date_in);
	setlocale(LC_TIME, $oldLocale); // useless?
	if(elgg_echo('divelog:date_lowercase') == 'yes') { // in French, dates are locawercase...
		$date_short = strtolower($date_short);
		$date_long = strtolower($date_long);
	}
	return array($date_long, $date_short, $date_time);
}


/**
 * Expand buddy list into a list with link if buddy is registered user.
 *
 * @param String Comma-separated buddy list.
 * @return String Comma-separated list of buddies, with link to divelog of buddy if Elgg User.
 */
function get_buddy_list($buddy_list) {
	$dive_buddies = explode(',', $buddy_list);
	$buddies_display = "";
	foreach($dive_buddies as $diver) {
		$elgg_diver = get_user_by_username($diver);
		if($elgg_diver && ($elgg_diver instanceof ElggUser)) {
			$buddies_display .= '<a href="'.elgg_get_site_url().'divelog/owner/'.$diver.'">'.$elgg_diver->name.'</a>';
		} else {
			$buddies_display .= $diver;
		}
		$buddies_display .= ", ";
	}
	return rtrim($buddies_display, ', ');
}


/**
 * Determine if two dives are the "same", i.e. took place at the same place, at about the same time.
 *
 * @param Divelog.
 * @param Divelog to be compared.
 * @param check_params [true|false], default false. Whether to compare dive parameters as well.
 * @return [true|false].
 */
function same_dive($d1, $d2, $check_params = false) {
	function same_site($conf) {
		$ret = similar_text($d1->dive_site, $d2->dive_site, $pct);
		return ($pct > $conf);
	}

	function about_same_time($same_hour) {
		$t1 = $d1->dive_date + $d1->dive_start_time*60;
		$t2 = $d2->dive_date + $d2->dive_start_time*60;
		$tdiff = abs($t1 - $t2);
		return ($tdiff < ($same_hour * 60 * 60));
	}
	
	function same_params($dpt, $dur) {
		$durdiff = abs($d1->dive_duration - $d2->dive_duration);
		if ($d1->units != $d2->units) {
			$dd1 = ($d1->units == 'metric') ? $d1->dive_depth : $d1->dive_depth / (12*0.254);
			$dd2 = ($d2->units == 'metric') ? $d2->dive_depth : $d2->dive_depth / (12*0.254);
			$dptdiff = abs($dd1 - $dd2);
		} else
			$dptdiff = abs($d1->dive_depth - $d2->dive_depth);

		return (($dptdiff < $dpt) && ($durdiff < $dur));
	}

	$same_param = $check_params ? same_param() : true;
	
	return( same_site(70) && about_same_time(2) && $same_params);
}
