<?php
namespace AppBundle\Utils;

class Step
{
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public static function listOfSteps($steps)
    {
        $result = array();
        foreach ($steps as $step) {
            array_push($result, $step->value);
        }
        return $result;
    }
}
