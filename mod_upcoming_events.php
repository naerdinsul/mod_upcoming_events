<?php

defined('_JEXEC') or die;

$doc = JFactory::getDocument();

// Add AJAX javascript handler
$js = <<<JS

(function ($) {
	$(document).on( 'ready', function () {
		request = {
			'option' : 'com_ajax',
			'module' : 'upcoming_events',
			'format' : 'raw'
		};
		$.ajax({
			type   : 'POST',
			data   : request,
			success: function (response) {
				var mydiv = $('.upcoming-event-calendar-ajax');
				mydiv.css('height', mydiv.height() );
				mydiv.html( response );
				mydiv.wrapInner('<div/>');
				var newheight = $('div:first',mydiv).height();
				mydiv.animate( {height: newheight} );
				mydiv.css('background-color', 'white' );
			},
			error: function( response ) {
				$('.upcoming-event-calendar-ajax').html('Sorry. Calendar currently unavailable.');
			}
		});
		return false;
	});
})(jQuery)

JS;

$doc->addScriptDeclaration( $js );

// Display module!
require JModuleHelper::getLayoutPath('mod_upcoming_events', $params->get('layout', 'default'));
