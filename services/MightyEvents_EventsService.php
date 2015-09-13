<?php
namespace Craft;

class MightyEvents_EventsService extends BaseApplicationComponent
{
    // Work on this; non-functional.
    public function getEvents()
    {
        $query = craft()->db->createCommand()
        ->select('event.name AS name, COUNT(attendee.seats) AS attendance, event.date AS date')
        ->from('mightyevents_events AS event')
        ->join('mightyevents_attendees AS attendee')
        ->where('event.id = attendee.event_id')
        ->group('event.name')
        ->queryAll();

        return $query;
    }

    public function SaveEvent($model)
    {
    	// Saving individually because getAttributes() is currently borked ;)
    	$attributes = array(
    		'name' => $model->getAttribute('name'),
    		'date' => $model->getAttribute('date'),
            'max_seats' => $model->getAttribute('max_seats')
		);

    	$record = new MightyEvents_EventsRecord();

		foreach ($attributes as $key => $value) {
			$record->setAttribute($key, $value);
		}

		$record->save();

		return true;
    }
}