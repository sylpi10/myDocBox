<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Folder;
use App\Entity\User;
use App\Form\FolderType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use App\Repository\FolderRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FolderController extends AbstractController
{
    /*#[Route('user/folder', name: 'app_folder')]
    public function index(Request $request, FolderRepository $folderRepository): Response
    {
        $folders = $this->getDoctrine()->getRepository(Folder::class)->findby([], ['name' => 'asc']);
        return $this->render('folder/index.html.twig', [
            'folders' => 'FolderController',
        ]);
    }*/

    #[Route('user/folder/new', name: 'new_folder')]
    public function new(Request $request): Response
    {
        $folder = new Folder();

        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $folder = $form->getData();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('user_session');
        }
        return $this->renderForm('folder/index.html.twig', [
            'form' => $form,
        ]);
    }
}
