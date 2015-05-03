<?php
/**
 * @package     
 * @subpackage  
 *
 * @copyright   
 * @license     
 */

defined('_JEXEC') or die;

$doc = JFactory::getDocument();

// Add module stylesheet
JHtml::_('stylesheet', 'mod_upcoming_events/upcoming_events.css', array(), true);

// Get template colors
$textcolor = $params->get('calendar_textcolor', '#FFF');
$bgcolor1 = $params->get('calendar_bgcolor1', '#DD5522');
$bgcolor2 = $params->get('calendar_bgcolor2', '#FF9E7A');
$highlight = $params->get('calendar_highlight', '#DDDDDD');

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
			if( !$allDay ) $dateDesc .= ', ' . $eventStart->format("g:ia");

			// Output final HTML
			echo( '<div class="upcoming-event" style="background-color: '.$highlight.'">' );
			echo( '<div class="upcoming-event-block" style="color: '.$textcolor.'">' );
			echo( '<div class="upcoming-event-month" style="background-color: '.$bgcolor1.'">' . $month . '</div>' );
			echo( '<div class="upcoming-event-day" style="background-color: '.$bgcolor2.'">' . $day . '</div>' );
			echo( '</div>' );
			echo( '<div class="upcoming-event-date">' . $dateDesc . '</div>' );
			echo( '<div class="upcoming-event-desc">' . $summary . '</div>' );
			echo( '</div>' );
		}
	?>

</div>
