<?php

namespace App\Controller;

use App\Entity\Tuto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TutoRepository;

final class TutoController extends AbstractController
{
    #[Route('/tuto/{id}', name: 'app_tuto')]
    public function index(TutoRepository $tutorepository, int $id): Response
    {
        
        $tutos = $tutorepository->findOneById($id);
        // $tutos = $tutorepository->findAll();
      
        
       if(!$tutos) {
         throw $this->createNotFoundException(
            'No product found for id '.$id
         );
       }
        return $this->render('tuto/index.html.twig', [
            'controller_name' => 'TutoController',
            'tuto' => $tutos
        ]);
    }


    #[Route('/add-tuto', name: 'create_tuto')]
    public function createTuto(EntityManagerInterface $entityManager): Response
    {
        $tuto = new Tuto();
        $tuto->setName('Unity');
        $tuto->setSlug('tuto-unity');
        $tuto->setSubtitle('Lorem ipsum dolor sit amet.');
        $tuto->setDescription('Lorem ipsum dolor sit amet.');
        $tuto->setImage('unity.png');
        $tuto->setVideo('DrMyhQY2udg');
        $tuto->setLink('https://www.formation-facile.fr/formations/modelisation-denvironnements-3d-de-jeux-video-avec-blender');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($tuto);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new tuto with id '.$tuto->getId());
    }
}
