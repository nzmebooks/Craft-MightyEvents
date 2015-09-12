<?php
namespace Craft;

class MightyEvents_AttendeeModel extends BaseModel
{
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('email', 'required'),
			array('event_id', 'required'),
			array('seats', 'required')
		);
	}

    protected function defineAttributes()
    {
        return array(
            'name' => AttributeType::String,
            'email' => AttributeType::String,
            'event_id' => AttributeType::Number,
            'seats' => AttributeType::Number
        );
    }
}