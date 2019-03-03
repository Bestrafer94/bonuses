<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends BaseController
{
    /**
     * @Route("/user-profile", name="user_profile")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function userProfile(Request $request): Response
    {
        return $this->render('user_profile.html.twig');
    }
}
