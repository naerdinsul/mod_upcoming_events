<?php
/**
 * @package     
 * @subpackage  
 *
 * @copyright   
 * @license     
 */

defined('_JEXEC') or die;

// Add module stylesheet
JHtml::_('stylesheet', 'mod_upcoming_events/upcoming_events.css', array(), true);

?>
<div class="upcoming-event-calendar<?php echo $moduleclass_sfx ?>" >
	<?php
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
			if( !$allDay ) $dateDesc .= ', ' . $eventStart->format("H:ma");

			// Output final HTML
			echo( '<div class="upcoming-event">' );
			echo( '<div class="upcoming-event-block">' );
			echo( '<div class="upcoming-event-month">' . $month . '</div>' );
			echo( '<div class="upcoming-event-day">' . $day . '</div>' );
			echo( '</div>' );
			echo( '<div class="upcoming-event-date">' . $dateDesc . '</div>' );
			echo( '<div class="upcoming-event-desc">' . $summary . '</div>' );
			echo( '</div>' );
		}
	?>

</div>
