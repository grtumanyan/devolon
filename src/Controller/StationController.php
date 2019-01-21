<?php

namespace App\Controller;

use App\Entity\Station;
use App\Entity\Company;
use App\Service\Station as StationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StationController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        $stations = $this->getDoctrine()
            ->getRepository(Station::class)
            ->findAll();

        return $this->render('company/index.html.twig', [
            'stations' => $stations
        ]);
    }

//    /**
//     * @Route(
//     *     name="get_stations_by_company",
//     *     path="api/station/{id}/list",
//     *     methods={"GET"},
//     *     defaults={
//     *       "_controller"="\App\Controller\StationController::getList",
//     *       "_api_resource_class"="App\Entity\Station",
//     *       "_api_item_operation_name"="getList"
//     *     }
//     *   )
//     */
//    public function getList(Company $data, StationService $ss) {
//        $result = $ss->getAllStationsBasedOnCompany($data);
//        var_dump($result);exit;
////        return $this->json([
////            'id' => $data->getId(),
////            'comments_count' => $commentCount,
////        ]);
//    }
}