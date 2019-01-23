<?php

namespace App\Controller\Api;

use App\Entity\Station;
use App\Entity\Company;
use App\Service\Station as StationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StationController extends Controller
{
    /**
     * @Route(
     *     name="get_stations_by_radius",
     *     path="api/station/list/latitude={latitude}&longitude={longitude}&kilometers={kilometers}",
     *     methods={"GET"},
     *     defaults={
     *       "_controller"="\App\Controller\StationController::getList",
     *       "_api_resource_class"="App\Entity\Station",
     *     }
     *   )
     * @param StationService $ss
     * @param $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getList(Request $request, StationService $ss) {
        $stations = $this->getDoctrine()
            ->getRepository(Station::class)
            ->findAll([], ['id'=>'DESC']);

        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $kilometers = $request->get('kilometers');
        $result = [];

        foreach($stations as $station){
            $distance = $ss->calculateDistance($latitude, $longitude, $station->getLatitude(), $station->getLongitude());
            $distance = intval($distance);

            if($distance < $kilometers){
                $tmp = ['station' => $station, 'distance' => $distance];
                $result[]= $tmp;
            }
        }

        $result = $ss->orderStations($result);
        return $this->json([
            'result' => $result,
        ]);
    }
}