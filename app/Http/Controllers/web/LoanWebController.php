<?php

namespace App\Http\Controllers\web;

use App\DTOs\Filter\LoanFilterDTO;
use App\Helpers\ResourceViewHelper;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest;
use App\Http\Resources\LoanResource;
use App\Services\LoanService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class LoanWebController extends Controller
{

    protected LoanService $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $information = $this->loanService->getInformation();
        return view('web.loans.index', compact('information'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('web.loans.create');
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, String $id)
    {

        try {
            $idReal = Crypt::decryptString($id);
            $loan = Loan::findOrFail($idReal); // tú haces el binding manual
            session(['ultima_url_producto' => $request->fullUrl()]);

            $loanResource = new LoanResource($loan);
            $loan = $loanResource->resolve();
            return view('web.loans.show', compact('loan'));

        } catch (\Exception $e) {
            $ultimaUrl = session('ultima_url_producto');
            return $ultimaUrl
                ? redirect($ultimaUrl)
                : redirect()->route('producto.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('web.loans.edit');
    }
}
