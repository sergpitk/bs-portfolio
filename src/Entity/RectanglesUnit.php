<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RectanglesUnitRepository")
 */
class RectanglesUnit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $identity;


    /**
     * @ORM\Column(type="integer")
     */
    private $x;

    /**
     * @ORM\Column(type="integer")
     */
    private $y;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="string", length=24)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=24)
     */
    private $status;

    /**
     * @ORM\Column(type="array")
     */
    private $status_library = [];

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('identity', new Assert\NotBlank());
        $metadata->addPropertyConstraint('identity', new Assert\Length(['min' => 1, 'max' => 255]));
        $metadata->addPropertyConstraint('x', new Assert\NotBlank());
        $metadata->addPropertyConstraint('x', new Assert\Range(['min' => 1]));
        $metadata->addPropertyConstraint('y', new Assert\NotBlank());
        $metadata->addPropertyConstraint('y', new Assert\Range(['min' => 1]));
        $metadata->addPropertyConstraint('height', new Assert\NotBlank());
        $metadata->addPropertyConstraint('height', new Assert\Range(['min' => 1]));
        $metadata->addPropertyConstraint('height', new Assert\NotBlank());
        $metadata->addPropertyConstraint('height', new Assert\Range(['min' => 1]));
        $metadata->addPropertyConstraint('color',
            new Assert\Regex(['pattern' => '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',]));
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStatusLibrary(): ?array
    {
        return $this->status_library;
    }

    public function setStatusLibrary(array $status_library): self
    {
        $this->status_library = $status_library;

        return $this;
    }
}
