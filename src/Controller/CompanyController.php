<?php

namespace App\Controller;

use App\Entity\CompanyEmail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Company controller.
 *
 * @Route("company")
 */
class CompanyController extends Controller
{
    /**
     * @Route("/email/get", name="get_email")
     */
    public function getCompanyEmailAction()
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

    /**
     * @Route("/email/add", name="add_email")
     */
    public function addCompanyEmailAction(Request $request)
    {

        $email = $request->request->get('email');
        $usertypeId = $request->request->get('usertypeId');
        // Récupération de l'info 'id" du lieu qu'on veut afficher
        $usertype = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Usertype')
            ->findOneById($usertypeId);

        $newMail = new CompanyEmail();

        $newMail->setAddress($email);
        $newMail->setUserType($usertype);

        $this->getDoctrine()->getManager()->persist($newMail);
        $this->getDoctrine()->getManager()->flush();

        return $this->json([
            'email' => $email,
            'usertype' => $usertypeId,
        ]);
    }
}
