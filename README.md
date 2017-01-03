![Event Helper](http://www.taylordaughtry.com/mighty-events-image.png)

# Event Helper

Event Helper is a simple Craft CMS plugin forked from [Might Events](https://github.com/taylordaughtry/Craft-MightyEvents) that gives you the ability to track event attendance.

Users interested in attending an event can, via a form submission, register their interest.

## Usage

### Event Signup Forms

Here's the basic structure of an event form:

````
{% if craft.session.isLoggedIn %}
    {% if craft.eventHelper.isAttended(entry.id, currentUser.id) %}
        <form method="post" action="" accept-charset="UTF-8">
            {{ getCsrfInput() }}
            <input type="hidden" name="action" value="eventHelper/attendee/RemoveAttendee">
            <input type="hidden" name="attendee_eventId" value="{{ entry.id }}">
            <input type="hidden" name="attendee_userId" value="{{ currentUser.id }}">
            <p>You are going to this event.</p>
            <input type="submit" class="button" value="Change RSVP">
        </form>
    {% else %}
        <form method="post" action="" accept-charset="UTF-8">
            {{ getCsrfInput() }}
            <input type="hidden" name="action" value="eventHelper/attendee/SaveAttendee">
            <input type="hidden" name="attendee_eventId" value="{{ entry.id }}">
            <input type="hidden" name="attendee_userId" value="{{ currentUser.id }}">
            <input type="hidden" name="attendee_name" value="{{ currentUser.fullName }}">
            <input type="hidden" name="attendee_email" value="{{ currentUser.email }}">
            <input type="hidden" name="attendee_seats" value="1">
            <input type="submit" class="button" value="RSVP">
        </form>
    {% endif %}
{% else %}
    <a class="button" href="/login">Login to RSVP</a>
{% endif %}
````

Date is submitted via `POST` into the module, where it's validated and saved to
the database. The `name` attributes on each `input` require a namespace of
`attendee_XXXX` to make sure the module only captures the `POST` values it needs.

Notice that the `action` attribute on the form is blank. This submits it to the
same page by default. A `Flash` value is passed as a `Notice` on success, or an
`Error` when something's not right. (Usually bad data.) The `action` hidden
input actually sends the data to the Event Helper controller, which processes
the data.

When a user RSVP's or removes their RSVP, we set a flash notice accordingly. We provide fallback values for these flash messages, but they can be overridden via the following globals:

* $eventsGlobals->rsvpSuccess
* $eventsGlobals->rsvpFailure
* $eventsGlobals->rsvpRemovalSuccess
* $eventsGlobals->rsvpRemovalFailure


### Database Structure

We currently presume the existence of a section with a handle of `events`, which has entries with fields that have the following handles:

* title
* dateStart
* dateEnd

The `attendee_eventId` submitted from the frontend from is expected to map to a `content.id` field (i.e. the record representing the event):

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
