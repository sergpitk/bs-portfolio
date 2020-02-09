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
        echo '<pre>';
            var_dump($key);
            var_dump($rectanglesUnit->getIdentity());
        echo '</pre>';



        $rectanglesUnitBucket = collect($rectangle->getRectangles())
            ->map(function ($unit, $unitKey) use ($key) {
                /** @var RectanglesUnit $unit */
                if ($key > $unitKey && ($unit->getStatus() !== $this->status[1])) {
                    return $unit;
                }
                else return false;
            })
            ->filter();




//        var_dump($rectanglesUnit->getIdentity());



//        var_dump($rectanglesUnitBucket->all());

        if (count ($rectanglesUnitBucket->all()) == 0) {
            $rectanglesUnit->setStatus($this->status[2]);
        }
        else {
            $rectanglesUnitBucket->each( function($unit,$unitKey) use ($rectanglesUnit, $key) {
                ($rectanglesUnit->getStatus() === $this->status[2]) ? : $this->checkLeftX($rectanglesUnit, $unit);
                ($rectanglesUnit->getStatus() === $this->status[2]) ? : $this->checkHighY($rectanglesUnit, $unit);
                ($rectanglesUnit->getStatus() === $this->status[2]) ? : $this->checkRightX($rectanglesUnit, $unit);
                ($rectanglesUnit->getStatus() === $this->status[2]) ? : $this->checkLowerY($rectanglesUnit, $unit);
                ($rectanglesUnit->getStatus() === $this->status[2]) ? : $rectanglesUnit->setStatus($this->status[1]);
            });
        }





        $rectanglesUnitBucket->each( function($unit,$unitKey) use ($rectanglesUnit, $key) {

            /** @var RectanglesUnit $unit */
            /* in this Context $unit is one of yet checked rectanglesUnit, but current is $rectanglesUnit*/
            if ($key > $unitKey && $unit->getStatus() !== $this->status[1]) {

                /*($rectanglesUnit->getStatus() === $this->status[2]) ? : $this->checkLeftX($rectanglesUnit, $unit);
                ($rectanglesUnit->getStatus() === $this->status[2]) ? : $this->checkHighY($rectanglesUnit, $unit);
                ($rectanglesUnit->getStatus() === $this->status[2]) ? : $this->checkRightX($rectanglesUnit, $unit);
                ($rectanglesUnit->getStatus() === $this->status[2]) ? : $this->checkLowerY($rectanglesUnit, $unit);
                ($rectanglesUnit->getStatus() === $this->status[2]) ? : $rectanglesUnit->setStatus($this->status[1]);*/
            }
            else {
                $rectanglesUnit->setStatus($this->status[2]);
            }
        });
                var_dump(collect($rectangle->getRectangles())->dump());

    }

    protected function checkLeftX (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        if ($rectanglesUnit->getX() > ($unit->getX() + $unit->getWidth())) {
            $rectanglesUnit->setStatus($this->status[2]);
        }
    }

    protected function checkHighY (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        if (($rectanglesUnit->getY() + $rectanglesUnit->getHeight()) < $unit->getY()) {
            $rectanglesUnit->setStatus($this->status[2]);
        }
    }

    protected function checkRightX (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        if (($rectanglesUnit->getX() + $rectanglesUnit->getWidth()) < $unit->getX()) {
            $rectanglesUnit->setStatus($this->status[2]);
        }
    }

    protected function checkLowerY (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        if ($rectanglesUnit->getY()  > ($unit->getY() + $unit->getHeight())) {
            $rectanglesUnit->setStatus($this->status[2]);
        }
    }
}