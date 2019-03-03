<?php

namespace App\Controller;

use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseController extends AbstractController
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return bool
     */
    protected function isFormValidAndSubmitted(FormInterface $form, Request $request): bool
    {
        $form->handleRequest($request);

        return $form->isSubmitted() && $form->isValid();
    }
}
