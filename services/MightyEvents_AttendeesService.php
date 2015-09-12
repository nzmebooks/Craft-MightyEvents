<?php
namespace Craft;

class MightyEvents_AttendeesService extends BaseApplicationComponent
{
    public function getAttendees()
    {
    	$query = craft()->db->createCommand()
	    	->select('*')
	    	->from('mightyevents_attendees')
	    	->queryAll();

	    $data = array();

	    foreach ($query as $row) {
	    	$row['dateCreated'] = date_format(date_create($row['dateCreated']), "M d, Y");
	    	$row['dateUpdated'] = date_format(date_create($row['dateUpdated']), "M d, Y");

	    	$data[] = $row;
	    }

        return $data;
    }

    public function saveAttendee($model)
    {
    	// Saving individually because getAttributes() is currently borked ;)
    	$attributes = array(
    		'name' => $model->getAttribute('name'),
    		'email' => $model->getAttribute('email'),
    		'event_id' => $model->getAttribute('event_id'),
    		'seats' => $model->getAttribute('seats')
		);

    	$record = new MightyEvents_AttendeesRecord();

		foreach ($attributes as $key => $value) {
			$record->setAttribute($key, $value);
		}

		$record->save();

		return true;
    }
}