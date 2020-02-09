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
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class RectanglesCreator
{
    private $rectangle;
    private $rectanglesUnit;
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->rectangle = new Rectangle();
        $this->rectanglesUnit = new RectanglesUnit();
        $this->validator = $validator;
    }

    public function createRectangleCollection(array $data)
    {
        $this->rectangle->setWidth($data['width']);
        $this->rectangle->setHeight($data['height']);
        $this->rectangle->setColor($data['color']);

        $errors = $this->validator->validate($this->rectangle);
        
        var_dump($errors->count());
        var_dump((string) $errors);
    }


}