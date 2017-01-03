<?php

namespace Craft;

class EventHelper_AttendeesRecord extends BaseRecord
{
	public function getTableName()
	{
		return "eventhelperattendees";
	}

	// A good way to see possible fields that can be used here is to print_r an
	// instance of the model associated with this Record.
	protected function defineAttributes()
	{
		$attributes = array(
			'userId' => array(
				'type' => AttributeType::Number,
				'required' => true
			),
			'name' => array(
				'type' => AttributeType::String,
				'required' => true
			),
			'email' => array(
				'type' => AttributeType::Email,
				'required' => true
			),
			'eventId' => array(
				'type' => AttributeType::Number,
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
