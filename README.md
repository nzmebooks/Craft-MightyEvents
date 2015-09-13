![Mighty Events](http://www.taylordaughtry.com/mighty-events-image.png)

# Mighty Events

![Craft](https://img.shields.io/badge/craft-v2.4-orange.svg)
[![Codacy](https://img.shields.io/badge/code%20quality-A-brightgreen.svg)](https://www.codacy.com/app/hello_10/mightyevents/dashboard)

Mighty Events is a simple module that gives you the ability to track event attendance, as well as communicate with attendees for each event.

## Features
The module is very-much in an alpha stage. Indeed, it even has placeholder text in the administration area. It is fully-functional, but it simply provides a front-end form with attendance tracking on the back-end. Future features are outlined below.

## Additions
- Per-event attendee tracking
- Allow attendees to update their RSVP, if logged in
- Attendee notifications about event information
- Accept payments for event attendance
- Export attendance data to CSV, PDF, etc.

## Usage

If you'd like to play around with MightyEvents while it's in alpha, here are a
few things you need to know:

### Event Signup Forms

Here's the basic structure of an event form:

````
<form method="post" action="">
	<input type="hidden" name="action" value="mightyEvents/attendee/SaveAttendee">
	<input type="hidden" name="attendee_event_id" value="1">
	<label for="attendee_name">Attendee Name</label>
	<input type="text" name="attendee_name">
	<label for="attendee_email">Attendee Email Address</label>
	<input type="text" name="attendee_email">
	<label for="attendee_seats">Seats Required</label>
	<input type="text" name="attendee_seats">
	<input type="submit" value="Reserve your Seat">
</form>
````

Date is submitted via `POST` into the module, where it's validated and saved to
the database. The `name` attributes on each `input` require a namespace of
`attendee_XXXX` to make sure the module only captures the `POST` values it needs.

Notice that the `action` attribute on the form is blank. This submits it to the
same page by default. A `Flash` value is passed as a `Notice` on success, or an
`Error` when something's not right. (Usually bad data.) The `action` hidden
input actually sends the data to the Mighty Events controller, which processes
the data.

### Database Structure

There are currently two tables used in MightyEvents: Attendees and Events. The
Events table isn't currently being used, but will eventually be a part of a
Many-to-Many relationship with the attendees, which will allow for attendees to
signup for multiple events. (This is slated for a future release; it'll be
very soon, however.)