<?php

declare(strict_types=1);

namespace App\Post\UI\Http\Controller;

use App\Post\Application\Command\CreateNewPost;
use App\Post\Application\Dto\PostDTO;
use App\Post\UI\Http\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post', name: 'post_')]
class PostController extends AbstractController
{
    #[Route('/create', name: 'create')]
    public function create(Request $request, MessageBusInterface $bus)
    {
        $form = $this->createForm(PostType::class, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $bus->dispatch(new CreateNewPost(new PostDTO(...$data)));

            return $this->redirectToRoute('post_created');
        }

        return $this->render('post/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/created', name: 'created')]
    public function created()
    {
        return $this->render('post/created.html.twig');
    }
}
