<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $length = count($samples);
        for ($i=0; $i < $length; $i++) {
            $samples[$i] = (int)$samples[$i];
        }


        //$samples = array_map('SortingController::toInt', $samples);

        $end = microtime(true);
        $data = array(
            'samples' => $samples,
            'elapsed' => $end - $begin
        );

        return new JsonResponse($data);
    }

    private static function toInt(&$stringValue)
    {
        $stringValie = (int)$stringValue;
    }
}
