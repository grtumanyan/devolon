<?php

namespace App\Service;

use App\Entity\Company as C;
use App\Entity\Station as S;

class Station
{

    public function __construct()
    {}

    /**
     * @param C $company
     */
    public function getAllStationsBasedOnCompany(C $company)
    {
        $result = $this->getDoctrine()
            ->getRepository(S::class)
            ->findByCompanyId([$company->getId()], ['id'=>'DESC']);
        var_dump($result);exit;
    }
}