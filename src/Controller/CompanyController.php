<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CompanyController extends Controller
{


    /**
     * @Route("/company/signup", name="company_signup")
     */
    public function companySignupAction(Request $request, \Swift_Mailer $mailer, UserPasswordEncoderInterface $encoder)
    {

        $user = new Company;
//        $data = $request->getContent();
//        $decoded = json_decode($request, true);
//        dump($request);die;
        $encodedPassword = $encoder->encodePassword($user, ($request->request->get('password')));
//        $email = $request->request->get('email');
        $user->setCompanyName($request->request->get('companyName'));
        $user->setEmail($request->request->get('email'));
        $user->setContactName($request->request->get('contactName'));
        $user->setContactPhone($request->request->get('contactPhone'));
        $user->setPicture($request->request->get('picture'));
        $user->setProject($request->request->get('project'));
        $user->setUsername($request->request->get('contactName'));
        // Génération aléatoire d'une clé pour l'activation du compte
        $user->setRandomKey($cle = md5(microtime(TRUE)*100000));
        $user->setPassword($encodedPassword);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        // Envoi d'un mail automatique avec swiftMailer
        $message = (new \Swift_Message('Activation de votre compte'))
            ->setFrom('contact@corse-connexion.corsica')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'Mails/registrationEmail.html.twig',
                    array('username' => $user->getUsername(),
                        'id' => $user->getId(),
                        'key' => $user->getRandomKey()
                    )
                ),
                'text/html'
            )
        ;

        $mailer->send($message);

        return $this->json($request->request->get('companyName'),
            Response::HTTP_OK
        );

    }

    /**
     * @Route("/company/list", name="company_list")
     */
    public function listCompanyAction()
    {
        $companies = $this->getDoctrine()->getManager()->getRepository('App:Company')->findAll();

        foreach ($companies as $company) {
            $data[] = array(
                'companyName' => $company->getCompanyName(),
                'contactName' => $company->getContactName(),
                'email' => $company->getEmail(),
                'contactPhone' => $company->getContactPhone(),
                'picture' => $company->getPicture(),
                'project' => $company->getProject(),
            );
        }

        return $this->json($data);

    }

    /**
     * @Route("/company/checkmail", name="company_check_email")
     */
    public function companyCheckMailAction(Request $request, UserPasswordEncoderInterface $encoder)
    {

        // Récupération de l'email de l'utilisateur et Test de l'existence du mail en BDD
        // + récupération de l'entité Company correspondante
        $user = $this->getDoctrine()->getManager()->getRepository('App:Company')->findOneByEmail($request->request->get('email'));

        // Si une correspondance à été trouvée dans la base de donnée
        // On récupère l'email et on envoie une réponse avec le mail
        if ($user){
            $checkedMail = $user->getEmail();
            return $this->json('Email '.$checkedMail.' OK');
        }
        // Si aucun utilisateur n'a été trouvé
        // On renvoie un message d'erreur
        else{
            return $this->json('Erreur: Email inconnu');
        }

    }

    /**
     * @Route("/company/resetpassword", name="company_resetPassword")
     */
    public function companyResetPasswordAction(Request $request, UserPasswordEncoderInterface $encoder)
    {

        // Récupération de l'email de l'utilisateur et Test de l'existence du mail en BDD
        // + récupération de l'entité Company correspondante
        $user = $this->getDoctrine()->getManager()->getRepository('App:Company')->findOneByEmail($request->request->get('email'));


        $encodedPassword = $encoder->encodePassword($user, ($request->request->get('password')));

        $user->setPassword($encodedPassword);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->json('Mot de passe réinitialisé');

    }

    /**
     * @Route("/company/{id}/show", name="company_show")
     */
    public function showCompanyAction($id)
    {
        $company = $this->getDoctrine()->getManager()->getRepository('App:Company')->findOneById($id);

        $data[] = array(
            'companyName' => $company->getCompanyName(),
            'contactName' => $company->getContactName(),
            'email' => $company->getEmail(),
            'contactPhone' => $company->getContactPhone(),
            'picture' => $company->getPicture(),
            'project' => $company->getProject(),
        );

        return $this->json($data);

    }

    /**
     * @Route("/company/product/list", name="company_product_list")
     */
    public function listCompanyProductAction()
    {
        // Récupération de l'ensemble des objets Product dont le usertype est company (id : 2)
        $products = $this->getDoctrine()->getManager()->getRepository('App:Product')->findBy(['user_type' => '2']);
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
