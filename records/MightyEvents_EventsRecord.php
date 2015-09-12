<?php

namespace Craft;

class MightyEvents_EventsRecord extends BaseRecord
{
	public function getTableName()
	{
		return "mightyevents_events";
	}

	protected function defineAttributes()
	{
		$attributes = array(
			'name' => AttributeType::String,
			'date' => AttributeType::Number,
		);

		return $attributes;
	}
}