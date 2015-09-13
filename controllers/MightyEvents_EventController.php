<?php
namespace Craft;

class MightyEvents_EventController extends BaseController
{

    public function actionSaveEvent()
    {
    	$this->requirePostRequest();

    	foreach (craft()->request->getPost() as $key => $value) {
    		if ($key == 'event_date') {
    			$data[$key] = date('Y-m-d H:i:s', strtotime($value['date']));
    		} else {
	    		// Cleanse the data as much as possible
	    		$encodedValue = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
	    		$encodedValue = htmlspecialchars($value, ENT_QUOTES);
	    		$encodedValue = htmlentities($encodedValue);

	    		$data[$key] = $encodedValue;
	    	}
    	}

    	$event = new MightyEvents_EventModel();
    	$event->name = $data['event_name'];
    	$event->date = $data['event_date'];
    	$event->max_seats = $data['max_seats'];

		// You need to declare a rules() method in your model for the
		// validate method to work.
		if ($event->validate()) {
			craft()->mightyEvents_events->SaveEvent($event);
			craft()->userSession->setNotice('Your reservation was successful!');
			return;
		}

		craft()->userSession->setError('Something wasn\'t right about your reservation. Try submitting it again.');
		craft()->urlManager->setRouteVariables(array(
			'event' => $event
		));

		$this->redirectToPostedUrl();
    }
}