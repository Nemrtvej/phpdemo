<?php

namespace App\Service;


/**
 * Simple service for demonstrating how to do a unit test.
 *
 * For Gods sake, do not ever dare to use this in production as this implementation is meant only for demo purpose.
 *
 * @package Service
 */
class Calculator
{
    /**
     * Calculate fibonacci number.
     *
     * @param int $number
     *
     * @return int
     */
    public function fibonacci(int $number): int
    {
        if ($number < 0) {
            throw new \InvalidArgumentException('This function expects a positive number.');
        }

        if ($number === 0) {
            return 0;
        }

        if ($number === 1) {
            return 1;
        }

        return $this->fibonacci($number - 1) + $this->fibonacci($number - 2);
    }

    /**
     * Calculate factorial number.
     *
     * @param int $number
     *
     * @return int
     */
    public function factorial(int $number): int
    {
        if ($number < 0) {
            throw new \InvalidArgumentException('This function expects a positive number.');
        }

        if ($number === 0) {
            return 1;
        }

        return $this->factorial($number - 1) * $number;
    }
}