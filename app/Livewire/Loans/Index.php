<?php

namespace App\Livewire\Loans;

use App\DTOs\Filter\LoanFilterDTO;
use App\Helpers\ResourceViewHelper;
use App\Http\Requests\LoanRequest;
use App\Http\Resources\LoanResource;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Livewire\Component;
use Flux\Flux;

class Index extends Component
{


    public function showLoan(int $loanId)
    {
        $text = "hola como estas";
       $this->dispatch('copy-to-clipboard', text: $text);
        // return redirect()->route('loans.show', $loanId);
    }




    public function render(LoanService $service, Request $request)
    {

        $loanRequest = LoanRequest::createFrom($request);
        $loanDTO = LoanFilterDTO::fromRequest($loanRequest);
        $loans = $service->getAllLoans($loanDTO);
        $loans = LoanResource::collection($loans);
        $loans = ResourceViewHelper::paginateWeb($loans, $request);

        return view('livewire.loans.index', $loans);
    }
}
