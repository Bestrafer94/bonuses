<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BalanceController extends BaseController
{
    /**
     * @Route("/balance", name="balance")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function balance(Request $request): Response
    {
        return $this->render('balance.html.twig');
    }
}
