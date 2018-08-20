<?php

namespace App\Controller;

use App\Entity\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->json([
            'HOMEPAGE'
        ]);
    }

    /**
     * @Route("/email/add", name="add_email")
     */
    public function addEmailAction(Request $request)
    {

        $email = $request->request->get('email');
        $usertypeId = $request->request->get('usertypeId');

        $usertype = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Usertype')
            ->findOneById($usertypeId);

        $newMail = new Email();

        $newMail->setAddress($email);
        $newMail->setUserType($usertype);

        $this->getDoctrine()->getManager()->persist($newMail);
        $this->getDoctrine()->getManager()->flush();

        return $this->json([
            'email' => $email,
            'usertype' => $usertypeId,
        ]);
    }

    /**
     * @Route("/email/usertypes", name="get_usertypes")
     */
    public function getUsertypesAction()
    {

        // Récupération des des items Usertype pour affichage
        // Puis boucle sur la totlaité de la liste et renvoi
        $usertypes = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Usertype')->findAll();
        foreach ($usertypes as $usertype) {
            $data[] = array(
                'name' => $usertype->getType(),
                'id' => $usertype->getId(),
            );
        }

        return $this->json([
            'usertypes' => $data,
        ]);
    }
}
