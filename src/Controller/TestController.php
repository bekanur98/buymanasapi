<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/", name="test_index")
     */
    public function index()
    {
        return new JsonResponse([
            'action'=>'index',
            'time' => time()
        ]);
    }
}
