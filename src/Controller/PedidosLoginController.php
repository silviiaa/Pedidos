<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PedidosLoginController extends AbstractController
{
    /**
     * @Route("/pedidos/login", name="pedidos_login")
     */
    public function index(): Response
    {
        return $this->render('pedidos_login/index.html.twig', [
            'controller_name' => 'PedidosLoginController',
        ]);
    }
    /**
    * @Route("/login", name="login")
    */
    public function login(){
        return $this->render('login.html.twig');
    }
}

