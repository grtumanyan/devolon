<?php

namespace App\Controller\Web;

use App\Entity\Station;
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
     * @param Request $request
     * @return Response
     */
    public function add(Request $request)
    {
        $name = $request->request->get('station-name', 'default');
        $latitude = $request->request->get('station-latitude', 'default');
        $longitude = $request->request->get('station-longitude', 'default');
        $companyId = $request->request->get('station-companyId', 1);
        $url = $this->generateUrl('api_stations_post_collection');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost".$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n  \"name\": \"".$name."\",\r\n  \"latitude\": \"".$latitude."\",\r\n  \"longitude\": \"".$longitude."\",\r\n  \"companyId\": ".$companyId.",\r\n  \"company\": \"/api/companies/".$companyId."\"\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        return $this->redirectToRoute('stations');
    }

    /**
     * @Route("/view/{id}", name="view")
     * @param Request $request
     * @return Response
     */
    public function view(Request $request)
    {
        $id = $request->attributes->get('id', 1);

        $url = $this->generateUrl('api_stations_get_item', ['id' => $id]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost".$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        $stations = $this->getDoctrine()
            ->getRepository(Station::class)
            ->findAll();

        return $this->render('station/index.html.twig', [
            'stations' => $stations,
            'result' => $response
        ]);
    }

    /**
     * @Route("/viewAll", name="viewAll")
     * @return Response
     */
    public function viewAll()
    {

        $url = $this->generateUrl('api_stations_get_collection');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost".$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        $stations = $this->getDoctrine()
            ->getRepository(Station::class)
            ->findAll();

        return $this->render('station/index.html.twig', [
            'stations' => $stations,
            'result' => $response
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request)
    {
        $id = $request->attributes->get('id', 1);

        $url = $this->generateUrl('api_stations_delete_item', ['id' => $id]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost".$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        return $this->redirectToRoute('stations');
    }

    /**
     * @Route("/update/{id}", name="update")
     * @param Request $request
     * @return Response
     */
    public function updateFirst(Request $request)
    {
        $id = $request->attributes->get('id', 1);

        $station = $this->getDoctrine()
            ->getRepository(Station::class)
            ->findOneById($id);

        return $this->render('station/update.html.twig', [
            'station' => $station
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     * @param Request $request
     * @return Response
     */
    public function updateSecond(Request $request)
    {
        $name = $request->request->get('station-name', 'default');
        $latitude = $request->request->get('station-latitude', 'default');
        $longitude = $request->request->get('station-longitude', 'default');
        $companyId = $request->request->get('station-companyId', 1);
        $id = $request->request->get('station-id', 1);

        $url = $this->generateUrl('api_stations_put_item', ['id' => $id]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost".$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\r\n  \"name\": \"".$name."\",\r\n  \"latitude\": \"".$latitude."\",\r\n  \"longitude\": \"".$longitude."\",\r\n  \"companyId\": ".$companyId.",\r\n  \"company\": \"/api/companies/".$companyId."\"\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);
        
        return $this->redirectToRoute('stations');
    }
}