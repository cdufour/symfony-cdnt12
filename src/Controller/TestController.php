<?php

namespace App\Controller;

use App\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test1", name="test1", methods={"GET", "POST"})
     */
    public function test1()
    {
        $html = '<html><head></head><body><h1>coucou</h1></body>';
        //return new Response($html);
        $res = new Response();
        $res->setContent($html);
        $res->headers->set('X-Token', md5("coucou"));
        $res->setStatusCode(Response::HTTP_ACCEPTED);

        return $res;
    }

    public function test2()
    {
        $student = [
            'name' => 'Jerem', 
            'age' => 18, 
            'isMute' => true
        ];

        //return new Response(json_encode($student));
        //return new \Symfony\Component\HttpFoundation\JsonResponse($student);
        return $this->json($student);
    }

    /**
     * @Route("/test3", name="test3")
     */
    public function test3(Request $req)
    {
        //dd($req);
        $searchedValue = $req->query->get('search');
        $method = $req->getMethod();
        //dd($searchedValue, $method);
        $students = ['Jerem', 'Umberto', 'Noémie', 'Clémentine'];

        return $this->render('test/test3.html.twig', [
            'title' => 'Test 3',
            'searchedValue' => $searchedValue,
            'method' => $method,
            'students' => $students,
        ]);
    }

    /**
     * @Route(
     * "/test4/student/{id}/delete", 
     * name="test4",
     * requirements={"id"="\d+"}
     * )
     * 
     */
    public function test4($id)
    {
        return new Response($id);
    }

    /**
     * @Route("/test5/{countryName}", name="test5")
     */
    public function test5($countryName)
    {
        $em = $this->getDoctrine()->getManager();

        $country = new Country();
        $country->setName($countryName);

        $em->persist($country); // pendind request
        $em->flush(); // exec request
       
        return new Response(
            sprintf('Country id %d', $country->getId())
        );
    }

    /**
     * @Route("/test6/{order}", name="test6")
     * Affichage de la liste des pays
     */
    public function test6($order = 'ASC')
    {
        $repo = $this->getDoctrine()->getRepository(Country::class);
        //$countries = $repo->findAll();
        $countries = $repo->findBy([], ['name' => $order]);

        return $this->render('test/test6.html.twig', [
            'countries' => $countries
        ]);
    }

    /**
     * @Route("/test7/{id}", name="country_detail")
     * Affichage d'un pays
     */
    public function test7($id)
    {
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $country = $repo->find(intval($id));

        return $this->render('test/test7.html.twig', [
            'country' => $country
        ]);
    }
}

