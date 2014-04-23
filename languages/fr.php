<?php
/**
 * Divelog French language file
 */

$french = array(

	/**
	 * Menu items and titles
	 */
	'divelog' => "Logbook",
	'divelog:add' => "Ajouter une plongée",
	'divelog:edit' => "Modifier la plongée",
	'divelog:owner' => "Les plongées de %s",
	'divelog:friends' => "Plongées des contacts",
	'divelog:everyone' => "Toutes les plongées du site",
	'divelog:inbox' => "Boîte de réception des plongées",
	'divelog:moredivelogs' => '+ de plongées',
	'divelog:more' => "Plus de plongées",
	'divelog:with' => "Partager avec",
	'divelog:new' => "Une nouvelle plongée",
	'divelog:address' => "Adresse de la ressource à ajouter à vos plongées",
	'divelog:none' => "Aucune plongée.",
	'divelog:notification' =>
'%s a partagé une nouvelle plongée:

%s
%s

Voir et commenter cette plongée:
%s
',
	'divelog:delete:confirm' => "Etes-vous sûr(e) de vouloir supprimer cette plongée?",

	'divelog:numbertodisplay' => "Nombre de plongées à afficher",

	'divelog:shared' => "a partagé une plongée",
	'divelog:visit' => "Voir la plongée",
	'divelog:recent' => "Plongées récentes",

	'divelog:river:created' => "%s enregistré une plongée",
	'divelog:river:annotate' => "a posté un commentaire sur cette plongée",
	'divelog:river:item' => "une plongée",
	'river:commented:object:divelog' => "une plongée",
	'river:create:object:divelog' => '%s a partagé la plongée %s',
	'river:comment:object:divelog' => '%s a commenté la plongée %s',
	'item:object:divelog' => "Plongées",

	'divelog:sitemenu' => "Plongées",
	'divelog:group' => "Plongées du groupe",
	'divelog:enabledivelog' => "Activer les logs de plongées du groupe",
	'divelog:nogroup' => "Ce groupe n'a pas encore de plongées",
	'divelog:more' => "Plus de plongées",

	'divelog:no_title' => "Pas de titre",
	
	'divelog:buddy' => "Membre de la palanquée",

	/**
	 * Forms
	 */
	// admin
    'divelog:more' => "Plus d'information",
	'divelog:units_selection' => "Système d'unité",
	'divelog:units_metric' => "Métrique",
	'divelog:units_imperial' => "Impérial",
	'divelog:depth_metric' => "mètres",
	'divelog:short:depth_metric' => "m.",
	'divelog:depth_imperial' => "pieds",
	'divelog:short:depth_imperial' => "ft.",
	'divelog:duration_unit' => "minutes",
	'divelog:short:duration_unit' => "min.",
	'divelog:duration_unit:days' => "jours",
	'divelog:duration_unit:hours' => "heures",
	'divelog:duration_unit:minutes' => "minutes",
	
	// Form prompt
	'divelog:site' => "Lieu (site de plongée)",
	'divelog:date' => "Date et heure approximative de mise à l'eau",
	'divelog:depth' => "Profondeur maximale",
	'divelog:duration' => "Durée",
	'divelog:buddies' => "Palanquée",
	'divelog:buddies_hint' => "tous les membres, séparés par une virgule",
	'divelog:media' => "Photos ou vidéos?",
	'divelog:briefing' => "Briefing",
	'divelog:debriefing' => "Notes",
	'divelog:tags' => "Etiquettes",
	'divelog:suggestor' => "suggérée par %s",
	
	// Display list
	'divelog:locale' => 'fr_FR.UTF-8',
	'divelog:time_format' => "%kh%M",
	'divelog:date_lowercase' => 'yes',
	'divelog:full:date_format' => "%A %d %B %G",
	'divelog:short:date_format' => "%a %d %b",

	'divelog:dive_at' => 'à',
	'divelog:dive_on' => 'le',
	'divelog:in' => 'en',
	'divelog:dive_with' => 'avec',

	'divelog:prompt:newdive'   => 'Plongée',
	'divelog:prompt:dive_data' => "Paramètres:",
	'divelog:prompt:dive_date' => 'Quand:',
	'divelog:prompt:dive_with' => 'Palanquée:',
	'divelog:prompt:dive_briefing' => 'Briefing:',
	'divelog:prompt:dive_note' => 'Notes:',
	
	// Filter messages
	"divelog:filter:friend" => "Les plongées de mes contacts",
	"divelog:filter:mine" => "Mes plongées",
	"divelog:filter:all" => "Toutes les plongées",
	
	'divelog:filter:planned' => "Planifiées",
	'divelog:filter:buddy' => "Palanquées",
	'divelog:filter:stats' => "Statistiques",
	
	// Statistics
	'divelog:statistics' => "Statistiques",
	'divelog:statistics:count' => "Nombre de plongées logguées sur ce site",
	'divelog:statistics:totaltime' => "Temps total",
	'divelog:statistics:averagetime' => "Durée moyenne",
	'divelog:statistics:longest' => "La plus longue",
	'divelog:statistics:deepest' => "La plus profonde",
	'divelog:statistics:warning' => "Veuillez noter que ces données ne sont correctes que si vous avez rentré tous les paramètres pour toutes les plongées.",

	/**
	 * Widget
	 */
	'divelog:widget:description' => "Ce widget affiche vos dernières plongées.",


	/**
	 * Status messages
	 */
	'divelog:save:success' => "Votre plongée a été enregistrée.",
	'divelog:delete:success' => "Votre plongée a été supprimée.",


	/**
	 * Error messages
	 */
	'divelog:save:failed' => "Votre plongée n'a pu être correctement enregistrée. Vérifiez que les paramètres entrés de la plongée soient corrects et réessayez.",
	'divelog:delete:failed' => "Votre plongée n'a pu être supprimée. Merci de réessayer.",
	'divelog:save:invalid' => "Des paramètres de la plongée sont invalides et elle ne peut être enregistrée. Merci de vérifier vos paramètres.",


	/**
	 * bulk divelog upload
	 */
	'divelog:upload' => "Chargement de plongées à partir d'un fichier",
	'divelog:upload:linktopage' => "Charger un fichier de plongées",
	'divelog:upload:help' => "Pour charger vos anciennes plongées, le fichier doit être au format tel que ci-dessous.
Si la première ligne contient le nom des champs, veuillez cocher la case Ignorer la première ligne.
L'ordre des champs n'a pas d'importance si les entêtes sont présentes.
Le nom des entêtes doit scrupuleusement respecter les noms ci-dessous.
Les colonnes ou champs notes, access et tags sont optionnelles. Les autres sont obligatoires.",
	'divelog:upload:filename' => "Fichier contenant les plongées",
	'divelog:upload:ignorefirst' => "Ignorer la première ligne?",
	'divelog:upload:encoding' => "Encodage du fichier de texte",
	'divelog:upload:delimiter' => "Séparateur entre les champs (le contenu du champ ne peut pas contenir ce séparateur)",
	'divelog:upload:confirm' => "Vérifier les plongées",
	'divelog:upload:create_divelogs' => "Importer les plongées",
	'divelog:upload:process_report' => "Traitement du fichier",
	'divelog:upload:creation_report' => "Création des plongées",
	'divelog:upload:number_of_divelogs'	=> "Nombre de plongées dans le fichier",
	'divelog:upload:number_of_created_divelogs'	=> "Nombre de plongées créées",
	'divelog:upload:number_of_errors'	=> "Erreurs détectées",
	'divelog:upload:statusok' => 'OK',
	'divelog:upload:create_success' => 'Créée',
	'divelog:upload:no_created_divelogs' => "Aucune plongée à créer.",
	'divelog:error:cannot_open_file' => "Impossible de traîter le fichier",
	'divelog:error:wrong_csv_format' => "Mauvais format CSV",
	'divelog:upload:viewuploaded' => "Voir toutes mes plongées",
	'divelog:upload:see_divelogs' => "Voir toutes mes plongées",
	'divelog:upload:see_divelog' => "Voir la plongée",
	'divelog:upload:new' => "a chargé %s nouvelles plongées dans son carnet.",


	/**
	 * Calendar Event Hooks
	 *    Note: event_calendar ajoute le préfixe 'event_calendar:type:'.
	 *          donc dans le panneau d'administration, pour les types d'événement, il suffit de mentionner divelog, restaurant, meeting, etc.
	 **/
	// Calendar Event Types
	'divelog:Planned'			=> 'Plongée planifiée',
	'divelog:planned'			=> 'plongée planifiée',
	'divelog:short:planned'		=> 'planifiée',
	'divelog:no_dive_params'	=>	'Pas de paramètres de plongée',

	// Event calendar type for divelog: This is an invitation to a planned dive.
	'event_calendar:type:divelog' 		=> "Plongée",
	
	// Other event calendar types.
	'event_calendar:type:restaurant'	=> "HoReCa",
	'event_calendar:type:meeting'		=> "Réunion",
	'event_calendar:type:class'			=> "Cours",
	'event_calendar:type:conference'	=> "Conférence",
	'event_calendar:type:trip'			=> "Séjour",
	'event_calendar:type:holiday'		=> "Vacances",

	// event_calendar options
	'divelog:create_from_event'	=> "Créer une plongée planifiée dans le logbook lorsque je m'inscris à une plongée dans le calendrier",

	// event_calendar conversion
	'divelog:briefing:brief_description' => "Description",
	'divelog:briefing:fees' => "Prix",
	'divelog:briefing:contact' => "Contact",
	'divelog:briefing:organiser' => "Organisateur",
	'divelog:briefing:long_description' => "Description",
	'divelog:convert' => "Convertir en plongée",
	'divelog:convert_hint' => "Converti cet événement en plongée planifiée",
	'divelog:convert:failed' => "La conversion d'un événement en une plongée a échoué. Veuillez réessayer.",
	'divelog:copy' => "Copier",
	'divelog:copy_hint' => "Créer une copie de cette plongée dans mon logbook",
	'divelog:copy:failed' => "La création de la copie de la plongée a échoué. Veuillez réessayer.",

	/**
	 * hypeGallery Hooks
	 */
	'divelog:hypeGallery:date_format' => "%G-%m-%d",
	'divelog:hypeGallery:category' => "plongée",

	'divelog:nogallery'	=> "Il n'y a pas de photos.",
	'divelog:gallery'	=> "Photos:",

);

add_translation("fr", $french);