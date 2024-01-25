<?php

declare(strict_types=1);

namespace App\Post\UI\Http\Controller;

use App\Post\Application\Command\CreateNewPost;
use App\Post\Application\Dto\PostDTO;
use App\Post\UI\Http\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/post', name: 'post_')]
class PostController extends AbstractController
{
    #[Route('/create', name: 'create')]
    public function create(
        Request $request,
        MessageBusInterface $bus,
        ValidatorInterface $validator
    ) {
        $form = $this->createForm(PostType::class, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $post = new PostDTO(...$data);
            $errors = $validator->validate($post, null, ['create']);

            if (count($errors) == 0) {
                $bus->dispatch(new CreateNewPost($post));

                return $this->redirectToRoute('post_created');
            }

            foreach ($errors as $error) {
                $form->addError(
                    new FormError(
                        sprintf(
                            '%s %s',
                            $error->getPropertyPath(),
                            $error->getMessage()
                        ),
                        $error->getMessageTemplate(),
                        $error->getParameters(),
                        $error->getPlural(),
                        $error->getCode()
                    )
                );
            }
        }

        return $this->render('post/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/created', name: 'created')]
    public function created()
    {
        return $this->render('post/created.html.twig');
    }
}
