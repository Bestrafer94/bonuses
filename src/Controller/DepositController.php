<?php

namespace App\Controller;

use App\Form\Data\DepositData;
use App\Handler\Command\DepositCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\DepositType;

class DepositController extends BaseController
{
    /**
     * @Route("/deposit", name="deposit")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function deposit(Request $request): Response
    {
        $form = $this->createForm(DepositType::class, new DepositData());

        if ($this->isFormValidAndSubmitted($form, $request)) {
            $command = new DepositCommand($form->getData(), $this->getUser());
            $this->commandBus->handle($command);
        }

        return $this->render('deposit.html.twig', [
            'depositForm' => $this->createForm(DepositType::class)->createView(),
        ]);
    }
}
