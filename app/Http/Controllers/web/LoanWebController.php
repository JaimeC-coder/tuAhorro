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

class LoanWebController extends Controller
{

    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $loanRequest = LoanRequest::createFrom($request);
        $loanDTO = LoanFilterDTO::fromRequest($loanRequest);
        // return $loanDTO;
        $loans = $this->loanService->getAllLoans($loanDTO);
        $loans = LoanResource::collection($loans);

        $loans = ResourceViewHelper::paginate($loans, $request);
        return view('web.loans.index', $loans);
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
    public function show()
    {
        return view('web.loans.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('web.loans.edit');
    }
}
