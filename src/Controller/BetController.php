<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BetController extends BaseController
{
    /**
     * @Route("/bet", name="bet")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function bet(Request $request): Response
    {
        return $this->render('bet.html.twig');
    }
}
