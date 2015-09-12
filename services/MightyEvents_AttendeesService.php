<?php
namespace Craft;

class MightyEvents_AttendeesService extends BaseApplicationComponent
{
	/**
	 * Gets all attendees for all events from the database. This is only useful
	 * in the CP, where you might want to view all attendees across all of your
	 * events. Return a multidimensional array that's available in the CP.
	 *
	 * @method getAttendees
	 * @return array
	 */
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

    /**
     * Save an individual attendee to the Attendees table.
     *
     * @method saveAttendee
     * @param object $model An Attendee object.
     * @return boolean
     *
     * TODO : Use getAttributes() to assign values at once when it's fixed.
     */
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