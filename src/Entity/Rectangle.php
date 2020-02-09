<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RectangleRepository")
 */
class Rectangle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=24)
     */
    private $color;

    /**
     * @ORM\Column(type="object")
     */
    private $rectangles;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

        $metadata->addPropertyConstraint('width', new Assert\NotBlank());
        $metadata->addPropertyConstraint('width', new Assert\Range(['min' => 640, 'max' => 1920]));
        $metadata->addPropertyConstraint('height', new Assert\NotBlank());
        $metadata->addPropertyConstraint('height', new Assert\Range(['min' => 480, 'max' => 1080]));
        $metadata->addPropertyConstraint('color',
            new Assert\Regex(['pattern' => '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',]));
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

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

    public function getRectangles()
    {
        return $this->rectangles;
    }

    public function setRectangles($rectangleUnit): self
    {
        $this->rectangles[] = $rectangleUnit;

        return $this;
    }
}
