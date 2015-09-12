<?php

namespace Craft;

class MightyEventsVariable
{
	/**
	 * Provides the CP with the necessary variables to access the database.
	 * Pretty straightforward; you'll see this in most modules.
	 *
	 * @method getAttendees
	 * @return array
	 */
	public function getAttendees()
	{
		return craft()->mightyEvents_attendees->getAttendees();
	}

}