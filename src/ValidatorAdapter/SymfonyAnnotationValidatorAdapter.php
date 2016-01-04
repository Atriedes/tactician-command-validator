<?php

namespace Jowy\Tactician\ValidatorAdapter;

use Jowy\Tactician\Contracts\ValidatorInterface;
use League\Tactician\Exception\InvalidCommandException;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidator;

/**
 * Class SymfonyAnnotationValidatorAdapter
 * @package Jowy\Tactician\ValidatorAdapter
 */
class SymfonyAnnotationValidatorAdapter implements ValidatorInterface
{
    /**
     * @var SymfonyValidator
     */
    private $validator;

    /**
     * @param SymfonyValidator $validator
     */
    public function __construct(SymfonyValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $command
     */
    public function validate($command)
    {
        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = str_replace(
                "This value",
                ucfirst($violation->get(0)->getPropertyPath()),
                $violation->get(0)->getMessage()
            );
            throw new InvalidCommandException($message);
        }
    }
}
