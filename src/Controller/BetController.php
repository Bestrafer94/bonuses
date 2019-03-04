<?php

namespace App\Controller;

use App\Form\Data\BetData;
use App\Form\Type\BetType;
use App\Handler\Command\BetCommand;
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
        $winAmount = 0;
        $form = $this->createForm(BetType::class, new BetData());

        if ($this->isFormValidAndSubmitted($form, $request)) {
            $command = new BetCommand($form->getData(), $this->getUser());
            $winAmount = $this->commandBus->handle($command);
        }

        return $this->render('bet.html.twig', [
            'betForm' => $this->createForm(BetType::class, )->createView(),
            'winAmount' => $winAmount,
        ]);
    }
}
