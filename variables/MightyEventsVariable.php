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
		$query = craft()->mightyEvents_events->getEvents();

		foreach ($query as &$row) {
			foreach ($row as $key => &$value) {
				$row[$key] = html_entity_decode($value, ENT_QUOTES);
			}
		}

		return $query;
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