<?php

namespace App\Controller;

use App\Entity\Opportunity;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OpportunityController extends Controller
{
    /**
     * @Route("/opportunity/list", name="opportunity_list")
     */
    public function listOpportunityAction()
    {

        // Récupération de l'ensemble des objets Opportunity
        $opportunities = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Opportunity')
            ->findAll();

        // Préparation des éléments Opportunity pour renvoi
        foreach ($opportunities as $opportunity) {

            // Récupération du nom du ou des objets de classe Skill relatif(s) à l'objet $opportunity dans un tableau pour affichage
            foreach ($opportunity->getSkillsRequired() as $skill){
                $skillName[] = $skill->getName();
            }
            $data[] = array(
                'companyName' => $this->getDoctrine()
                    ->getManager()
                    ->getRepository('App:Company')
                    ->findOneById($opportunity->getCompany())
                    ->getCompanyName(),
                'title' => $opportunity->getTitle(),
                'body' => $opportunity->getBody(),
                'salary' => $opportunity->getSalary(),
                'skills' => $skillName,
                'required expertise' => $opportunity->getRequiredExpertise(),
                'remote possibility' => $opportunity->getRemotePossibility(),
                'place' => $opportunity->getPlace(),
            );
        }

        // Renvoi
        return $this->json($data);

    }

    /**
     * @Route("/opportunity/add", name="opportunity_add")
     */
    public function opportunityAddAction(Request $request)
    {

        // Création d'un nouvel objet Opportunity
        $opportunity = new Opportunity();

        // Insertion des données relatives au nouvel objet
        $opportunity->setCompany($this->getDoctrine()
            ->getManager()
            ->getRepository('App:Company')
            ->findOneById($request->request->get('companyId')));
        $opportunity->setTitle($request->request->get('title'));
        $opportunity->setBody($request->request->get('body'));
        $opportunity->setSalary($request->request->get('salary'));
        $opportunity->setRequiredExpertise($request->request->get('requiredExpertise'));
        $opportunity->setPlace($request->request->get('place'));
        $opportunity->setRemotePossibility($request->request->get('remotePossibility'));

        // Sauvegarde et transfert des données en BDD
        $this->getDoctrine()->getManager()->persist($opportunity);
        $this->getDoctrine()->getManager()->flush();

        // Réponse pour validation de la requête renvoyée en Json
        return $this->json($request->request->get('title'),
            Response::HTTP_OK
        );

    }

    /**
     * @Route("/opportunity/{id}/show", name="opportunity_show")
     */
    public function showOpportunityAction($id)
    {
        // Récupération de l'offre d'emploi via son ID et vérification de son existence et de son validation
        if (
            $this->getDoctrine()
                ->getManager()
                ->getRepository('App:Opportunity')
                ->findOneById($id)
            &&
            $this->getDoctrine()
                ->getManager()
                ->getRepository('App:Opportunity')
                ->findOneById($id)
                ->getIsChecked() == 1
        )
        {

            // si elle existe on la stocke dans $opportunity
            $opportunity = $this->getDoctrine()
                ->getManager()
                ->getRepository('App:Opportunity')
                ->findOneById($id);
            // Récupération du nom du ou des objets de classe Skill relatif(s) à l'objet $opportunity dans un tableau pour affichage
            foreach ($opportunity->getSkillsRequired() as $skill){
                $skillName[] = $skill->getName();
            }

            // Création du tableau des données à renvoyer
            $data[] = array(
                'title' => $opportunity->getTitle(),
                'body' => $opportunity->getBody(),
                // Récupération de l'objet Company relatif à l'objet Opportunity affiché, renvoi du nom (possibilité de renvoi d'autres données)
                'company' => $this->getDoctrine()
                    ->getManager()
                    ->getRepository('App:Company')
                    ->findOneById($opportunity->getCompany())
                    ->getCompanyName(),
                'salary' => $opportunity->getSalary(),
                'expertise' => $opportunity->getRequiredExpertise(),
                'place' => $opportunity->getPlace(),
                'remote' => $opportunity->getremotePossibility(),
                'skills' => $skillName,
            );

            // Mise au format Json et renvoi du tableau $data
            return $this->json($data);
        }

        // si l'Opportunity pointée par $id n'éxiste pas ou n'est pas validée on renvoie un msg d'erreur
        else
            return $this->json('Wrong Opportunity');

    }
}
