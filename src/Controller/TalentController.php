<?php

namespace App\Controller;

use App\Entity\Email;
use App\Entity\Talent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;

class TalentController extends Controller
{

    /**
     * @Route("/talent/email/add", name="add_talent_email")
     */
    public function addTalentEmailAction(Request $request)
    {

        $email = $request->request->get('email');
        $usertypeId = $request->request->get('usertypeId');
        // Récupération de l'info 'id" du lieu qu'on veut afficher
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
     * @Route("/talent/signup", name="talent_signup")
     */
    public function talentSignupAction(Request $request, UserPasswordEncoderInterface $encoder)
    {


        $user = new Talent;
//        $data = $request->getContent();
//        $decoded = json_decode($request, true);
//        dump($request);die;
        $encodedPassword = $encoder->encodePassword($user, ($request->request->get('email')));
        $email = $request->request->get('email');
        $user->setFirstname($request->request->get('firstname'));
        $user->setLastname($request->request->get('lastname'));
        $user->setEmail($request->request->get('email'));
        $user->setPhone($request->request->get('phone'));
        $user->setPicture($request->request->get('picture'));
        $user->setLinkedinProfile($request->request->get('linkedin'));
        $skills[] = $request->request->get('skills');
        foreach ($skills as $skill) {
            $this->getDoctrine()
                ->getManager()
                ->getRepository('App:Skill')
                ->findOneById($skill);
        }

        $user->setPassword($encodedPassword);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($email,
            Response::HTTP_OK
        );

    }

    /**
     * @Route("/talent/list", name="talent_list")
     */
    public function listTalentAction()
    {
        $talents = $this->getDoctrine()->getManager()->getRepository('App:Talent')->findAll();

        foreach ($talents as $talent) {
            $data[] = array(
                'firstname' => $talent->getFirstname(),
                'lastname' => $talent->getLastname(),
                'email' => $talent->getEmail(),
                'phone' => $talent->getPhone(),
                'picture' => $talent->getPicture(),
                'linkedin' => $talent->getLinkedinProfile(),
            );
        }

        return $this->json($data);

    }
    /**
     * @Route("/talent/{id}/show", name="talent_list")
     */
    public function showTalentAction($id)
    {
        $talent = $this->getDoctrine()->getManager()->getRepository('App:Talent')->findOneById($id);

        $data[] = array(
            'firstname' => $talent->getFirstname(),
            'lastname' => $talent->getLastname(),
            'email' => $talent->getEmail(),
            'phone' => $talent->getPhone(),
            'picture' => $talent->getPicture(),
            'linkedin' => $talent->getLinkedinProfile(),
        );

        return $this->json($data);

    }

}
