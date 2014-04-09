Dive Logbook
============

Allow you to record dives in a logbook and share them with friends.


# Features #

The current logbook records basic dive data such as dive site, duration, depth reached, dive buddies,
and whether pictures or videos were taken.
The module can easily be extended to record additional information.

When a dive buddy is an Elgg user, it appears as a link to his or her logbook.

The divelog module may be integrated with two other modules: event_calendar and hypeGallery.


# User's Manual #

## Tabs ##

### All Dives ###

All dives lists all dives you have access to.

### My Dives ###

My dives lists all your dives.

### Contact Dives ###

Contact dives lists all dives from your contact.

### Buddy Dives ###

Buddy dives lists dives you do not own (but still have access to) where your name appears as a dive buddy.

### Planned Dives ###

Planned dives lists all dive logs with a date in the future. Those dives appears with a _planned dive_ text.

The Planned dives also lists all future events in the event calendar marked as _dives_.
These events can be converted to planned dive by pressing the _Convert to planned dive_ link.

When editing dives with date in the future (planned dives), the following occurs:
When a dive is planned (date in the future), notes are saved as _brieifing_ notes.
When a dive is completed (date in the past), notes are saved as _debriefing_ notes and briefing notes can no longer by edited.


### Statistics ###

Dive log book statistics displays a few statistics about your dives.



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

From "user settings", import and parse CSV. Sample line to import (option to ignore first line):

```
"Date","Time","Site","Depth","Duration","Access","Tags","Buddies","Notes"
"15/09/2013","15:45","Vodelée","36","38","1","vodelée","rackham, Ann","Belle plongée"
```

Avoid depth and duration decimal fraction. Import may fail depending on your global PHP local settings for data/number format.

Dive date and site are mandatory. All other fields are optional.




## Interface to event_calendar Modules ##

Event_calendar is a general purpose event and calendar module.
It allows users to add new events or register (partcipate) to existing ones.

If enabled on your Elgg site, the **event_calendar** module will work with divelog.

To  link event_calendar to Divelog, you need to enable `event_types` in event_calendar
and register a new type of event: Dives! The name of the event type need to be `divelog`.

Users of Ellg will be able to create a special type of event (_dives_),
and there will be an automatic conversion of such a dive _event_ to a loggued dive in your logbook.



## Interface to hypeGallery Modules ##

**hypeGallery** is a general purpose Photo gallery application.

If you posted pictures of the dive on Elgg, and checked the "Dive Pictures & Videos" checkbox in your logbook,
divelog will establish a relationship between your divelog and your dive pictures in your logbook.

A link will appears in the dive detail page to point at recorded pictures or videos.

(Note: Due to recent modification of hypeGallery, this option is temporarily unavailable.)


# Technical Notes #

The core of this module is the Bookmarks plugins, with a kind of a global substitution of the word Divelog for Bookmark.
After, a few features were slowly added, like convertion of Events to Divelogs, and bookmarks specific features were removed.


### divelog Data ###

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


When a dive buddy is the username of an existing ElggUser, it appears as a link to its dive logbook, and the relationship

```php
add_entity_relationship($buddy_GUID, "divelog_buddy", $divelog_GUID)
```

is created. It is easier to find divelogs where the user appears.


### Relation to Event Calendar ###

If the module event_calendar is available, there is a hidden relationship between divelog and event_calendar.

In event_calendar module,  you must enable "Event Type", and create an event type called "divelog".
All events created in the event_calendar will after appear as "planned dive".

In the listing of planned dives, next to an event of type divelog, there will be a menu item to "Convert to divelog".
Pressing this link will create a new dive in the user's logbook with the same date and time as the calendar event.
When displayed as a planned dive, the corresponding event calendar no longer appears.

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


### Relation to hypeGallery ###

When some pictures or videos related to the dive are published in an album, and the relationship

```php
add_entity_relationship($divelog_GUID, "divelog_media", $album_GUID)
```

is created.


### Relation to other Dives ###

(Work in progress. The goal to establish relationship between dives at the same site the same day.)

#### Club Dives ####

If two dives have

  * Same dive site
  * Same date
  * Approximate same dive time

they are said to be dives from the _same club dives_ and are linked together.


```php
add_entity_relationship($divelog_GUID, "divelog_club_dive", $album_GUID)
```

#### Same Dive ####

If in addition to the above,

  * the owner of one of the two dives is a dive buddy in the second dive,
  * the dive depth is about the same (within a reasonable depth difference),
  * the duration of the dive is about the same (within a reasonable duration difference),

they are said to be the _same dive_ (recorded by two buddies) and are linked together.

```php
add_entity_relationship($divelog_GUID, "divelog_same_dive", $album_GUID)
```


# To Do #

## Auto create(/delete) divelog upon event calendar subscription ##

* User: Automatically insert a new divelog (planned dive) when user confirm registration to events of type `event_calendar:type:divelog`?
* User: Accept new divelog from buddies when they create a new dive log and I am listed a buddy and I have not added the dive yet.

## Issues ##

Importing CSV files has not been extensively tested.
Issues remains and will be addressed in future releases.
