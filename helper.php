<?php

defined('_JEXEC') or die;

class modUpcomingEventsHelper {

	public static function getAjax() {
		// Import module parameters
		jimport('joomla.application.module.helper');
		$module = JModuleHelper::getModule('mod_upcoming_events');
		$params = new JRegistry();
		$params->loadString($module->params);

		// Get module params
		$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
		$google_api_key = htmlspecialchars( $params->get('google_api_key') );
		$google_calendar_id = htmlspecialchars( $params->get('google_calendar_id') );
		$max_events = htmlspecialchars( $params->get('max_events') );

		// Get template colors
		$textcolor = $params->get('calendar_textcolor', '#FFF');
		$bgcolor1 = $params->get('calendar_bgcolor1', '#DD5522');
		$bgcolor2 = $params->get('calendar_bgcolor2', '#FF9E7A');
		$highlight = $params->get('calendar_highlight', '#DDDDDD');
		
		// Load Google API PHP Client
		require_once( __DIR__ . '/google-api-php-client/src/Google/autoload.php' );

		// New Google Client object
		$client = new Google_Client();
		$client->setApplicationName( 'Joomla! Upcoming Events Module v0.9.9' );
		$client->setDeveloperKey( $google_api_key );

		// Get Google Calendar object
		$cal = new Google_Service_Calendar($client);
		$calendarId = $google_calendar_id;
		$apiparams = array(
			'singleEvents' => true,
			'orderBy' => 'startTime',
			'timeMin' => date(DateTime::ATOM),
			'maxResults' => $max_events
		);
		
		// Get events array
		$events = $cal->events->listEvents($calendarId, $apiparams);
		$calTimeZone = $events->timeZone;
		date_default_timezone_set($calTimeZone);
		
		// Process events array, building HTML output
		$output = '';
		foreach ($events->getItems() as $event) {

			$allDay = false;
		
			$eventStart = $event->start->dateTime;
			if( empty($eventStart) ) {
				$allDay = true;
				$eventStart = $event->start->date;
			}
			$eventStart = new DateTime( $eventStart );
			
			$eventEnd = $event->end->dateTime;
			if( empty($eventEnd) ) {
				$allDay = true;
				$eventEnd = $event->end->date;
			}
			$eventEnd = new DateTime( $eventEnd );
			
			// Final extracted variables from event
			$summary = $event->summary;
			$link = $event->htmlLink;
			$location = $event->location;
			$month = $eventStart->format("M");
			$day = $eventStart->format("j");
			$dateDesc = $eventStart->format("F jS");
			if( !$allDay ) $dateDesc .= ', ' . $eventStart->format("g:ia");
			
			// Output final HTML
			$output .= '<div class="upcoming-event" style="background-color: '.$highlight.'">';
			$output .= '<div class="upcoming-event-block" style="color: '.$textcolor.'">';
			$output .= '<div class="upcoming-event-month" style="background-color: '.$bgcolor1.'">' . $month . '</div>';
			$output .= '<div class="upcoming-event-day" style="background-color: '.$bgcolor2.'">' . $day . '</div>';
			$output .= '</div>';
			$output .= '<div class="upcoming-event-date">' . $dateDesc . '</div>';
			$output .= '<div class="upcoming-event-desc">' . $summary . '</div>';
			$output .= '</div>';
		}

		// Return HTML output
		return $output;
	}

}