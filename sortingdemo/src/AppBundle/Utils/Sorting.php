<?php
namespace AppBundle\Utils;

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
        array_push($steps, new Step($input));
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
            array_push($steps, new Step($input));
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
