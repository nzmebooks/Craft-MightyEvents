<?php
namespace Craft;

class EventHelper_AttendeesService extends BaseApplicationComponent
{
    /**
     * Gets all attendees for all upcoming events from the database.
     * This is only useful in the CP, where you might want to view all attendees
     * across all of your events.
     * Return a multidimensional array that's available in the CP.
     *
     * @method getAttendees
     * @return array
     */
    public function getAttendees()
    {
        $query = craft()->db->createCommand()
            ->select('eventhelperattendees.*, content.title')
            ->from('eventhelperattendees')
            ->leftJoin('entries AS entries', 'entries.id = eventhelperattendees.eventId')
            ->join('content AS content', 'content.elementId = entries.id')
            ->where('content.field_dateStart > NOW()')
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
     * Gets all attendees for all upcoming events from the database, for use in a CSV report.
     * This is only useful in the CP, where you might want to view all attendees
     * across all of your events.
     * Return a multidimensional array.
     *
     * @method getAttendeesForCsv
     * @return array
     */
    public function getAttendeesForCsv()
    {
        $query = craft()->db->createCommand()
            ->select('eventhelperattendees.name, eventhelperattendees.email, eventhelperattendees.dateCreated, content.title')
            ->from('eventhelperattendees')
            ->leftJoin('entries AS entries', 'entries.id = eventhelperattendees.eventId')
            ->join('content AS content', 'content.elementId = entries.id')
            ->where('content.field_dateStart > NOW()')
            ->queryAll();

        $data = array();

        foreach ($query as $row) {
            $row['dateCreated'] = date_format(date_create($row['dateCreated']), "Y-m-d");

            $data[] = $row;
        }

        $data = array_merge([['Name', 'Email', 'RSVP Date', 'Event']], $data);

        return $data;
    }

    /**
     * Determines whether a given event is attended by a given user.
     *
     * @method isAttended
     * @return Boolean
     */
    public function isAttended($eventId, $userId)
    {
        //$user = $user = craft()->userSession->getUser();

        $query = craft()->db->createCommand()
            ->select('eventhelperattendees.*, content.title')
            ->from('eventhelperattendees')
            ->leftJoin('entries AS entries', 'entries.id = eventhelperattendees.eventId')
            ->join('content AS content', 'content.elementId = entries.id')
            ->where('eventhelperattendees.userId = ' . $userId)
            ->andWhere('entries.id = ' . $eventId)
            ->queryAll();

        return count($query) ? true : false;
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
            'userId' => $model->getAttribute('userId'),
            'name' => $model->getAttribute('name'),
            'email' => $model->getAttribute('email'),
            'eventId' => $model->getAttribute('eventId'),
            'seats' => $model->getAttribute('seats')
        );

        $record = new EventHelper_AttendeesRecord();

        foreach ($attributes as $key => $value) {
            $record->setAttribute($key, $value);
        }

        $record->save();

        return true;
    }

    /**
     * Remove an individual attendee from the Attendees table.
     *
     * @method removeAttendee
     * @param object $model An Attendee object.
     * @return integer
     *
     * TODO : Use getAttributes() to assign values at once when it's fixed.
     */
    public function removeAttendee($model)
    {
        // Saving individually because getAttributes() is currently borked ;)
        $attributes = array(
            'userId' => $model->getAttribute('userId'),
            'eventId' => $model->getAttribute('eventId')
        );

        $record = new EventHelper_AttendeesRecord();

        // foreach ($attributes as $key => $value) {
        //     $record->setAttribute($key, $value);
        // }
        return $record->deleteAllByAttributes($attributes);
    }
}
