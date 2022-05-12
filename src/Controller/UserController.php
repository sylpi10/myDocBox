<?php

namespace App\Controller;

use App\Entity\ResearchFolder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Form\AllFolderType;
use App\Form\ByNameType;
use App\Form\ByTagType;
use App\Form\DateFolderType;
use App\Form\RegistrationFormType;
use App\Repository\FolderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;


class UserController extends AbstractController
{
    private $manager;
    private FolderRepository $folderRepository;

    public function __construct(EntityManagerInterface $entityManager, FolderRepository $folderRepository)
    {

        $this->manager = $entityManager;
        $this->folderRepository = $folderRepository;

    }
    #[Route('/user', name: 'app_user')]
    public function index(Request $request): Response
    {
        $filters = true;
        $searchFolder = new ResearchFolder();

        $tagForm = $this->createForm(ByTagType::class, $searchFolder);
        $tagForm->handleRequest($request);

        $nameForm = $this->createForm(ByNameType::class, $searchFolder);
        $nameForm->handleRequest($request);

        $dateForm = $this->createForm(DateFolderType::class, $searchFolder);
        $dateForm->handleRequest($request);

        $allForm = $this->createForm(AllFolderType::class);
        $allForm->handleRequest($request);
        if ($allForm->isSubmitted() && $allForm->isValid()) {
            $filters = false;
        }

        $allFolders = $this->folderRepository->findAll();
        $folders = $this->folderRepository->findAllWithFilters($searchFolder);

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'folders' => $folders,
            'tagForm' => $tagForm->createView(),
            'nameForm' => $nameForm->createView(),
            'filters' => $filters,
            'allFolders' => $allFolders,
            'allForm' => $allForm->createView(),
            'dateForm' => $dateForm->createView()
        ]);
    }

    #[Route('/user', name: 'user_session')]
    public function userSession(): Response
    {
        return $this->render(
            'user/show.html.twig',
            array('user' => $this->getUser())
        );
    }
}
