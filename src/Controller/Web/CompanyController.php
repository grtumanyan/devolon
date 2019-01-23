<?php

namespace App\Controller\Web;

use App\Entity\Company;
use App\Entity\Station;
use App\Service\Station as StationService;
use App\Service\Company as CompanyService;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/add", name="add")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request)
    {
        $name = $request->request->get('company-name', 'default');
        $id = $request->request->get('company-parentId', 1);

        $url = $this->generateUrl('api_companies_post_collection');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost".$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"name\": \"".$name."\", \"ParentCompanyId\": ".$id."}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        return $this->redirectToRoute('companies');
    }

    /**
     * @Route("/view/{id}", name="view")
     * @param Request $request
     * @return Response
     */
    public function view(Request $request)
    {
        $id = $request->attributes->get('id', 1);

        $url = $this->generateUrl('api_companies_get_item', ['id' => $id]);

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

        $companies = $this->getDoctrine()
            ->getRepository(Company::class)
            ->findAll();

        return $this->render('company/index.html.twig', [
            'companies' => $companies,
            'result' => $response
        ]);
    }

    /**
     * @Route("/viewAll", name="viewAll")
     * @return Response
     */
    public function viewAll()
    {

        $url = $this->generateUrl('api_companies_get_collection');

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

        $companies = $this->getDoctrine()
            ->getRepository(Company::class)
            ->findAll();

        return $this->render('company/index.html.twig', [
            'companies' => $companies,
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

        $url = $this->generateUrl('api_companies_delete_item', ['id' => $id]);

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

        return $this->redirectToRoute('companies');
    }

    /**
     * @Route("/update/{id}", name="update")
     * @param Request $request
     * @return Response
     */
    public function updateFirst(Request $request)
    {
        $id = $request->attributes->get('id', 1);

        $company = $this->getDoctrine()
            ->getRepository(Company::class)
            ->findOneById($id);

        return $this->render('company/update.html.twig', [
            'company' => $company
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     * @param Request $request
     * @return Response
     */
    public function updateSecond(Request $request)
    {
        $name = $request->request->get('company-name', 'default');
        $parentId = $request->request->get('company-parentId', 1);
        $id = $request->request->get('company-id', 1);

        $url = $this->generateUrl('api_companies_put_item', ['id' => $id]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost".$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\"name\": \"".$name."\", \"ParentCompanyId\": ".$parentId."}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);
        
        return $this->redirectToRoute('companies');
    }
}