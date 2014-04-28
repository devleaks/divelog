Dive Logbook
============

Record dives in a logbook and share them with friends.


## Features ##

The current logbook records basic dive data such as dive site, duration, depth reached, dive buddies,
and whether pictures or videos were taken.
The module can easily be extended to record additional information.

When a dive buddy is an Elgg user, it appears as a link to his or her logbook.

The divelog module may be integrated with two other modules: event_calendar and hypeGallery.


# User's Manual #


## Tabs ##


#### All Dives ####

All dives you have access to.

#### My Dives ####

All your dives.

#### Contact Dives ####

All dives from your contact.

#### Buddy Dives ####

Dives you do not own (but still have access to) where your name appears as a buddy.

#### Planned Dives ####

Lists all dive logs with a date in the future. These dives appears with a _planned dive_ text.

The Planned dives also lists all future events in the event calendar marked as _dives_.
These _events_ can be converted to _planned dive_ by pressing the _Convert to planned dive_ link.

Note on dive notes: When editing dives with date in the future (planned dives), the following occurs:
* When a dive is planned (date in the future), notes are saved as _brieifing_ notes.
* When a dive is completed (date in the past), notes are saved as _debriefing_ notes and briefing notes can no longer by edited.

#### Statistics ####

Displays a few statistics about your dives.


### River and Dive Details ###

In river and divelog titles, date is made as short as possible.
For instance, date year does not appear for date less than 6 months ago.


## Preferences ##

### Site/Module Preferences ###

The administrator of a site can set the default, site-wide unit system in use (_metric_ or _imperial_).

The Unit system is saved with each dive.
(When the Unit system is changed, no convertion occurs on existing recoreded values.)

### User/Module Preferences ###

#### Unit System ####

Each individual user (diver) can set a preferred unit system  (_metric_ or _imperial_).

The Unit system is saved with each dive.
(When the Unit system is changed, no convertion occurs on existing recoreded values.)

#### Import Dives ####

Import divelog from a CSV file.

From "Settings / Configure your tools", import and parse CSV file.
Sample line to import (with option to ignore first line):

```
"Date","Time","Site","Depth","Duration","Access","Tags","Buddies","Notes"
"15/04/1971","15:45","Blue Hole, Belize","39","44","1","belize","Albert Falco","Deep dive."
```

Dive date and site are mandatory.
All other fields are optional.

Remove depth and duration decimal fraction. (It must be an integer value.)

Date must be in the DD/MM/YYYY format. Hours must be in the HH:MM where HH is in 24 hour format (no 3PM but rather 15:).

Units used in the CSV file (for depth) must match unit set for current user.

Notes: Import may fail depending on your global PHP local settings for data/number format.


If the first line does not contain column headings, all columns must be present and MUST be in the following order:

```php
date, time, site, depth, duration, access, tags, buddies, notes.
```

The upload process starts be supplying a file, its character encoding, the field separator used, and whether the first line
of the file contains field names or not.

- The process uploads the file, parses it, and present divelog candidates.
- Second, the user accept divelog candidates and divelogs are effectively created.
- Finally, a creation report list imported dives.



### Interface to event_calendar Module ###

Event_calendar is a general purpose event and calendar module.
It allows users to add new events or register (partcipate) to existing ones.

If enabled on your Elgg site, the **event_calendar** module will work with divelog.

To  link event_calendar to Divelog, you need to enable `event_types` in event_calendar
and register a new type of event: Dives!
The name of the event type need to be `divelog`.

Users of Elgg will be able to create a special type of event (_dives_),
and there will be an automatic conversion of such a dive _event_ to a loggued dive in your logbook.



### Interface to hypeGallery Module ###

**hypeGallery** is a general purpose Photo gallery application.

If you posted pictures of the dive on Elgg, and checked the "Dive Pictures & Videos" checkbox in your logbook,
divelog will establish a relationship between your divelog and your dive pictures in your logbook.

To link hypeGallery to divelog, the album must satisfy the following conditions:

Go to _Edit Album_, press the _(i) Add other details_ link to reveal more album metadata:

hypeGallery Album Field | Divelog Requirement
--- | ---
date | Must correspond to the 'dive_date' of divelog.
categories | Must contain the text _divelog_.


A link will appears in the dive detail page to point at recorded pictures or videos.



## Technical Notes ##


#### divelog Data ####

The following meta-data can be entered for each logged dive.

Meta Data | Description
--- | ---
container_guid | ElggUser who is owner
dive_site | Dive dive
dive_date | Dive date (date only, time is 00:00)
dive_start_time | Dive time
dive_depth | Dive maximum depth reached
dive_duration | Dive duration
dive_buddies | Comma separated list of dive buddies. Use elgg `username` if possible.
dive_briefing | Pre-dive notes
dive_debriefing | Debriefing notes (post-dive)
dive_media | True or false: There are media (photos and/or videos) associated with this dive
dive_suggestor | When created from an Event Calendar, creator of the Event Calendar Post.
units | Unit system used to enter dive parameters
title | Dive title, built from dive site, date and time.
description | Dive description, built from dive site, date, time, buddies.
tags | Dive tags


When a dive buddy is the username of an existing ElggUser,
it appears as a link to its dive logbook, and the relationship

```php
add_entity_relationship($buddy_GUID, "divelog_buddy", $divelog_GUID)
```

is created. It is easier to find divelogs where the user appears.


#### Relation to Event Calendar ####

If the module event_calendar is available, there is a relationship between divelog and event_calendar.

In event_calendar module,  you must enable "Event Type", and create an event type called "divelog".
All events created in the event_calendar will after appear as "planned dive".

In the listing of planned dives, next to an event of type divelog, there will be a menu item to "Convert to divelog".
Pressing this link will create a new dive in the user's logbook with the same date and time as the calendar event.
When displayed as a planned divelog, the corresponding event calendar no longer appears.

When a divelog is created from an event, the following fields a copied

Divelog Field | Event Calendar Field
--- | ---
dive_site | venue
dive_date | start_date
dive_start_time | start_time
dive_briefing | briefing
dive_suggestor | container_guid
tags | event_tags
title | title
description | brief_description

When a divelog is created from an event, the relationship

```php
add_entity_relationship($divelog_GUID, "divelog_event_calendar", $event_GUID)
```

is created.

When an event has been converted to a planned dive, it no longer appears as an _event_ but as a planned dive.


#### Relation to hypeGallery ####

When  pictures or videos related to the dive are published in an album, the relationship

```php
add_entity_relationship($divelog_GUID, "divelog_media", $album_GUID)
```

is created.

Linked album are displayed in the dive log detail page (only).

To link album to divelog, the album must have the following metadata
(Go to Edit Album, press the "Additional information" link to reveal more album metadata):

hypeGallery Album Field | Divelog Requirement
date | Must correspond to the 'dive_date' of divelog.
categories | Must contain the text of localized string 'divelog:hypeGallery:category'.

Notes: Currently, search for corresponding album are performed at divelog save time,
and when dive log detail page is requested.
The latest is not the most efficient method, and work around are in progress.


#### Relation Between Dives ####

Work in progress. The goal to establish relationship between dives at the same site the same day.

(When completed) Divelog will display related dives in the dive log detail page.


##### Club Dives #####

If two dives have

  * Same dive site
  * Same date
  * Approximate same dive time

they are said to be dives from the _same club dives_ and are linked together.

```php
add_entity_relationship($divelog_GUID, "divelog_club_dive", $album_GUID)
```


##### Same Dive #####

If in addition to the above,

  * the owner of one of the two dives is a dive buddy in the second dive,
  * the dive depth is about the same (within a reasonable depth difference),
  * the duration of the dive is about the same (within a reasonable duration difference),

they are said to be the _same dive_ (recorded by two buddies) and are linked together.

```php
add_entity_relationship($divelog_GUID, "divelog_same_dive", $album_GUID)
```



## Issues ##

Importing CSV files has not been extensively tested. Issues remains and will be addressed in future releases.
If sticking to stated rules above, should work smoothly. But exceptions are not handled.



## To Do ##

The core of this module is the Bookmarks module, with a kind of a global substitution of the word Divelog for Bookmark.
After, a few features were slowly added, like convertion of Events to Divelogs, or link to hypeGallery,
and bookmarks specific features were removed.

The upload feature was inspired by the upload_groups module.

This is a first Elgg specific development, so some Elgg conventions may not be respected.


### General, automation ###

* Auto create(/delete) divelog upon event calendar subscription (user use requested it.)
* User: Automatically insert a new divelog (planned dive) when user confirm registration to events of type `event_calendar:type:divelog`?
* User: Accept new divelog from buddies when they create a new dive log and I am listed a buddy and I have not added the dive yet.
* Create 'club_dive' and 'same_dive' relationships. Display these relationships in Dive details.
* Update relations to hypeGallery album when they are created, updated, or deleted.
* Be nice to other modules and provide hooks on divelog creation, update, deletion (if requested.)


### Development ###

* Tokenize dive sites so that people use same name for the same site (easier to normalize...)
* Migrate to Elgg 1.9.
* Migrate objects to namespace. (Will be completed with Elgg 1.9 migration.)
