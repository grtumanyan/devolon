<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Station;
use App\Service\Station as StationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompanyController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        $companies = $this->getDoctrine()
            ->getRepository(Company::class)
            ->findAll();

        return $this->render('company/index.html.twig', [
            'companies' => $companies
        ]);
    }

    /**
     * @Route(
     *     name="get_stations_by_company",
     *     path="api/companies/{id}/listStations",
     *     methods={"GET"},
     *     defaults={
     *       "_controller"="\App\Controller\CopmanyController::getList",
     *       "_api_resource_class"="App\Entity\Company",
     *       "_api_item_operation_name"="getList"
     *     }
     *   )
     * @param Company $data
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getList(Company $data) {

        $companies = $this->getDoctrine()
            ->getRepository(Company::class)
            ->findByParentId([$data->getId()], ['id'=>'DESC']);

        $result = [];
        foreach($companies as $company){
            $stations = $this->getDoctrine()
                ->getRepository(Station::class)
                ->findByCompanyId([$company->getId()], ['id'=>'DESC']);
            if($stations != null){
                $result[$company->getId()] = $stations;
            }
        }

        return $this->json([
            'result' => $result,
        ]);
    }
}