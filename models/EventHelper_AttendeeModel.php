<?php
namespace Craft;

class EventHelper_AttendeeModel extends BaseModel
{
	public function rules()
	{
		return array(
			array('userId', 'required'),
			array('name', 'required'),
			array('email', 'required'),
			array('eventId', 'required'),
			array('seats', 'required')
		);
	}

	protected function defineAttributes()
	{
		return array(
			'userId' => AttributeType::Number,
			'name' => AttributeType::String,
			'email' => AttributeType::String,
			'eventId' => AttributeType::Number,
			'seats' => AttributeType::Number
		);
	}
}
