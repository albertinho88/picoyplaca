<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class PicoPlacaScheduleTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testPicoPlacaValidation()
    {
        $picoPlacaService = resolve('App\Services\PicoPlacaService');

        $plateNumber = "PCW7369";
        $inputDate = "2020-06-21";
        $inputTime = "07:00";

        $result = $picoPlacaService->validatePicoPlaca($plateNumber, $inputDate, $inputTime);

        if ($result) {
            echo 'can road';
        } else {
            echo 'can not road';
        }

        $this->assertTrue(true);
    }
}
