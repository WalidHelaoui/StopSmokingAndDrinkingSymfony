<?php

namespace CompteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use CompteBundle\Entity\UserCompte;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class LoginController extends Controller
{
    use \CompteBundle\Helper\ControllerHelper;


    public function loginAction(Request $request)
    {
        $userName = $request->get('username');
        $password = $request->get('password');

        $user = $this->getDoctrine()
            ->getRepository('CompteBundle:UserCompte')
            ->findOneBy(['username' => $userName]);
        if (!$user) {
            //throw new BadCredentialsException();
            return $this->setBaseHeaders($this->serialize(['state' => 'user not found']));
        }

        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $password);

        if (!$isValid) {
            //throw new BadCredentialsException();

            return $this->setBaseHeaders($this->serialize(['state' => "password incorrect!"]));
        }

        $token = $this->getToken($user);
        //$response = new Response($this->serialize(['token' => $token]), Response::HTTP_OK);
        //$response->headers->set('Content-Type', 'application/json');
        return $this->setBaseHeaders($this->serialize(['token' => $token]));
        //return new JsonResponse($response);
    }

    /**
     * Returns token for user.
     *
     * @param UserCompte $user
     *
     * @return array
     */
    public function getToken(UserCompte $user)
    {
        return $this->container->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $user->getUsername(),
                'exp' => $this->getTokenExpiryDateTime(),
            ]);
    }

    /**
     * Returns token expiration datetime.
     *
     * @return string Unixtmestamp
     */
    private function getTokenExpiryDateTime()
    {
        $tokenTtl = $this->container->getParameter('lexik_jwt_authentication.token_ttl');
        $now = new \DateTime();
        $now->add(new \DateInterval('PT'.$tokenTtl.'S'));

        return $now->format('U');
    }
}