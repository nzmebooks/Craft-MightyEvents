<?php
namespace Craft;

class MightyEvents_EventModel extends BaseModel
{
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('date', 'required'),
			array('max_seats', 'required')

		);
	}

    protected function defineAttributes()
    {
        return array(
            'name' => AttributeType::String,
            'date' => AttributeType::String,
            'max_seats' => AttributeType::Number,
        );
    }
}