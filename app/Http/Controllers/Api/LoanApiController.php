<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Filter\LoanFilterDTO;
use App\DTOs\LoanDTO;
use App\Helpers\ResourceViewHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest;
use App\Http\Resources\LoanResource;
use App\Services\LoanService;
use App\Traits\ApiResponder;

class LoanApiController extends Controller
{
    use ApiResponder;

    protected LoanService $loanService;


    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function listar(LoanRequest $request)
    {

        return $this->handleApiRequest(function () use ($request) {


            if ($request->has('id')) {
                $loans = $this->loanService->find(LoanDTO::fromArrayAPI($request->validated())->id);
                $loans = new LoanResource($loans);
                return $loans;
            }
            $loans = $this->loanService->getAllLoans(LoanFilterDTO::fromRequest($request));
            $loans = LoanResource::collection($loans);
            return  ResourceViewHelper::paginate($loans, $request);
        }, 'Préstamos obtenidos correctamente');
    }

    public function register(LoanRequest $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            $details = $request->input('loan_details', []);
            $amount = $request->input('amount');
            if ($request->type_loans === 'cuota') {
                $cuotas = $this->loanService->buildCuotas($request->number_loans_cuota, $request->amount, $request->type_loans_cuota, $request->date_init);
                $details = array_merge($details, $cuotas);
            } elseif ($request->type_loans === 'prestamo') {
                $amount = $this->loanService->calculatePrestamoAmount($request->loan_details);
            }
            $loanDto = LoanDTO::fromArrayAPI(array_merge($request->validated(), [
                'amount'       => $amount,
                'loan_details' => $details,
            ]));
            return $this->loanService->create($loanDto);
        }, 'Préstamo creado correctamente', 201);
    }
    public function registerDetalle(LoanRequest $request)
    {

        return $this->handleApiRequest(function () use ($request) {
            $details = $request->input('loan_details', []);
            $amounts  = $request->input('amount');
            if ($request->type_loans == 'cuota') {
                $cuotas = $this->loanService->buildCuotas($request->number_loans_cuota, $request->amount, $request->type_loans_cuota, $request->date_init);
                $details = array_merge($details, $cuotas);
            } elseif ($request->type_loans == 'prestamo') {
                $amounts = $this->loanService->calculatePrestamoAmount($request->loan_details);
                $request->merge(['amount' => $amounts]);
            }
            $loanDto = LoanDTO::fromArrayAPI($request->validated());
            return $this->loanService->create($loanDto);
        }, 'Préstamo creado correctamente', 201);
    }

    public function actualizar(LoanRequest $request) //put
    {
        return $this->handleApiRequest(function () use ($request) {
            $loanDto = LoanDTO::fromArrayAPI($request->validated());
            return $this->loanService->update($loanDto->id, $loanDto);
        }, 'Préstamo actualizado correctamente', 200);
    }

    public function actualizarDetalle(LoanRequest $request) //patch
    {
        return $this->handleApiRequest(function () use ($request) {
            $amount = $this->loanService->calculatePrestamoAmount($request->loan_details);
            $request->merge(['amount' => $amount]);

            $loanDto = LoanDTO::fromArrayAPI(array_merge($request->validated(), ['amount' => $amount]));
            return $this->loanService->addDetails($loanDto->id, $loanDto);
        }, 'Préstamo actualizado correctamente', 200);
    }

    public function eliminar(LoanRequest $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            $loanDto = LoanDTO::fromArrayAPI($request->validated());
            return $this->loanService->delete($loanDto->id);
        }, 'Préstamo eliminado correctamente', 200);
    }
}
