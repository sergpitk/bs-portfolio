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
use Symfony\Component\Validator\Validator\ValidatorInterface;


class RectanglesCreator
{
    /** @var Rectangle $rectangle */
    private $rectangle;
    /** @var RectanglesUnit $rectanglesUnit */
    private $rectanglesUnit;
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $data
     */
    public function createRectangleCollection(array $data)
    {
        $this->rectangle = new Rectangle();
        $this->createBasicRectangle($data);

        foreach ($data['rectangles'] as $key => $rectanglesUnitData){
            $this->rectangle->setRectangles(
                $this->createRectangleUnit($rectanglesUnitData)
            );
        }


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

        $errors = $this->validator->validate($this->rectanglesUnit);

        echo '<pre>';
        var_dump($errors);
        echo '</pre>';

        return $this->rectanglesUnit;
    }

    protected function createBasicRectangle(array $data)
    {


        $this->rectangle->setWidth($data['width']);
        $this->rectangle->setHeight($data['height']);
        $this->rectangle->setColor($data['color']);

        $errors = $this->validator->validate($this->rectangle);

//        var_dump($errors->count());
//        var_dump((string) $errors);
    }


}