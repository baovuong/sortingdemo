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
        return $this->sortWithAlgorithm($request, array('AppBundle\Utils\Sorting', 'insertionSort'));
    }

    /**
     * @Route("/api/selection")
     */
    public function apiSelectionSortAction()
    {
        return $this->sortWithAlgorithm(Request::createFromGlobals(), array('AppBundle\Utils\Sorting', 'selectionSort'));
    }

    /**
     * @Route("/api/merge")
     */
    public function apiMergeSortAction()
    {
        return $this->sortWithAlgorithm(Request::createFromGlobals(), array('AppBundle\Utils\Sorting', 'mergeSort'));
    }

    private function sortWithAlgorithm($request, $sortingAlgorithm)
    {
        $begin = microtime(true);
        $samples = $request->query->get('q');
        $keys = array_keys($samples);
        foreach ($keys as $key) {
            $samples[$key] = (int)$samples[$key];
        }
        $frames = call_user_func_array($sortingAlgorithm, array(&$samples));
        $frames['steps'] = Sorting::cleanFrames($frames);
        $end = microtime(true);

        return new JsonResponse(array(
           'frames' => $frames,
            'elapsed' => $end - $begin
        ));

    }
}
