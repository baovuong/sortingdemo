<?php

class Step
{
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}

class Sorting
{
    public static function mergeSort(&$input)
    {
    }

    public static function selectionSort(&$input)
    {

    }

    public static function insertionSort(&$input)
    {
        $steps = array();
        $n = count($input);
        for ($i=1; $i<$n; $i++) {
            $key = $input[$i];
            $j = $i-1;

            while ($j>=0 && $input[$j] > $key) {
                $input[$j+1] = $input[$j];
                $j = $j-1;
                array_push($steps, new Step($input));
            }

            $input[$j+1] = $key;
        }
        return $steps;
    }

    public static function quickSort(&$input)
    {

    }

    private static function swap(&$a, &$b)
    {
        $temp = $a;
        $a = $b;
        $b = $temp;
    }
}
function print_array($a)
{
    foreach ($a as $number) {
        printf("$number ");
    }
    printf("\n");
}

$numbers = range(1,20);
shuffle($numbers);
$steps = Sorting::insertionSort($numbers);
var_export($steps);
?>
