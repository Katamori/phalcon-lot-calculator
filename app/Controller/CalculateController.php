<?php

namespace Project\Controller;

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Phalcon\Validation;
use Project\CalculatorInterface;
use Project\Validation\LotCoordinateValidator;

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

        $reqMethod = $this->request->getMethod();

        if (!in_array($reqMethod, [
            "POST",
            "OPTIONS"
        ])) {
            return $res->setStatusCode(400)
                        ->setJsonContent([
                "message" => "Only POST and OPTIONS methods are allowed!"
            ]);
        }

        // for the VueJS preflight request
        if ($reqMethod === "OPTIONS") {
            return $res->setStatusCode(200);
        }

        $requestBody = $this->request->getRawBody();
        $requestCoords = json_decode($requestBody, true);

        /** @var Validation\ValidatorInterface $coordsValidator */
        $coordsValidator = new LotCoordinateValidator();

        $validation = new Validation();
        $validation->add("coordinates", $coordsValidator);

        $coordValidationMessages = $validation->validate([
            "coordinates"   => $requestBody
        ]);

        if ($coordValidationMessages->count() > 0) {
            return $res->setStatusCode(400)
                        ->setJsonContent($coordValidationMessages->jsonSerialize());
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