<?php

namespace App\Controller;

use App\Entity\City;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CalculatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ExoController extends AbstractController
{
    /**
     * @Route("/exos/exo1/{num}", name="exo1")
     */
    public function exo1($num): Response
    {
        $calculator = new CalculatorService();

        $numInt = intval($num);
    
        if ($numInt === 0) {
            return new Response('Valeur entière requise supérieure à 0');
        }

        $square = $calculator->square($num);

        return new Response($square);
    }

    /**
     * @Route("/exos/city/form", name="city_form")
     */
    public function form(
        Request $req, 
        EntityManagerInterface $em,
        CountryRepository $countryRepo
        ): Response
    {
        if ($req->getMethod() === Request::METHOD_POST) {

            $name = $req->request->get('name');
            $mayor = $req->request->get('mayor');
            $countryId = $req->request->get('country');
            $country = $countryRepo->find($countryId);

            $city = new City();
            $city
                ->setName($name)
                ->setMayor($mayor)
                ->setCountry($country);
            
            $em->persist($city);
            $em->flush($city);

            return $this->redirectToRoute('city_list');
        }

        $countries = $countryRepo->findBy([], ['name' => 'ASC']);

        return $this->render('city/form.html.twig', [
            'countries' => $countries
        ]);
    }

    /**
     * @Route("/exos/city/list", name="city_list")
     */
    public function list(CityRepository $cityRepo)
    {
        return $this->render('city/list.html.twig', [
            'cities' => $cityRepo->findAll()
        ]);
    }
}
