<?php

declare(strict_types=1);

namespace App\Controller;

use App\Handler\Command\BalanceCommand;
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
        $command = new BalanceCommand($this->getUser());

        return $this->render('balance.html.twig',
            [
                'balance' => $this->commandBus->handle($command),
            ]
        );
    }
}
