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

	'divelog:shared' => "Logged dives",
	'divelog:visit' => "Visit resource",
	'divelog:recent' => "Recent dive logs",

	'divelog:river:created' => "%s logged a dive",
	'divelog:river:annotate' => "commented on this dive",
	'divelog:river:item' => "a logged dive",
	'river:commented:object:divelog' => "a logged dive",
	'river:create:object:divelog' => '%s shared dive %s',
	'river:comment:object:divelog' => '%s commented on dive %s',
	'item:object:divelog' => 'Dive Logs',

	'divelog:sitemenu' => "Dive log",
	'divelog:group' => 'Group dive logs',
	'divelog:enabledive logs' => 'Enable group dive logs',
	'divelog:nogroup' => 'This group does not have any dive logs yet',
	'divelog:more' => 'More dive logs',

	'divelog:no_title' => 'No title',

	'divelog:buddy' => "Dive buddies",

	/**
	 * Forms
	 */
	// admin
    'divelog:more' => 'More information',
	'divelog:units_selection' => "Unit System",
	'divelog:units_metric' => "Metric",
	'divelog:units_imperial' => "Imperial",
	'divelog:depth_metric' => "meters",
	'divelog:depth_imperial' => "feet",
	'divelog:short:depth_metric' => "m.",
	'divelog:short:depth_imperial' => "ft.",
	'divelog:duration_unit' => "minutes",
	'divelog:short:duration_unit' => "min.",
	'divelog:duration_unit:days' => "jours",
	'divelog:duration_unit:hours' => "heures",
	'divelog:duration_unit:minutes' => "minutes",
	
	// Form prompt
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
	'divelog:prompt:dive_briefing' => 'Briefing:',
	'divelog:prompt:dive_note' => 'Debriefing:',

	// Filter headings
	"divelog:filter:friend" => "Friend's dives",
	"divelog:filter:mine" => "My dives",
	"divelog:filter:all" => "All dives",
	
	'divelog:filter:planned' => "Planned",
	'divelog:filter:buddy' => "As buddy",
	'divelog:filter:stats' => "Statistics",
	
	// Statistics
	'divelog:statistics' => "Statistics",
	'divelog:statistics:count' => "Number of logged dives",
	'divelog:statistics:totaltime' => "Total dive time",
	'divelog:statistics:averagetime' => "Average dive duration",
	'divelog:statistics:longest' => "Longest dive",
	'divelog:statistics:deepest' => "Deepest dive",
	'divelog:statistics:warning' => "Data is correct is all dives logged properly.",

	/**
	 * Widget and dive widget
	 */
	'divelog:widget:description' => "Show your latest dives.",


	/**
	 * Status messages
	 */
	'divelog:save_ok' => "Your dive is loggued.",
	'divelog:save_notok' => "Your dive could not be logged (error).",
	

	/**
	 * Error messages
	 */
	'divelog:save:failed' => "Your dive log could not be saved. Make sure you've entered a site and date and then try again.",
	'divelog:save:invalid' => "The site of the dive log is invalid and could not be saved.",
	'divelog:delete:failed' => "Your dive log could not be deleted. Please try again.",
	

	/**
	 * bulk divelog upload
	 */
	'divelog:upload' => "Upload dives from logbook",
	'divelog:upload:linktopage' => "Upload logbook file",
	'divelog:upload:help' => "To upload dives, file must be in following format.
	If first line contains field names, please check 'Ignore first line'.
	If field names are specified, field order is not important, but field names must match exactly.
	Dive date and site are mandatory. Others are optional.
	",
	'divelog:upload:filename' => "File containing divelogs",
	'divelog:upload:ignorefirst' => "Ignore first line?",
	'divelog:upload:encoding' => "Text file encoding",
	'divelog:upload:delimiter' => "Field separator (field content cannot contain this separator)",
	'divelog:upload:confirm' => "Check divelogs",
	'divelog:upload:create_divelogs' => "Import divelogs",
	'divelog:upload:process_report' => "File processing",
	'divelog:upload:creation_report' => "Divelog creation",
	'divelog:upload:number_of_divelogs'	=> "Number of dives in file",
	'divelog:upload:number_of_created_divelogs'	=> "Number of divelog created",
	'divelog:upload:number_of_errors'	=> "Errors",
	'divelog:upload:statusok' => 'OK',
	'divelog:upload:create_success' => 'Created',
	'divelog:upload:no_created_divelogs' => "No dive to log.",
	'divelog:error:cannot_open_file' => "Impossible to process file",
	'divelog:error:wrong_csv_format' => "Bad CSV format",
	'divelog:upload:viewuploaded' => "View all my uploaded dives",
	'divelog:upload:see_divelogs' => "View all my dives",
	'divelog:upload:see_divelog' => "View divelog",
	'divelog:upload:new' => "%s uploaded new dives.",


	/**
	 * Calendar Event Hooks
	 *    Note: event_calendar plugin adds 'event_calendar:type:' before supplied string.
	 *          so in admin panel, for event types, simply supply divelog, restaurant, meeting, etc.
	 **/
	// Calendar Event Types
	'divelog:Planned'			=> 'Planned dive',
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

	/**
	 * hypeGallery Hooks
	 */
	'divelog:hypeGallery:date_format' => "%G-%m-%d",
	'divelog:hypeGallery:category' => "dive",

	'divelog:nogallery'	=> "There are no pictures.",
	'divelog:gallery'	=> "Pictures:",

);

add_translation('en', $english);