<?php

namespace Project\Calculator;

use Project\CalculatorInterface;
use Project\Constant\Cost;

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

        $cost = 0;

        // add cornerstones
        $cost += 4 * Cost::CORNER['cost'];
        $width -= 2 * Cost::CORNER['size'];
        $height -= 2 * Cost::CORNER['size'];

        // add gates
        $gateFullCost = Cost::GATE['cost'] + (2 * Cost::PILLAR['cost']);
        $gateFullLength = Cost::GATE['size'] + (2 * Cost::PILLAR['size']);
        $wireSegmentFullCost = Cost::WIRE['cost'] + Cost::PILLAR['cost'];
        $wireSegmentFullLength = Cost::WIRE['size'] + Cost::PILLAR['size'];

        if ($width > $gateFullLength) {
            $cost += 2 * $gateFullCost;
            $width -= $gateFullLength;

            // add wireSegments to segments (= from cornerstone to gate)
            $widthSegment = $width / 2;

            $wireSegmentCount = floor($widthSegment / $wireSegmentFullLength);

            // add a final wire, without pillar
            $cost += 4 * (($wireSegmentCount * $wireSegmentFullCost) + Cost::WIRE['cost']);
            $width = 0;
        }

        if ($height > $gateFullLength) {
            $cost += 2 * $gateFullCost;
            $height -= $gateFullLength;

            // add wireSegments to segments (= from cornerstone to gate)
            $heightSegment = $height;

            $wireSegmentCount = floor($heightSegment / $wireSegmentFullLength);

            // add a final wire, without pillar
            $cost += 4 * (($wireSegmentCount * $wireSegmentFullCost) + Cost::WIRE['cost']);
            $height = 0;
        }

        // calculate the remaining (sides without gates
        $remainingPerimeter = (2 * $width) + (2 * $height);

        $wireSegmentCount = floor($remainingPerimeter / $wireSegmentFullLength);
        $cost += 4 * (($wireSegmentCount * $wireSegmentFullCost) + Cost::WIRE['cost']);

        return $cost;
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