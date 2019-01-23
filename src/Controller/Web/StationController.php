<?php

namespace App\Controller\Web;

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
     * @Route("/index", name="index")
     */
    public function index()
    {
        $stations = $this->getDoctrine()
            ->getRepository(Station::class)
            ->findAll();

        return $this->render('station/index.html.twig', [
            'stations' => $stations
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add()
    {
        $stations = $this->getDoctrine()
            ->getRepository(Station::class)
            ->findAll();

        return $this->render('station/index.html.twig', [
            'stations' => $stations
        ]);
    }
}