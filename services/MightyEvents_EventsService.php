<?php
namespace Craft;

class MightyEvents_EventsService extends BaseApplicationComponent
{
    // Work on this; non-functional.
    public function getEvents()
    {
        $query = craft()->db->createCommand()
        ->select('mightyevents_events.id, mightyevents_events.name, mightyevents_events.date, mightyevents_attendees.id, mightyevents_attendees.name, mightyevents_attendees.seats, mightyevents_attendees.event_id')
        ->from('mightyevents_events')
        ->join('mightyevents_attendees')
        ->queryAll();
        print_r($query);
        die;
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