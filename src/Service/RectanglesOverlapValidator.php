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

    /** @var $overlap */
    private $overlap;

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

        /**
        * @var  RectanglesUnit $rectanglesUnit
        */
        foreach ($rectanglesUnits as $key => $rectanglesUnit) {
            if ($rectanglesUnit->getStatus() === $this->status[0]) {
                 $this->validateAgainstRectangleSize($rectangle, $rectanglesUnit);
            }

            if ($rectanglesUnit->getStatus() === $this->status[0]) {
                $this->validateRectanglesUnitOverlap($rectangle, $rectanglesUnit, $key);
            }

            if ($rectanglesUnit->getStatus() === $this->status[1]) {
                $this->validateRectanglesUnitOverlap($rectangle, $rectanglesUnit, $key);

                // todo get real overlap data for constraints
                $input = [1,1];

                $constraints = new Assert\Unique ();

                $errors = $this->validator->validate($input, $constraints);

                if (count($errors) > 0) {
                    $rectanglesUnit->setErrors((string)$errors);
                }
            }


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
                ['max' => $rectangle->getWidth() - 1]
            ),
            'size_y' => new Assert\Range(
                ['max' => $rectangle->getHeight() - 1]
            )
        ]);

        $errors = $this->validator->validate($input, $constraints);

        if (count($errors) > 0) {
            $rectanglesUnit->setErrors((string)$errors);
            $rectanglesUnit->setStatus($this->status[1]);
        }
    }

    protected function validateRectanglesUnitOverlap(Rectangle $rectangle, RectanglesUnit $rectanglesUnit, $key)
    {
        $rectanglesUnitBucket = collect($rectangle->getRectangles())
            ->map(function ($unit) use ($key) {
                /** @var RectanglesUnit $unit */
                if ($unit->getStatus() === $this->status[2]) {
                    return $unit;
                }
                else return false;
            })
            ->filter();

        if (count ($rectanglesUnitBucket->all()) == 0) {
            $rectanglesUnit->setStatus($this->status[2]);
        }
        else {
            $rectanglesUnitBucket->each( function($unit) use ($rectanglesUnit) {

                $this->overlap = 1;

                /* no check's if overlap detected in previous iteration */
                if ($rectanglesUnit->getStatus() !== $this->status[1]) {
                    ($this->overlap == 0) ? : $this->checkLeftX($rectanglesUnit, $unit);
                    ($this->overlap == 0) ? : $this->checkHighY($rectanglesUnit, $unit);
                    ($this->overlap == 0) ? : $this->checkRightX($rectanglesUnit, $unit);
                    ($this->overlap == 0) ? : $this->checkLowerY($rectanglesUnit, $unit);
                }

                ($this->overlap == 0) ? $rectanglesUnit->setStatus($this->status[2])
                    : $rectanglesUnit->setStatus($this->status[1]);
            });
        }

//                var_dump(collect($rectangle->getRectangles())->dump());

    }

    private function checkLeftX (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        if ($unit->getX() > ($rectanglesUnit->getX() + $rectanglesUnit->getWidth())) {
            $this->overlap = 0;
        }
    }

    private function checkHighY (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        if (($unit->getY() + $unit->getHeight()) < $rectanglesUnit->getY()) {
            $this->overlap = 0;
        }
    }

    private function checkRightX (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        if (($unit->getX() + $unit->getWidth()) < $rectanglesUnit->getX()) {
            $this->overlap = 0;
        }
    }

    private function checkLowerY (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        if ($unit->getY()  > ($rectanglesUnit->getY() + $rectanglesUnit->getHeight())) {
            $this->overlap = 0;
        }
    }
}