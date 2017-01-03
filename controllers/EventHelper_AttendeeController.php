<?php
namespace Craft;

class EventHelper_AttendeeController extends BaseController
{
    // Allows guests to sign up on the front-end form.
    protected $allowAnonymous = true;

    /**
     * Create and prep an Attendee object to be sent to the Service. This
     * method also santizes user input as much as reasonably possible.
     *
     * @method actionSaveAttendee
     * @return void
     *
     * TODO : return the model with errors. (Currently non-functional.)
     */
    public function actionSaveAttendee()
    {
        $this->requirePostRequest();

        foreach (craft()->request->getPost() as $key => $value) {
            // Cleanse the data as much as possible
            $encodedValue = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            $encodedValue = htmlspecialchars($value, ENT_QUOTES);
            $encodedValue = htmlentities($encodedValue);

            $data[substr($key, 9)] = $encodedValue;
        }

        $attendee = new EventHelper_AttendeeModel();
        $attendee->userId = $data['userId'];
        $attendee->name = $data['name'];
        $attendee->email = $data['email'];
        $attendee->eventId = $data['eventId'];
        $attendee->seats = $data['seats'];

        $eventsGlobals = craft()->globals->getSetByHandle('events');
        // You need to declare a rules() method in your model for the
        // validate method to work.
        if ($attendee->validate()) {
            craft()->eventHelper_attendees->SaveAttendee($attendee);

            $notice = $eventsGlobals->rsvpSuccess ? $eventsGlobals->rsvpSuccess : 'Thanks for your RSVP!';

            craft()->userSession->setNotice("$notice<br /><br /><a href='/events/ical/{$data['eventId']}'>Add this event to your calendar.</a>");
            return;
        }

        craft()->userSession->setError($eventsGlobals->rsvpFailure ? $eventsGlobals->rsvpFailure : 'Something wasn\'t right about your reservation. Try submitting it again.');
        craft()->urlManager->setRouteVariables(array(
            'attendee' => $attendee
        ));

        $this->redirectToPostedUrl();
    }

    /**
     * Delete an attendee from an event. This
     * method also santizes user input as much as reasonably possible.
     *
     * @method actionRemoveAttendee
     * @return void
     *
     * TODO : return the model with errors. (Currently non-functional.)
     */
    public function actionRemoveAttendee()
    {
        $this->requirePostRequest();

        foreach (craft()->request->getPost() as $key => $value) {
            // Cleanse the data as much as possible
            $encodedValue = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            $encodedValue = htmlspecialchars($value, ENT_QUOTES);
            $encodedValue = htmlentities($encodedValue);

            $data[substr($key, 9)] = $encodedValue;
        }

        $attendee = new EventHelper_AttendeeModel();
        $attendee->userId = $data['userId'];
        $attendee->eventId = $data['eventId'];

        $eventsGlobals = craft()->globals->getSetByHandle('events');

        if (craft()->eventHelper_attendees->RemoveAttendee($attendee)) {
            craft()->userSession->setNotice($eventsGlobals->rsvpRemovalSuccess ? $eventsGlobals->rsvpRemovalSuccess : 'Your reservation has been removed for this event.<br />We hope to see you at future events.');
            return;
        }

        craft()->userSession->setError($eventsGlobals->rsvpRemovalFailure ? $eventsGlobals->rsvpRemovalFailure : 'Something wasn\'t right about your removal request. Try submitting it again.');
        craft()->urlManager->setRouteVariables(array(
            'attendee' => $attendee
        ));

        $this->redirectToPostedUrl();
    }

    /**
     * Download export.
     *
     * @return string CSV
     */
    public function actionDownload()
    {
        // Get data
        $data = craft()->eventHelper->download();

        // Set a cookie to indicate that the export has finished.
        $cookie = new HttpCookie('eventhelperExportFinished', 'true');
        $cookie->httpOnly = false;
        $cookie->expire = time() + 3600;
        craft()->request->getCookies()->add($cookie->name, $cookie);

        $dateGenerated = new DateTime();
        $timezone = new \DateTimeZone(DateTime::UTC);
        $dateGenerated = $dateGenerated->format('d-m-Y\TH:i:s', $timezone);

        // Download the csv
        craft()->request->sendFile("event_helper_export_{$dateGenerated}.csv", $data, array('forceDownload' => true, 'mimeType' => 'text/csv'));
    }
}
