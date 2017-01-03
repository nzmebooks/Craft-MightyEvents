<?php
namespace Craft;

class EventHelper_EventsService extends BaseApplicationComponent
{
    public function getEvents()
    {
        $query = craft()->db->createCommand()
            ->select('entries.id, content.title, content.field_dateStart, content.field_dateEnd, COUNT(attendee.seats) AS attendance')
            ->from('content')
            ->join('entries AS entries', 'content.elementId = entries.id')
            ->join('sections AS sections', 'entries.sectionId = sections.id')
            ->leftJoin('eventhelperattendees AS attendee', 'entries.id = attendee.eventId')
            ->where('sections.handle = "events"')
            ->andWhere('content.field_dateEnd > NOW()')
            ->group('content.title')
            ->queryAll();

        return $query;
    }
}
