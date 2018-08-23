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
    public function companySignupAction(Request $request, UserPasswordEncoderInterface $encoder)
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

        $user->setPassword($encodedPassword);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
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
