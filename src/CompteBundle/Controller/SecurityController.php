<?php

namespace CompteBundle\Controller;

use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $userName = $request->get('username');
        $password = $request->get('password');

        $user = $this->getDoctrine()
            ->getRepository('CompteBundle:UserCompte')
            ->findOneBy(['username' => $userName]);

        if (!$user) {
            //throw $this->createNotFoundException();
            return new View("username not exicte!",Response::HTTP_BAD_REQUEST);

        }

        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $password);

        if (!$isValid) {
            //throw new BadCredentialsException();
            return new View("login failed! check your password",Response::HTTP_BAD_REQUEST);
        }

        //$response = new Response(Response::HTTP_OK);

        //return $this->setBaseHeaders($response);
        //return $user;
        $this->get('fos_user.security.login_manager')->logInUser();

        return new View($user, Response::HTTP_OK);
    }


}
