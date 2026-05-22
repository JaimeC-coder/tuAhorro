<?php

namespace App\Livewire\Loans;

use App\DTOs\Filter\LoanFilterDTO;
use App\Helpers\ResourceViewHelper;
use App\Http\Requests\LoanRequest;
use App\Http\Resources\LoanResource;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;


class Index extends Component
{

    public function showLoan(int $loanId)
    {
        $idEncriptado = Crypt::encryptString($loanId);
        $url = route('loans.show', ['id' => $idEncriptado]);
        $this->dispatch('copy-to-clipboard', text: $url);
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
