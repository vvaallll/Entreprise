<?php

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_home')]
    public function home(EntityManagerInterface $entityManager): Response
    {
// Cette instruction nous permet de recupérer en BDD toute les lignes de la table "employe".
// possible grace au Repository, accessible par $entityManager.
        $employes = $entityManager->getRepository(Employe::class)->findALL();

        //Nous devons maintenant passer la variable $employes (qui contient tout les employés de la BDD)
        // à notre vu twig pour pouvoir affciher les données
        return $this->render('default/home.html.twig', [
            'employes' => $employes
        ]);
    }
}
