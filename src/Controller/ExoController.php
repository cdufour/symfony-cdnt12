<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CalculatorService;

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

        return new Response(CalculatorService::PI);
    }
}
