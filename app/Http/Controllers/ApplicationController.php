<?php

namespace App\Http\Controllers;

use App\Services\PicoPlacaService;
use Illuminate\Http\Request;

/**
 * The Application Controller
 */
class ApplicationController extends Controller
{

    protected $picoPlacaService;

    /**
     * Constroller constructor
     *
     * @picoPlacaService pico placa service to make service injection
     */
    public function __construct(PicoPlacaService $picoPlacaService) {
        $this->picoPlacaService = $picoPlacaService;
    }

    /**
     * GET function to render the home and principal view.
     */
    public function renderHome() {
        return view('application');
    }

    /**
     * POST function to predict the Pico y Placa logic.
     *
     * @request POST request
     */
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
