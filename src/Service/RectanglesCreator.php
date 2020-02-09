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
use Symfony\Component\Validator\Validator\ValidatorInterface;


class RectanglesCreator
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
     * @param array $data
     * @return Rectangle
     */
    public function createRectangleCollection(Rectangle $rectangle, array $data)
    {
        $this->createBasicRectangle($rectangle , $data);

        foreach ($data['rectangles'] as $key => $rectanglesUnitData){
            $rectangle->setRectangles(
                $this->createRectangleUnit($rectanglesUnitData)
            );
        }
        return $rectangle;
    }


    protected function createRectangleUnit(array $rectanglesUnitData)
    {
        $rectanglesUnit = new RectanglesUnit();
        
        $rectanglesUnit->setIdentity($rectanglesUnitData['id']);
        $rectanglesUnit->setX($rectanglesUnitData['x']);
        $rectanglesUnit->setY($rectanglesUnitData['y']);
        $rectanglesUnit->setWidth($rectanglesUnitData['width']);
        $rectanglesUnit->setHeight($rectanglesUnitData['height']);
        $rectanglesUnit->setColor($rectanglesUnitData['color']);
        $rectanglesUnit->setStatus($this->status[0]);

        $errors = $this->validator->validate($rectanglesUnit);

        if (count($errors) > 0) {
            $rectanglesUnit->setErrors((string)$errors);
            $rectanglesUnit->setStatus($this->status[1]);
        }
        return $rectanglesUnit;
    }

    protected function createBasicRectangle( Rectangle $rectangle, array $data)
    {


        $rectangle->setWidth($data['width']);
        $rectangle->setHeight($data['height']);
        $rectangle->setColor($data['color']);

        $errors = $this->validator->validate($rectangle);

        if (count($errors) > 0) {
            $rectangle->setErrors((string)$errors);
        }
    }


}