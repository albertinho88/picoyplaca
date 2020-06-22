<?php

namespace App\Http\Controllers;

use App\Services\PicoPlacaService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{

    protected $picoPlacaService;

    public function __construct(PicoPlacaService $picoPlacaService) {
        $this->picoPlacaService = $picoPlacaService;
    }

    public function renderHome() {
        return view('application');
    }

    public function predict(Request $request) {
        $jsonResponse = array();

        try {
            $jsonResponse = $this->picoPlacaService->predict($request);
        } catch (\Exception $e) {
            $jsonResponse['responseType'] = 'danger';
            $jsonResponse['responseMessage'] = $e->getMessage();
        }

        return response()->json($jsonResponse);
    }

}
