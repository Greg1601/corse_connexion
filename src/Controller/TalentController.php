<?php

namespace App\Controller;

use App\Entity\Email;
use App\Entity\Talent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\MonologBundle\SwiftMailer;

class TalentController extends Controller
{

    /**
     * @Route("/talent/list", name="talent_list")
     */
    public function listTalentAction()
    {
        // Récupération de l'ensemble des objets Talent
        $talents = $this->getDoctrine()->getManager()->getRepository('App:Talent')->findAll();

        // Préparation des éléments Talent pour renvoi
        foreach ($talents as $talent) {

            // Récupération du nom du ou des objets de classe Skill relatif(s) à l'objet Talent dans un tableau pour affichage
            foreach ($talent->getSkills() as $skill){
                $skillName[] = $skill->getName();
            }

            $data[] = array(
                'firstname' => $talent->getFirstname(),
                'lastname' => $talent->getLastname(),
                'email' => $talent->getEmail(),
                'phone' => $talent->getPhone(),
                'skills' => $skillName,
                'picture' => $talent->getPicture(),
                'linkedin' => $talent->getLinkedinProfile(),
            );
        }

        // Renvoi
        return $this->json($data);

    }

    /**
     * @Route("/talent/email/add", name="add_talent_email")
     */
    public function addTalentEmailAction(Request $request)
    {

        // Récupération des données d'email et usertype
        $email = $request->request->get('email');
        $usertypeId = $request->request->get('usertypeId');
        $usertype = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Usertype')
            ->findOneById($usertypeId);

        // Création du nouvel objet Email
        $newMail = new Email();

        // Insertion des données
        $newMail->setAddress($email);
        $newMail->setUserType($usertype);

        // Sauvegarde et transfert des données en BDD
        $this->getDoctrine()->getManager()->persist($newMail);
        $this->getDoctrine()->getManager()->flush();

        // Réponse pour validation de la requête renvoyée en Json
        return $this->json([
            'email' => $email,
            'usertype' => $usertypeId,
        ]);
    }

    /**
     * @Route("/talent/signup", name="talent_signup")
     */
    public function talentSignupAction(Request $request, \Swift_Mailer $mailer,UserPasswordEncoderInterface $encoder)
    {

        // Création d'un nouvel objet Talent
        $user = new Talent;

        // Récupération et encodage du mot de passe
        $encodedPassword = $encoder->encodePassword($user, ($request->request->get('password')));

        // Insertion des données relatives au nouvel objet
        $user->setFirstname($request->request->get('firstname'));
        $user->setLastname($request->request->get('lastname'));
        $user->setEmail($request->request->get('email'));
        $user->setPhone($request->request->get('phone'));
        $user->setPicture($request->request->get('picture'));
        $user->setLinkedinProfile($request->request->get('linkedin'));
        $user->setPassword($encodedPassword);
        $user->setUsername($request->request->get('firstname').' '.$request->request->get('lastname'));
        // Récupération des éléments de classe Skill
        $skills[] = $request->request->get('skills');
        foreach ($skills as $skill) {
            $this->getDoctrine()
                ->getManager()
                ->getRepository('App:Skill')
                ->findOneById($skill);
        }

        // Sauvegarde et transfert des données en BDD
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        // Envoi d'un mail automatique avec swiftMailer
        $message = (new \Swift_Message('Registration Email'))
            ->setFrom('contact@corse-connaexion.corsica')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'Mails/registrationEmail.html.twig',
                    array('username' => $user->getUsername())
                ),
                'text/html'
            )
        ;

        $mailer->send($message);

        // Réponse pour validation de la requête renvoyée en Json
        return $this->json($request->request->get('firstname').' '.$request->request->get('lastname'),
            Response::HTTP_OK
        );

    }

    /**
     * @Route("/talent/{id}/show", name="talent_show")
     */
    public function showTalentAction($id)
    {
        // Récupération du talent via son ID
        $talent = $this->getDoctrine()->getManager()->getRepository('App:Talent')->findOneById($id);

        // Récupération du nom du ou des objets de classe Skill relatif(s) à l'objet Talent dans un tableau pour affichage
        foreach ($talent->getSkills() as $skill){
            $skillName[] = $skill->getName();
        }

        // Création du tableau des données à renvoyer
        $data[] = array(
            'firstname' => $talent->getFirstname(),
            'lastname' => $talent->getLastname(),
            'email' => $talent->getEmail(),
            'phone' => $talent->getPhone(),
            'skills' => $skillName,
            'picture' => $talent->getPicture(),
            'linkedin' => $talent->getLinkedinProfile(),
        );

        // Renvoi
        return $this->json($data);

    }

    /**
     * @Route("/talent/product/list", name="talent_product_list")
     */
    public function listTalentProductAction()
    {
        // Récupération de l'ensemble des objets Product dont le usertype est talent (id : 1)
        $products = $this->getDoctrine()->getManager()->getRepository('App:Product')->findBy(['user_type' => '1']);
//        dump($products);die;

        // Préparation des éléments Product pour renvoi
        foreach ($products as $product) {

            $data[] = array(
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'picture' => $product->getPicture(),
            );
        }

        // Renvoi
        return $this->json($data);
    }
}
