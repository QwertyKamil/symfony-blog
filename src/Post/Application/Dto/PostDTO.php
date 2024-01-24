<?php

declare(strict_types=1);

namespace App\Post\Application\Dto;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class PostDTO
{
    #[Groups(["create", "update"])]
    #[Assert\NotBlank(groups: ["create", "update"])]
    #[Assert\Length(min: 10, max: 80, groups: ["create", "update"])]
    private string $title;

    #[Groups(["create", "update"])]
    #[Assert\NotBlank(groups: ["create", "update"])]
    #[Assert\Length(min: 20, groups: ["create", "update"])]
    private string $content;

    #[Groups(["create", "update"])]
    #[Assert\NotBlank(groups: ["create", "update"])]
    #[Assert\Uuid(groups: ["create", "update"])]
    private Uuid $authorUuid;

//    #[Groups(["default", "create", "update"])]
//    #[Assert\NotBlank(groups: ["default", "create"])]
//    #[Assert\File(
//        maxSize: '1024k',
//        binaryFormat: true,
//        extensions: ['jpg', 'png'],
//        extensionsMessage: 'Please upload a valid JPG image'
//    )]
    protected ?File $image;

    /**
     * @param string $title
     * @param string $content
     * @param Uuid $authorUuid
     * @param File|null $image
     */
    public function __construct(
        string $title,
        string $content,
        Uuid $authorUuid,
        ?File $image = null
    ) {
        $this->title = $title;
        $this->content = $content;
        $this->authorUuid = $authorUuid;
        $this->image = $image;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getAuthorUuid(): Uuid
    {
        return $this->authorUuid;
    }

    public function setAuthorUuid(Uuid $authorUuid): void
    {
        $this->authorUuid = $authorUuid;
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    public function setImage(?File $image): void
    {
        $this->image = $image;
    }
}
