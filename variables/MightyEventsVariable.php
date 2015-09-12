<?php

namespace Craft;

class MightyEventsVariable
{
	public function getAttendees()
	{
		return craft()->mightyEvents_attendees->getAttendees();
	}

}