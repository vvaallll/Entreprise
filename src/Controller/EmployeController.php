<?php

namespace App\Controller;

use DateTime;
use App\Entity\Employe;
use App\Form\EmployeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





class EmployeController extends AbstractController
{

    // 1 - Action
    
    // Lorsque vous créer une fonction dans un controller, cela devient une "action".
    // Une "action" commence toujours par un verbe (sauf home) action et variable sont en camelCase

    // 2 - Injection de dependance

    // Dans les paranthese d'une fonction ("action") vous aller, peut etre, avoir besoin d'outil (objet).
    // pouir vous en servir, dans symfony, on injectera des dependances. Cela revient à les definir comme "parametres"
    
    // 3 - Route

    //depuis php 8 les routes peuvent secrire sous forme d'Attribut
    // Une route prendra toujours 3 arguments
    // *a - une URI, un bout d'URL
    // *b - un 'name', qui permet de nommer la route pour plus tard
    // *c -  une méthode HTTP, qui auttorise les requete HTTP. question de securité
    // !! TOUTES VOS ROUTES DOIVENT ETRE COLLÉES A VOTRE FONCTION !! (alt maintenu + 0201 pour le É)

/*
    ------ 1 _ Action

    Lorsque vous créez une fonction dans un Controller, cela devient une "action".
    Une "action" commence toujours par un verbe (sauf 'home'). La convention de nommage est le camelCase !

    ------ 2 _ Injection de dépendances

    Dans les parenthèses d'une fonction ("action") vous allez, peut-être, avoir besoin d'outils (objet).
    Pour vous en servir, dans Symfony, on injectera des dépendances. Cela revient à les définir comme 'paramètres'.

    ------ 3 _ Route

    La route, depuis PHP 8, peut s'écrire sous forme d'Attribut, cela permet de dissocier des Annotations !
    Cela se traduit par une syntaxe différente. Une Route prendra TOUJOURS 3 arguments :
        * a - une URI, qui est un bout d'URL.
        * b - un 'name', qui permet de nommer la route pour s'en servir plus tard.
        * c - une méthode HTTP, qui autorise telle ou telle requête HTTP. Question de sécurité !

    !!! TOUTES VOS ROUTES DOIVENT ÊTRE COLLÉES À VOTRE FONCTION !!!
     */



    #[Route('/ajouter-un-employe', name: 'create_employe', methods: ['GET','POST'])]
    public function createEmploye(Request $request, EntityManagerInterface $entityManager): Response
    {

// ----------------------------------- 1ere Méthode : GET --------------------------------- //


        # Instanciation d'un objet de type Employe

        $employe = new Employe();

# Nous créons une variable $form qui contiendra le formulaire créé par la méthode createForm()
// le mecaniqme d'auto-hydratation ce fait concretement par l'ajout d'un second element argument
// dans la methode createForm(). On passera $employe en argument.

        $form = $this->createForm(EmployeFormType::class, $employe);

// pour que le mecanisme de base symfony soit respecté, on devra manipuler la requete avec la methode handleRequest() et l'objet $request

        $form->handleRequest($request);

        // ----------------------------------- 2eme Méthode : POST --------------------------------- //
if($form->isSubmitted() && $form->isValid()) {

    // CreatedAt ne peut etre null il faut donc le rensseigner
    $employe->setCreatedAt(new DateTime());

    // nous inserons en bdd grace a notre $entityManager et la method persist()
    $entityManager->persist($employe);

    // nous devrons vider(trad de flush) l'entityManager pour réelement ajouter une ligne en bdd
    $entityManager->flush();

 // pour finir rediriger l'utilisateur sur une page html grace a une route
 # Nous utilisons la méthode redirectToRoute() pour faire la redirection.
    return $this->redirectToRoute('default_home');
}

        // ----------------------------------- 1ere Méthode : GET --------------------------------- //


# On peut directement return pour rendre la vue (page html) du formulaire


        return $this->render('form/employe.html.twig', [
            'form_employe' => $form->createView()
        ]);
    }
}
