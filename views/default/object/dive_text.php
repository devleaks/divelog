<?php
/**
 * Elgg divelog view
 *
 * @package Divelog
 */

elgg_load_library('divelog');

$divelog = elgg_extract('entity', $vars, false);
$mode = elgg_extract('mode', $vars, 'full');

if (!$divelog) {
	return;
}

$dive_date = $divelog->dive_date + $divelog->dive_start_time*60;
list($dive_date_fmt_long, $dive_date_fmt_short, $dive_time_fmt) = format_date($dive_date);	
$dive_in_future = ($divelog->dive_date > time());
$buddies_display = get_buddy_list($divelog->dive_buddies);

$str = "";

switch($mode) {
	case 'title':	// Just a heading type of info
	case 'stats':
		$str = $divelog->dive_site
				. ", " . elgg_echo("divelog:dive_on") . " " . $dive_date_fmt_short
				// elgg_view('output/date', array('value' => $divelog->dive_date));
				//. "(".$curr_year ."/".$dive_year.")+".$num_days."."
				;
		if($dive_in_future) {
			$str .= ' ('.elgg_echo("divelog:short:planned").')';
		}
		break;
		
	case 'river':	// Additional info for river display. Does not include title info nor comments. Meant to complement title above.
		$str = elgg_echo("divelog:dive_at") . " " . $dive_time_fmt;
		if(! $dive_in_future) {
			$str .=	print_null(dive_params($divelog, $mode), ", ", "", "",
				strtolower(elgg_echo("divelog:no_dive_params")));
			$str .= print_null($buddies_display, ", ", elgg_echo("divelog:dive_with"), ".", ".");
		} else {
			$str .= ' ('.elgg_echo("divelog:planned").').';
		}
		break;
		
	case 'full':	// All info in long form, multiline display with <p>.
		$str = elgg_echo("divelog:prompt:newdive") . " " . elgg_echo("divelog:dive_at") . " " . $divelog->dive_site
				. ".<br/>" . elgg_echo("divelog:prompt:dive_date") . " " . $dive_date_fmt_long . ", " . $dive_time_fmt;
				
		if(! $dive_in_future) {	
			$str .= '.';			
			$str .= print_null(dive_params($divelog, $mode), "<br/>", elgg_echo("divelog:prompt:dive_data"), ".",
								elgg_echo("divelog:no_dive_params"));
			$str .= print_null($buddies_display, "<br/>", elgg_echo("divelog:prompt:dive_with"), ".");				
			$str .= print_null($divelog->dive_debriefing, "<br/>", elgg_echo("divelog:prompt:dive_note"));
		} else {
			$str .= ' ('.elgg_echo("divelog:planned").').';
			$str .= print_null($divelog->dive_briefing, "<br/>", elgg_echo("divelog:prompt:dive_briefing"));
		}
		break;
		
	default:		// All info in short form
	case 'short':
	case 'description':
		$str = $divelog->dive_site
				. " "  . elgg_echo("divelog:dive_on") . " " . $dive_date_fmt_short
				. ", " . $dive_time_fmt;
		if(! $dive_in_future) {					
			$str .= print_null(dive_params($divelog, $mode), " (", "", ")");
			$str .= print_null($buddies_display, " ", elgg_echo("divelog:dive_with"), ".", ".");
			;
		} else {
			$str .= ' ('.elgg_echo("divelog:planned").').';
		}
		break;
}

echo $str;
