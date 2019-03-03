<?php

namespace App\Controller;

use App\Form\Type\DepositType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('dashboard.html.twig', [
            'depositForm' => $this->createForm(DepositType::class)->createView(),
        ]);
    }
}
