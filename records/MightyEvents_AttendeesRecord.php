<?php

namespace Craft;

class MightyEvents_AttendeesRecord extends BaseRecord
{
	public function getTableName()
	{
		return "mightyevents_attendees";
	}

	protected function defineAttributes()
	{
		$attributes = array(
			'name' => array(
				'type' => AttributeType::String,
				'required' => true
			),
			'email' => array(
				'type' => AttributeType::Email,
				'required' => true
			),
			'seats' => array(
				'type' => AttributeType::Number,
				'required' => true
			)
		);

		return $attributes;
	}
}