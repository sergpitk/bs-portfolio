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
            ->map(function ($unit, $unitKey) use ($key) {
                /** @var RectanglesUnit $unit */
                if (/*$key > $unitKey &&*/ ($unit->getStatus() === $this->status[2])) {
                    return $unit;
                }
                else return false;
            })
            ->filter();


        var_dump($rectanglesUnitBucket->dump());


//        var_dump($rectanglesUnit->getIdentity());



//        var_dump($rectanglesUnitBucket->dump());

        if (count ($rectanglesUnitBucket->all()) == 0) {
            $rectanglesUnit->setStatus($this->status[2]);
        }
        else {

            $count = $rectanglesUnitBucket->count();
            $rectanglesUnitBucket->each( function($unit, $unitKey) use ($rectanglesUnit, $count) {

                $this->overlap = 0;
                echo '<pre>';
                var_dump($rectanglesUnit->getIdentity());
                var_dump($rectanglesUnit->getStatus());
                var_dump($unitKey);
                echo '</pre>';


                ($rectanglesUnit->getStatus() === $this->status[2] && ($unitKey == $count)) ? : $this->checkLeftX($rectanglesUnit, $unit);
                ($rectanglesUnit->getStatus() === $this->status[2] && ($unitKey == $count)) ? : $this->checkHighY($rectanglesUnit, $unit);
                ($rectanglesUnit->getStatus() === $this->status[2] && ($unitKey == $count)) ? : $this->checkRightX($rectanglesUnit, $unit);
                ($rectanglesUnit->getStatus() === $this->status[2] && ($unitKey == $count)) ? : $this->checkLowerY($rectanglesUnit, $unit);

                ($this->overlap == 1) ? $rectanglesUnit->setStatus($this->status[2]) : $rectanglesUnit->setStatus($this->status[1]);
            });
        }






//                var_dump(collect($rectangle->getRectangles())->dump());

    }

    protected function checkLeftX (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        var_dump(($rectanglesUnit->getX() + $rectanglesUnit->getWidth()), '$rectanglesUnit->getX()');
        var_dump($unit->getX(), 'unit->getX()');

        if ($unit->getX() > ($rectanglesUnit->getX() + $rectanglesUnit->getWidth())) {
            var_dump($rectanglesUnit->getIdentity(),'checkLeftX');
            $rectanglesUnit->setStatus($this->status[2]);
        }
    }

    protected function checkHighY (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        if (($unit->getY() + $unit->getHeight()) < $rectanglesUnit->getY()) {
            var_dump($rectanglesUnit->getIdentity(),'checkHighY');

            $rectanglesUnit->setStatus($this->status[2]);
        }
    }

    protected function checkRightX (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        if (($unit->getX() + $unit->getWidth()) < $rectanglesUnit->getX()) {
            var_dump($rectanglesUnit->getIdentity(),'checkRightX');

            $rectanglesUnit->setStatus($this->status[2]);
        }
    }

    protected function checkLowerY (RectanglesUnit $rectanglesUnit, RectanglesUnit $unit) {
        if ($unit->getY()  > ($rectanglesUnit->getY() + $rectanglesUnit->getHeight())) {
            var_dump($rectanglesUnit->getIdentity(),'checkLowerY');

            $rectanglesUnit->setStatus($this->status[2]);
        }
    }
}