<?php

namespace Project;

/**
 * Class CalculatorInterface
 *
 * @package Project
 */
interface CalculatorInterface
{
    /**
     * getAllCorners
     *
     * @param  array $baseCorners
     * @return array
     */
    public function getAllCorners(array $baseCorners): array;

    /**
     * getPerimeter
     *
     * @return float
     */
    public function getPerimeter(): float;

    /**
     * getArea
     *
     * @return float
     */
    public function getArea(): float;
   
    /**
     * getCost
     *
     * @return float
     */
    public function getCost(): float;    
}