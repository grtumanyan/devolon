<?php

namespace App\Service;

use App\Repository\StationRepository;

class Company
{
    protected $stationRepository;

    public function __construct(StationRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    /**
     * @param $companies
     * @param int $parentId
     * @return array
     */
    public function buildTree($companies, $parentId = 0)
    {
        $branch = array();

        foreach ($companies as $company) {
            if ($company['parentCompanyId'] == $parentId) {
                $children = $this->buildTree($companies, $company['companyId']);
                if ($children) {
                    $company['children'] = $children;
                    $stations = $this->stationRepository
                        ->findByCompanyId([$company['companyId']], ['id'=>'DESC']);
                    if($stations){
                        $company['stations'] = $stations;
                    }
                }
                unset($company['parentCompanyId']);
                $branch[] = $company;
            }
        }

        return $branch;
    }
}