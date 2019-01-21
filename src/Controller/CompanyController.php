<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Station;
use App\Service\Station as StationService;
use App\Service\Company as CompanyService;
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
     * @param CompanyService $cs
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getList(Company $data, CompanyService $cs) {

        $companies = $this->getDoctrine()
            ->getRepository(Company::class)
            ->findAll([], ['id'=>'DESC']);

        $new = [];
        foreach ($companies as $item){
            array_push($new, ['companyId'=>$item->getId(), 'parentCompanyId'=>$item->getParentCompanyId()]);
        }

        $children = $cs->buildTree($new, $data->getId());
        $result['companyId'] = $data->getId();
        $result['children'] = $children;
        $result['stations'] = $this->getDoctrine()
            ->getRepository(Station::class)
            ->findByCompanyId([$data->getId()], ['id'=>'DESC']);

        return $this->json([
            'result' => $result,
        ]);
    }
}