<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OpportunityController extends Controller
{
    /**
     * @Route("/opportunity", name="opportunity")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/OpportunityController.php',
        ]);
    }
}
