<?php
/**
 * Created by PhpStorm.
 * User: Sergey Pitkevich <sergpitk@andi.lv>
 * Date: 09/02/2020
 * Time: 00:17
 */

namespace App\Service;


use App\Entity\Rectangle;
use App\Entity\RectanglesUnit;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class RectanglesCreator
{
    private $rectangle;
    private $rectanglesUnit;

    public function __construct()
    {
        $this->rectangle = new Rectangle();
        $this->rectanglesUnit = new RectanglesUnit();
    }

    public function createRectangleCollection(array $data)
    {
        $validator = Validation::createValidator();
        $groups = new Assert\GroupSequence(['Default', 'custom']);

        $constraint = new Assert\Collection([
            'width' => new Assert\Range(['min' => 640, 'max' => 1920]),
            'height' => new Assert\Range(['min' => 480, 'max' => 1080]),
            'color' => new Assert\Length(['min' => 1]),
        ]);


        $violations = $validator->validate($data, $constraint, $groups);
        var_dump($violations->count());


        $this->rectangle->setWidth($data['width']);
        $this->rectangle->setHeight($data['height']);
        $this->rectangle->setColor($data['color']);
        
        var_dump($this->rectangle);
    }
}