<?php
/**
 * Created by PhpStorm.
 * User: Sergey Pitkevich <sergpitk@andi.lv>
 * Date: 09/02/2020
 * Time: 00:17
 * create and validate main Rectangle and Rectangles Unit's
 */

namespace App\Service;

use App\Entity\Rectangle;
use App\Entity\RectanglesUnit;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class RectanglesCreator
{
    /** @var Rectangle $rectangle */
    private $rectangle;
    /** @var RectanglesUnit $rectanglesUnit */
    private $rectanglesUnit;
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
     * @param array $data
     * @return Rectangle
     */
    public function createRectangleCollection(Rectangle $rectangle, array $data)
    {
        $this->rectangle = $rectangle;
        $this->createBasicRectangle($data);

        foreach ($data['rectangles'] as $key => $rectanglesUnitData){
            $this->rectangle->setRectangles(
                $this->createRectangleUnit($rectanglesUnitData)
            );
        }
        return $this->rectangle;
    }


    protected function createRectangleUnit(array $rectanglesUnitData)
    {
        $this->rectanglesUnit = new RectanglesUnit();
        
        $this->rectanglesUnit->setIdentity($rectanglesUnitData['id']);
        $this->rectanglesUnit->setX($rectanglesUnitData['x']);
        $this->rectanglesUnit->setY($rectanglesUnitData['y']);
        $this->rectanglesUnit->setWidth($rectanglesUnitData['width']);
        $this->rectanglesUnit->setHeight($rectanglesUnitData['height']);
        $this->rectanglesUnit->setColor($rectanglesUnitData['color']);
        $this->rectanglesUnit->setStatus($this->status[0]);

        $errors = $this->validator->validate($this->rectanglesUnit);

        if (count($errors) > 0) {
            $this->rectanglesUnit->setErrors((string)$errors);
            echo '<pre>';
            var_dump($this->rectanglesUnit->getErrors());
            echo '</pre>';
        }
        return $this->rectanglesUnit;
    }

    protected function createBasicRectangle(array $data)
    {


        $this->rectangle->setWidth($data['width']);
        $this->rectangle->setHeight($data['height']);
        $this->rectangle->setColor($data['color']);

        $errors = $this->validator->validate($this->rectangle);

        if (count($errors) > 0) {
            $this->rectangle->setErrors((string)$errors);
            echo '<pre>';
            var_dump($this->rectangle->getErrors());
            echo '</pre>';
        }
    }


}