<?php
/**
 * Created by PhpStorm.
 * User: Sergey Pitkevich <sergpitk@andi.lv>
 * Date: 09/02/2020
 * Time: 15:49
 * validate RectanglesUnit against Rectangle && other RectanglesUnit
 */

namespace App\Service;

use App\Entity\Rectangle;
use App\Entity\RectanglesUnit;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RectanglesOverlapValidator
{
    private $validator;
    /** @param $status */
    private $status;

    public function __construct(ValidatorInterface $validator, $status)
    {
        $this->validator = $validator;
        $this->status = $status;
    }

    /**
     * @param Rectangle $rectangle
     * @return Rectangle
     */
    public function validateOverlapCollection(Rectangle $rectangle)
    {
        $rectanglesUnits = $rectangle->getRectangles();

        foreach ($rectanglesUnits as $key => $rectanglesUnit){
            $this->validateAgainstRectangleSize($rectangle, $rectanglesUnit);
        }

        return $rectangle;
    }

    protected function validateAgainstRectangleSize(Rectangle $rectangle, RectanglesUnit $rectanglesUnit)
    {
        $x = $rectanglesUnit->getX();
        $y = $rectanglesUnit->getY();
        $width = $rectanglesUnit->getWidth();
        $height = $rectanglesUnit->getHeight();

        $input = ['size_x' => $x + $width, 'size_y' => $y + $height];

        $constraints = new Assert\Collection([
            'size_x' => new Assert\Range(
                ['min' => 1, 'max' => $rectangle->getWidth() - 1]
            ),
            'size_y' => new Assert\Range(
                ['min' => 1, 'max' => $rectangle->getHeight() - 1]
            )
        ]);

        $errors = $this->validator->validate($input, $constraints);

        var_dump($rectanglesUnit);
    }
}