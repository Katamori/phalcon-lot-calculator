<?php

namespace Project\Validation;

use Phalcon\Messages\Message;
use Phalcon\Validation;
use Phalcon\Validation\ValidatorInterface;

/**
 * Class LotCoordinateValidator
 *
 * @package Project\Validation
 */
class LotCoordinateValidator implements Validation\ValidatorInterface
{
    /**
     * Executes the validation
     *
     * @param Validation $validation
     * @param mixed $field
     * @return boolean
     */
    public function validate(Validation $validation, $field): bool
    {
        $value = json_decode($validation->getValue($field), true);

        // does this has the length of 2? (+ the points themselves)
        if (sizeof($value) !== 2
            || sizeof($value[0]) !== 2
            || sizeof($value[1]) !== 2
        ) {
            $validation->appendMessage(new Message("Missing point or coordinates!"));

            return false;
        }

        // coords are numbers
        if (!is_numeric($value[0]['x'])
            || !is_numeric($value[0]['y'])
            || !is_numeric($value[1]['x'])
            || !is_numeric($value[1]['y'])
        ) {
            $validation->appendMessage(new Message("One or more coordinates are not numeric!"));

            return false;
        }

        // differences are alright
        if ($value[0]['x'] >= $value[1]['x'] || $value[0]['y'] >= $value[1]['y']) {
            $validation->appendMessage(new Message("Point A must be above AND left of Point B!"));

            return false;
        }

        return true;
    }

    public function getOption(string $key, $defaultValue = null)
    {
        // TODO: Implement getOption() method.
    }

    public function hasOption(string $key): bool
    {
        // TODO: Implement hasOption() method.
    }

    public function getTemplate(string $field): string
    {
        // TODO: Implement getTemplate() method.
    }

    public function getTemplates(): array
    {
        // TODO: Implement getTemplates() method.
    }

    public function setTemplates(array $templates): ValidatorInterface
    {
        // TODO: Implement setTemplates() method.
    }

    public function setTemplate(string $template): ValidatorInterface
    {
        // TODO: Implement setTemplate() method.
    }
}