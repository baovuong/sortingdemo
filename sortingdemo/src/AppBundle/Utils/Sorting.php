<?php
namespace AppBundle\Utils;

class Sorting
{
    private static function stepDiff($current, $previous)
    {
        $diff = array('changes' => array());
        $n = count($current['values']);
        for ($i=0; $i<$n; $i++) {
        //for ($i=0; $i<count($current['values']); $i++) {
            if ($current['values'][$i] != $previous['values'][$i]) {
                array_push($diff['changes'], array('index' => $i, 'value' => $current['values'][$i]));
            }
            if (isset($current['focused']) || array_key_exists('focused', $current)) {
                $diff['focused'] = $current['focused'];
            }
        }
        return $diff;
    }

    public static function cleanFrames(&$frames)
    {
        $n = count($frames['steps']);
        for ($i=0; $i<$n-1; $i++) {
            if (count($frames['steps'][$i]['changes']) == 0
                && !(isset($frames['steps'][$i]['focused']) || array_key_exists('focused', $frames['steps'][$i]))) {
                unset($frames['steps'][$i]);
                $n--;
            }
        }
        return $frames;
    }

    public static function selectionSort(&$input)
    {
        $frames = array(
            'initial' => $input,
            'steps' => array()
        );
        $previous = array('values' => $input);

        $n = count($input);
        for ($j=0; $j<$n-1; $j++) {
            $iMin = $j;
            for ($i = $j+1; $i<$n; $i++) {
                array_push($frames['steps'], Sorting::stepDiff(array('values' => $input, 'focused' => $i), $previous));
                if ($input[$i] < $input[$iMin]) {
                    $iMin = $i;
                }
            }
            if ($iMin != $j) {
                Sorting::swap($input[$iMin], $input[$j]);
                array_push($frames['steps'], Sorting::stepDiff(array('values' => $input), $previous));
                $previous['values'] = $input;
            }
        }
        array_push($frames['steps'], Sorting::stepDiff(array('values' => $input), $previous));
        return $frames;
    }

    public static function insertionSort(&$input)
    {
        $frames = array();
        $frames['initial'] = $input;
        $frames['steps'] = array();
        $previous = array('values' => $input);

        $n = count($input);
        for ($i=0; $i<$n; $i++) {
            $key = $input[$i];
            $j = $i -1;
            while ($j >= 0 && $input[$j] > $key) {
                array_push($frames['steps'], Sorting::stepDiff(array('values' => $input, 'focused' => $j), $previous));

                $input[$j+1] = $input[$j];
                $j = $j - 1;
                array_push($frames['steps'], Sorting::stepDIff(array('values' => $input), $previous));
                $previous['values'] = $input;
            }
            $input[$j+1] = $key;
            array_push($frames['steps'], Sorting::stepDiff(array('values' => $input), $previous));
            $previous['values'] = $input;
        }
        array_push($frames['steps'], Sorting::stepDiff(array('values' => $input), $previous));
        return $frames;
    }

    public static function mergeSort(&$arr, $l = 0, $r = -1, &$frames = null, &$previous = null)
    {
        if ($r == -1 && $frames == null) {
            $r = count($arr)-1;
        }

        if ($frames == null) {
            $frames = array(
                'initial' => $arr,
                'steps' => array()
            );
            $previous = array('values' => $arr);
        }

        if ($l < $r) {
            $m = floor($l + ($r-$l)/2);
            Sorting::mergeSort($arr, $l, $m, $frames, $previous);
            Sorting::mergeSort($arr, $m+1, $r, $frames, $previous);
            Sorting::merge($arr, $l, $m, $r, $frames, $previous);
        }

        return $frames;
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

    private static function merge(&$arr, $l, $m, $r, &$frames, &$previous)
    {
        $n1 = $m - $l + 1;
        $n2 = $r - $m;

        $L = array();
        $R = array();

        for ($i=0; $i<$n1; $i++)
            array_push($L, $arr[$l+$i]);
        for ($i=0; $i<$n2; $i++)
            array_push($R, $arr[$m+1+$i]);

        $i=0;
        $j=0;
        $k=$l;

        while ($i<$n1 && $j<$n2) {
            array_push($frames['steps'], Sorting::stepDiff(array('values' => $arr, 'focused' => $i), $previous));
            if ($L[$i] <= $R[$j]) {
                $arr[$k] = $L[$i];
                $i++;
            } else {
                $arr[$k] = $R[$j];
                $j++;
            }
            $k++;
            array_push($frames['steps'], Sorting::stepDiff(array('values' => $arr), $previous));
            $previous['values'] = $arr;
        }

        while ($i < $n1) {
            $arr[$k] = $L[$i];
            array_push($frames['steps'], Sorting::stepDiff(array('values' => $arr), $previous));
            $previous['values'] = $arr;
            $i++;
            $k++;
        }

        while ($j < $n2) {
            $arr[$k] = $R[$j];
            array_push($frames['steps'], Sorting::stepDiff(array('values' => $arr), $previous));
            $previous['values'] = $arr;
            $j++;
            $k++;
        }

        //return $frames;
    }

    private static function partition()
    {

    }
}
