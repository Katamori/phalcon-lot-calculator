<?php

namespace Project\Controller;

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Project\CalculatorInterface;
use Project\Constant\Service;

/**
 * Class CalculateController
 *
 * @package Project\Controller
 */
class CalculateController extends Controller
{    
    /**
     * _calculatorClass
     *
     * @var string
     */
    protected string $_calculatorClass = '\\Project\\Calculator\\Rectangle';

    /**
     * _calculator
     *
     * @var CalculatorInterface
     */
    protected $_calculator;

    public function initialize()
    {
        $this->view->disable();
    }

    /**
     * Default controller action
     */
    public function indexAction()
    {
        $res = new Response();
        $res->setHeader("Access-Control-Allow-Origin", "*")
            ->setHeader('Access-Control-Allow-Headers', '*');


        // todo validate structure
        $requestBody = $this->request->getRawBody();
        $requestCoords = json_decode($requestBody, true);

        if (false) {
            return $res->setStatus(400)
                        ->setJsonContent([
                "message" => "invalid request"
            ]);
        }

        $calc = $this->getCalculator();
        $corners = $calc->getAllCorners([
            $requestCoords[0],
            $requestCoords[1],
        ]);
        $calc->setCorners($corners);

        return $res->setJsonContent([
            "corners" => $corners,
            "perimeter" => $calc->getPerimeter(),
            "area" => $calc->getArea(),
            "cost" => $calc->getCost()
        ]);
    }

    /**
     * @return CalculatorInterface
     */
    public function getCalculator()
    {
        if (!$this->_calculator) {
            $calculatorClass = $this->getCalculatorClass();

            $this->_calculator = new $calculatorClass();
        }

        return $this->_calculator;
    }

    /**
     * @param CalculatorInterface $calculator
     */
    public function setCalculator($calculator): void
    {
        $this->_calculator = $calculator;
    }

    /**
     * @return string
     */
    public function getCalculatorClass(): string
    {
        return $this->_calculatorClass;
    }

    /**
     * @param string $calculatorClass
     */
    public function setCalculatorClass(string $calculatorClass): void
    {
        $this->_calculatorClass = $calculatorClass;
    }
}