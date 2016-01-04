<?php

namespace Jowy\Tactician;

use League\Tactician\Exception\InvalidCommandException;
use League\Tactician\Middleware;
use Jowy\Tactician\Contracts\ValidatorInterface;

/**
 * Class CommandValidatorMiddleware
 * @package Jowy\Tactician
 */
class CommandValidatorMiddleware implements Middleware
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param object $command
     * @param callable $next
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        try {
            $this->validator->validate($command);
            return $next($command);
        } catch (InvalidCommandException $e) {
            throw new InvalidCommandException($e->getMessage());
        }
    }
}
