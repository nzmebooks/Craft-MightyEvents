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

	public function getEvents()
	{
		return craft()->mightyEvents_events->getEvents();
	}

	public function getPlugin()
	{
		return craft()->plugins->getPlugin('mightyEvents');
	}

	public function getPluginName()
	{
		return $this->getPlugin()->getPluginName();
	}

	public function getPluginUrl()
	{
		return $this->getPlugin()->getPluginUrl();
	}

	public function getPluginVersion()
	{
		return $this->getPlugin()->getPluginVersion();
	}

	public function getCpTabs()
	{
		return $this->getPlugin()->getCpTabs();
	}

}