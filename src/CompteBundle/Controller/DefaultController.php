<?php

namespace CompteBundle\Controller;

use CompteBundle\Entity\UserCompte;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class DefaultController extends Controller
{
    use \CompteBundle\Helper\ControllerHelper;


    public function welcomeAction(Request $request)
    {
        $user = $this->getUser();
        $response = new Response($this->serialize('Hello user.'), Response::HTTP_OK);
        return $response;
    }

    public function getUserAction()
    {
        $user = $this->getUser();
        return $user;
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('CompteBundle:UserCompte')->findAll();
        return array('users'=>$users);
    }

    public function testAction(Request $request){

       // $token = $request->get('token');
        $user = $this->getUser();
        //$currentUser = $this->get('security.token_storage')->getToken()->getUser();
        return $user;
    }

    public function registerAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $entityManager = $this->get('doctrine')->getManager();
        $data = $request->request->all();

        // Do a check for existing user with userManager->findByUsername

        $user = $userManager->createUser();
        $user->setUsername($data['username']);
        // ...
        $user->setPlainPassword($data['password']);
        $user->setEnabled(true);

        $userManager->updateUser($user);

        return $this->generateToken($user, 201);
    }

    protected function generateToken($user, $statusCode = 200)
    {
        // Generate the token
        $token = $this->get('lexik_jwt_authentication.jwt_manager')->create($user);

    $response = array(
        'token' => $token,
        'user'  => $user // Assuming $user is serialized, else you can call getters manually
    );

    return new JsonResponse($response, $statusCode); // Return a 201 Created with the JWT.
    }
}
