<?php

declare(strict_types=1);

namespace App\Post\UI\Http\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UuidType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('authorUuid', UuidType::class)
            ->add('save', SubmitType::class);
    }
}
