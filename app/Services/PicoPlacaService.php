<?php

namespace App\Services;

use App\Enums\ResponseType;
use App\Rules\PlateNumber;
use DateTime;
use Illuminate\Support\Facades\Validator;

class PicoPlacaService
{

    public function predict($request) {

        $jsonResponse = array();

        $validator = Validator::make($request->all(), [
            'plateNumber' => ['required', 'min:6', 'max:7', 'alpha_num', new PlateNumber],
            'inputDate' => ['required','date_format:"Y-m-d"'],
            'inputTime' => ['required','date_format:"H:i"']
        ]);

        if ($validator->fails()) {
            $jsonResponse['responseType'] = ResponseType::ERROR;
            $errors = array();

            foreach ($validator->errors()->messages() as $message) :
                array_push($errors, $message[0]);
            endforeach;

            $jsonResponse['errors'] = $errors;
        } else {

            $plateNumber = $request->plateNumber;
            $inputDate = $request->inputDate;
            $inputTime = $request->inputTime;

            $plateNumberAllowed = $this->validatePicoPlaca($plateNumber, $inputDate, $inputTime);

            if ($plateNumberAllowed) {
                $jsonResponse['responseType'] = ResponseType::SUCCESS;
                $jsonResponse['responseMessage'] = 'The ' . $plateNumber . ' plate number is allowed to be on the road on '
                    . $inputDate . ' at ' . $inputTime;
            } else {
                $jsonResponse['responseType'] = ResponseType::WARNING;
                $jsonResponse['responseMessage'] = 'The ' . $plateNumber . ' plate number is not allowed to be on the road on '
                    . $inputDate . ' at ' . $inputTime;
            }

        }

        return $jsonResponse;

    }

    private function validatePicoPlaca($plateNumber, $inputDate, $inputTime) {

        $lastDigit = substr($plateNumber, -1);
        $convertedDate = DateTime::createFromFormat('Y-m-d', $inputDate);
        $convertedTime = DateTime::createFromFormat('H:i', $inputTime);
        $dayOfTheWeek = $convertedDate->format('w');

        if($dayOfTheWeek == 0 || $dayOfTheWeek == 6) {
            return true;
        }

        if (!($dayOfTheWeek == 1 && ($lastDigit == '1' || $lastDigit == '2')) &&
            !($dayOfTheWeek == 2 && ($lastDigit == '3' || $lastDigit == '4')) &&
            !($dayOfTheWeek == 3 && ($lastDigit == '5' || $lastDigit == '6')) &&
            !($dayOfTheWeek == 4 && ($lastDigit == '7' || $lastDigit == '8')) &&
            !($dayOfTheWeek == 5 && ($lastDigit == '9' || $lastDigit == '0'))) {
            return false;
        }

        $firstPeriodStart = DateTime::createFromFormat('H:i', '07:00');
        $firstPeriodEnd = DateTime::createFromFormat('H:i', '09:30');
        $secondPeriodStart = DateTime::createFromFormat('H:i', '16:00');
        $secondPeriodEnd = DateTime::createFromFormat('H:i', '19:30');

        return ($convertedTime >= $firstPeriodStart && $convertedTime <= $firstPeriodEnd) ||
            ($convertedTime >= $secondPeriodStart && $convertedTime <= $secondPeriodEnd);

    }

}
