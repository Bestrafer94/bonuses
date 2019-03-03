<?php

namespace App\Controller;

use App\Form\Data\DepositData;
use App\Handler\Command\DepositCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\DepositType;

class DepositController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/deposit", name="dashboard")
     *
     * @return Response
     */
    public function deposit(Request $request): Response
    {
        $form = $this->createForm(DepositType::class, new DepositData());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $command = new DepositCommand($form->getData(), $this->getUser());
            $response = $this->commandBus->handle($command);
        }

        return $this->render('dashboard.html.twig', [
            'depositForm' => $this->createForm(DepositType::class)->createView(),
        ]);
    }
}
