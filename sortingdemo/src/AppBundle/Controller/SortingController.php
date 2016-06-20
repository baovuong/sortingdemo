<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Utils\Sorting;
use AppBundle\Utils\Step;

class SortingController extends Controller
{
    /**
     * @Route("/api/insertion")
     */
    public function apiInsertionSortAction()
    {
        $request = Request::createFromGlobals();
        $begin = microtime(true);

        $samples = $request->query->get('q');
        $keys = array_keys($samples);
        foreach ($keys as $key) {
            $samples[$key] = (int)$samples[$key];
        }
        $steps = Sorting::insertionSort($samples);

        $end = microtime(true);
        $data = array(
            'steps' => Step::listOfSteps($steps),
            'elapsed' => $end - $begin
        );

        return new JsonResponse($data);
    }
}
