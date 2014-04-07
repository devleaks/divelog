<?php
/**
 * Divelogs English language file
 */

$english = array(

	/**
	 * Menu items and titles
	 */
	'divelog' => "Dive Logbook",
	'divelog:add' => "Add a dive log",
	'divelog:edit' => "Edit dive log",
	'divelog:owner' => "%s's dive logs",
	'divelog:friends' => "Friends' dive logs",
	'divelog:everyone' => "All site dive logs",
	'divelog:inbox' => "Divelog inbox",
	'divelog:moredive logs' => "More dive logs",
	'divelog:more' => "More",
	'divelog:with' => "Share with",
	'divelog:new' => "A new dive log",
	'divelog:none' => 'No dive logs',

	'divelog:notification' =>
'%s added a new dive log:

%s
%s

View and comment on the new dive log:
%s
',

	'divelog:delete:confirm' => "Are you sure you want to delete this resource?",

	'divelog:numbertodisplay' => 'Number of dive logs to display',

	'divelog:shared' => "Loged dives",
	'divelog:visit' => "Visit resource",
	'divelog:recent' => "Recent dive logs",

	'river:create:object:divelog' => '%s dive loged %s',
	'river:comment:object:divelog' => '%s commented on a dive %s',
	'divelog:river:annotate' => 'a comment on this dive log',
	'divelog:river:item' => 'an item',

	'item:object:divelog' => 'Dive Logs',

	'divelog:sitemenu' => "Dive log",
	'divelog:group' => 'Group dive logs',
	'divelog:enabledive logs' => 'Enable group dive logs',
	'divelog:nogroup' => 'This group does not have any dive logs yet',
	'divelog:more' => 'More dive logs',

	'divelog:no_title' => 'No title',

	/**
	 * Forms
	 */
	// admin
    'divelog:more' => 'More information',
	'divelog:units_selection' => "Unit System",
	'divelog:units_metric' => "Metric",
	'divelog:units_imperial' => "Imperial",
	'divelog:depth_metric_sm' => "m.",
	'divelog:depth_metric' => "meters",
	'divelog:depth_imperial_sm' => "ft.",
	'divelog:depth_imperial' => "feet",
	
	// form
	'divelog:site' => "Place",
	'divelog:date' => "Date",
	'divelog:depth' => "Max. depth",
	'divelog:duration' => "Duration",
	'divelog:buddies' => "Buddies",
	'divelog:buddies_hint' => "comma separated list of dive buddies",
	'divelog:media' => "Photos or videos?",
	'divelog:briefing' => "Briefing",
	'divelog:debriefing' => "Notes",
	'divelog:tags' => "Tags",
	'divelog:suggestor' => "suggested by %s",

	'divelog:save_ok' => "Your dive is loggued.",
	'divelog:save_notok' => "Your dive could not be logged (error).",
	
	// Display list
	'divelog:locale' => 'en_us',

	'divelog:time_format' => "%k:%M",

	'divelog:date_lowercase' => 'no',
	'divelog:full:date_format' => "%A %d %B",
	'divelog:short:date_format' => "%a %d %b",

	'divelog:dive_at' => 'at',
	'divelog:dive_on' => 'on',
	'divelog:in' => 'in',
	'divelog:dive_with' => 'with',

	'divelog:prompt:newdive'   => 'Dive',
	'divelog:prompt:dive_data' => "Parameters:",
	'divelog:prompt:dive_date' => 'When:',
	'divelog:prompt:dive_with' => 'Buddies:',
	'divelog:prompt:dive_note' => 'Debriefing:',

	// Statistics
	'divelog:statistics' => "Statistiques",


	// Filter headings
	"divelog:filter:friend" => "Friend's dives",
	"divelog:filter:mine" => "My dives",
	"divelog:filter:all" => "All dives",
	
	'divelog:filter:planned' => "Planned",
	'divelog:filter:buddy' => "As buddy",
	'divelog:filter:stats' => "Statistics",
	

	/**
	 * Widget and dive widget
	 */
	'divelog:widget:description' => "Show your latest dives.",


	/**
	 * Status messages
	 */

	'divelog:save:success' => "Your dive was successfully loged.",
	'divelog:delete:success' => "Your dive log was deleted.",


	/**
	 * Error messages
	 */

	'divelog:save:failed' => "Your dive log could not be saved. Make sure you've entered a site and date and then try again.",
	'divelog:save:invalid' => "The site of the dive log is invalid and could not be saved.",
	'divelog:delete:failed' => "Your dive log could not be deleted. Please try again.",
	

	/**
	 * Calendar Event Types
	 *    Note: event_calendar plugin adds 'event_calendar:type:' before supplied string.
	 *          so in admin panel, for event types, simply supply divelog, restaurant, meeting, etc.
	 **/
	'divelog:planned'			=> 'planned dive',
	'divelog:short:planned'		=> 'planned',
	'divelog:no_dive_params'	=>	'no dive data',

	// Event calendar type for divelog: This is an invitation to a planned dive.
	'event_calendar:type:divelog' 		=> "Dive",
	
	// Other event calendar types.
	'event_calendar:type:restaurant'	=> "Restaurant",
	'event_calendar:type:meeting'		=> "Meeting",
	'event_calendar:type:class'			=> "Class",
	'event_calendar:type:conference'	=> "Conference",
	'event_calendar:type:trip'			=> "Trip",
	'event_calendar:type:holiday'		=> "Holiday",

	// event_calendar options
	'divelog:create_from_event'	=> "Create planned dive in my logbook when I subscribe to a dive event in calendar",

	// event_calendar conversion
	'divelog:briefing:brief_description' => "Description",
	'divelog:briefing:fees' => "Price",
	'divelog:briefing:contact' => "Contact",
	'divelog:briefing:organiser' => "Organizer",
	'divelog:briefing:long_description' => "Description",
	'divelog:convert' => "Convert to dive log",
	'divelog:convert_hint' => "Convert this event in planned dive",
	'divelog:convert:failed' => "The convertion of this event into a dive log failed. Please try again.",
	'divelog:copy' => "Copy",
	'divelog:copy_hint' => "Create a copy of this dive in my logbook",
	'divelog:copy:failed' => "The creation of a copy of the dive failed. Please try again.",

);

add_translation('en', $english);