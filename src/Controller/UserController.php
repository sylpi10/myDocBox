<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;


class UserController extends AbstractController
{
  
    
    public function __construct(EntityManagerInterface $entityManager){
      
        $this->manager =$entityManager;

    }
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user', name: 'user_session')]
    public function userSession(): Response
    {
        return $this->render('user/show.html.twig', 
            array('user' => $this->getUser())
        );
        
    }
}
