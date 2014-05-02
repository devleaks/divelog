<?php
/**
 * Elgg divelog plugin everyone page
 *
 * @package Divelog
 */
function arrayToCsv( array $fields, $delimiter = ';', $enclosure = '"', $encloseAll = false) { // stolen on 
    $delimiter_esc = preg_quote($delimiter, '/');
    $enclosure_esc = preg_quote($enclosure, '/');
    $output = array();
    foreach ( $fields as $field ) {
        // Enclose fields containing $delimiter, $enclosure or whitespace
        if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
            $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
        }
        else {
            $output[] = $field;
        }
    }
    return implode( $delimiter, $output );
}

$user_units = get_user_units();

$options = array(
	'type' => 'object',
	'subtype' => 'divelog',
	'owner_guid' => elgg_get_logged_in_user_guid(),
	'limit' => 0,
);

if($divelogs = elgg_get_entities($options)) {
	$result = '"date";"time";"site";"depth";"duration";"access";"tags";"buddies";"notes"';
	foreach($divelogs as $dive) {
		//"15/04/1971","15:45","Blue Hole, Belize","39","44","1","belize","Albert Falco","Deep dive, only half way to bottom."<br/>
		$result .= '
'.arrayToCsv(array(
			strftime('%d/%m/%G', $dive->dive_date),
			strftime('%H:%M', $dive->dive_start_time),
			$dive->dive_site,
			round( ($user_units != $dive->units) ? // we export in the user's pref units. We convert dives in other units.
					( ($dive->units == "metric") ? $dive->dive_depth * (12*0.254) : $dive->dive_depth / (12*0.254) ) :
					$dive->dive_depth ),
			$dive->dive_duration,
			$dive->access_id,
			implode(', ', $dive->tags),
			$dive->dive_buddies, //@todo: need cleaning of string here under:
			html_entity_decode(strip_tags(htmlspecialchars_decode($dive->dive_briefing . DIVELOG_NOTE_SEPARATOR . $dive->dive_debriefing)))
			)
		);
	}
} else $content = elgg_echo('divelog:none');

header("Content-Type: text/csv; charset=utf-8");
header('Content-disposition: attachment;filename=divelogs.csv');
echo $result;
exit;