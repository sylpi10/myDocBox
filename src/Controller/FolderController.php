<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Folder;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\FolderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FolderController extends AbstractController
{
    #[Route('/folder', name: 'app_folder')]
    public function index(): Response
    {
        return $this->render('folder/index.html.twig', [
            'folders' => 'FolderController',
        ]);
    }

    #[Route('user/character/new', name: 'new_character')]
    public function new(Request $request, ChatterInterface $chatter, User $discordtag): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($discordtag);
        $character = new Character();
        $characterForm = $this->createForm(CharacterType::class, $character);
        $characterForm->handleRequest($request);

        if ($characterForm->isSubmitted() && $characterForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($character);
            $entityManager->flush();
            $message = (new ChatMessage(''))
                ->transport('discord');
            $discordOptions = (new DiscordOptions())
                ->addEmbed((new DiscordEmbed())
                        ->color(2021216)
                        ->title('Nouvel demande d\'ajout de personnage')
                        ->addField((new DiscordFieldEmbedObject())
                                ->name("Name")
                                ->value($character)
                                ->inline(true)
                        )
                        ->addField((new DiscordFieldEmbedObject())
                                ->name('Author')
                                //->value($user)
                                ->inline(true)
                        )
                        ->addField((new DiscordFieldEmbedObject())
                                ->name('ADMIN')
                                ->value('[ADMIN](http://localhost:8000/admin?crudAction=index&crudControllerFqcn=App%5CController%5CAdmin%5CCharacterCrudController&menuIndex=1&signature=QMJsIaGWJEi-Dx3TMtOABAmk6hAffgiz_aCWABYXMdo&submenuIndex=-1)')
                                ->inline(true)
                        )

                );
            $message->options($discordOptions);
            $chatter->send($message);

            return $this->redirectToRoute('user');
        }

        return $this->renderForm('character/new.html.twig', [
            'new_character_form' => $characterForm,
        ]);
    }
}
