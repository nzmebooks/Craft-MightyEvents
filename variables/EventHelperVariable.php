<?php

namespace Craft;

class EventHelperVariable
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
		return craft()->eventHelper_attendees->getAttendees();
	}

	/**
	 * Returns a boolean indicating whether a supplied event is attended by a supplied user.
	 *
	 * @method isAttended
	 * @return Boolean
	 */
	public function isAttended($eventId, $userId)
	{
		return craft()->eventHelper_attendees->isAttended($eventId, $userId);
	}

	public function getEvents()
	{
		$query = craft()->eventHelper_events->getEvents();

		foreach ($query as &$row) {
			foreach ($row as $key => &$value) {
				$row[$key] = html_entity_decode($value, ENT_QUOTES);
			}
		}

		return $query;
	}

	public function getPlugin()
	{
		return craft()->plugins->getPlugin('eventHelper');
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
