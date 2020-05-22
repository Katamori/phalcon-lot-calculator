<?php

namespace Project\Calculator;

use Project\CalculatorInterface;

/**
 * Class Rectangle
 *
 * @package Project\Calculator
 * @info    Rectangular implementation of calculator class
 */
class Rectangle implements CalculatorInterface
{
    /**
     * _corners
     *
     * @var string
     */
    protected array $_corners = [];

    /**
     * getCorners
     *
     * @info   This function *assumes* you have an array of two, and 0 is upper_left.
     * @param  array $baseCorners
     * @return array
     */
    public function getAllCorners(array $baseCorners): array {
        return [
            "upper_left" => $baseCorners[0],
            "upper_right" => [
                "x" => $baseCorners[1]['x'],
                "y" => $baseCorners[0]['y']
            ],
            "lower_left" => [
                "x" => $baseCorners[0]['x'],
                "y" => $baseCorners[1]['y'],
            ],
            "lower_right" => $baseCorners[1],
        ];
    }

    /**
     * getPerimeter
     *
     * @return float
     */
    public function getPerimeter(): float {
        $corners = $this->getCorners();
        $width = $corners['lower_right']['x'] - $corners['upper_left']['x'];
        $height = $corners['lower_right']['y'] - $corners['upper_left']['y'];

        return ($width * 2) + ($height *2);
    }

    /**
     * getArea
     *
     * @return float
     */
    public function getArea(): float {
        $corners = $this->getCorners();
        $width = $corners['lower_right']['x'] - $corners['upper_left']['x'];
        $height = $corners['lower_right']['y'] - $corners['upper_left']['y'];

        return $width * $height;
    }
   
    /**
     * getCost
     *
     * @return float
     */
    public function getCost(): float {
        $corners = $this->getCorners();
        $width = $corners['lower_right']['x'] - $corners['upper_left']['x'];
        $height = $corners['lower_right']['y'] - $corners['upper_left']['y'];

        return -1;
    }

    /**
     * @return array
     */
    public function getCorners(): array
    {
        return $this->_corners;
    }

    /**
     * @param array $corners
     */
    public function setCorners(array $corners): void
    {
        $this->_corners = $corners;
    }
}