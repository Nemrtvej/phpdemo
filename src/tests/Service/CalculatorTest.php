<?php

namespace Tests\CalculatorTest;

use PHPUnit\Framework\TestCase;
use App\Service\Calculator;

class CalculatorTest extends TestCase
{
    /**
     * @dataProvider provideFactorialSuccess
     *
     * @param int $inputNumber
     * @param int $expectedResult
     */
    public function testFactorialSuccess(int $inputNumber, int $expectedResult): void
    {
        $service = new Calculator();

        $actualResult = $service->factorial($inputNumber);
        $this->assertEquals($expectedResult, $actualResult, 'Factorial number mismatch');
    }

    /**
     * @dataProvider provideFibonacciSuccess
     *
     * @param int $inputNumber
     * @param int $expectedResult
     */
    public function testFibonacciSuccess(int $inputNumber, int $expectedResult): void
    {
        $service = new Calculator();

        $actualResult = $service->fibonacci($inputNumber);
        $this->assertEquals($expectedResult, $actualResult, 'Fibonacci number mismatch');
    }

    /**
     * @dataProvider provideFactorialFail
     * @expectedException \InvalidArgumentException
     *
     * @param int $inputNumber
     */
    public function testFactorialFail(int $inputNumber): void
    {
        $service = new Calculator();

        $service->factorial($inputNumber);
    }

    /**
     * @dataProvider provideFibonacciFail
     * @expectedException \InvalidArgumentException
     *
     * @param int $inputNumber
     */
    public function testFibonacciFail(int $inputNumber): void
    {
        $service = new Calculator();

        $service->fibonacci($inputNumber);
    }

    /**
     * @return array
     */
    public function provideFactorialSuccess(): array
    {
        return [
            [0, 1],
            [1, 1],
            [2, 2],
            [8, 40320],
        ];
    }

    /**
     * @return array
     */
    public function provideFibonacciSuccess(): array
    {
        return [
            [0, 0],
            [1, 1],
            [2, 1],
            [3, 2],
            [13, 233],
        ];
    }

    /**
     * @return array
     */
    public function provideFactorialFail(): array
    {
        return [
            [-1],
            [-100],
        ];
    }

    /**
     * @return array
     */
    public function provideFibonacciFail(): array
    {
        return [
            [-1],
            [-2],
        ];
    }
}