<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route("/api/login", name="login")
     */
    public function login()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        return $this->json($user);
    }

    /**
     * @Route("{id}/account/activation/{key}", name="activate_account")
     */
    public function accountActivationAction(Request $request, $id, $key)
    {
        $username = $request->request->get('username');
//        $id = $request->request->get('id');
//        $key = $request->request->get('key');

        if ($this->getDoctrine()
            ->getManager()
            ->getRepository('App:Talent')
            ->findOneById($id)
            &&
            $this->getDoctrine()
                ->getManager()
                ->getRepository('App:Talent')
                ->findOneById($id)->getRandomKey() == $key
        )
        {
            $user = $this->getDoctrine()
                ->getManager()
                ->getRepository('App:Talent')
                ->findOneById($id);
            $user->setIsValid(1);

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
        }

        elseif ($this->getDoctrine()
            ->getManager()
            ->getRepository('App:Company')
            ->findOneById($id)
            &&
            $this->getDoctrine()
                ->getManager()
                ->getRepository('App:Company')
                ->findOneById($id)->getRandomKey() == $key
        )
        {
            $user = $this->getDoctrine()
                ->getManager()
                ->getRepository('App:Company')
                ->findOneById($id);
            $user->setIsValid(1);

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->json('Activation OK');
    }

}
