<?php

namespace App\Services;

use App\DTOs\Filter\LoanFilterDTO;
use App\Repositories\LoanRepository;
use App\DTOs\LoanDTO;

class LoanService
{
    protected LoanRepository $loanRepository;

    public function __construct(LoanRepository $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function create(LoanDTO $dto)
    {

        return $this->loanRepository->create($dto->toArray());
    }

    public function getInformation(){
        return $this->loanRepository->getInformation();
    }

    public function getAllLoans(LoanFilterDTO $dto)
    {
        return $this->loanRepository->all($dto);
    }




    public function find(int|string $id)
    {
        return  $this->loanRepository->find($id);
    }

    public function update(int|string $id, LoanDTO $dto)
    {
        return $this->loanRepository->update($id, $dto->toArray());
    }

    public function addDetails(int|string $id, LoanDTO $details)
    {

        return $this->loanRepository->addDetails($id, $details->toArray());
    }

    public function updateStatus(int|string $id, int|string $loanDetailsId, string $status)
    {
        return $this->loanRepository->updateStatus($id, $loanDetailsId, $status);
    }

    public function delete(int|string $id)
    {
        return $this->loanRepository->delete($id);
    }


    public function buildCuotas(int $number, float $amount, string $type, string $dateInit): array
    {

        $arrayCuotas = [];
        $porcentage = 10;

        if ($number > 1 && $amount > 100) {
            $porcentage = 20;
        }
        $amount = $amount + ($amount * $porcentage / 100);
        $cuotaAmount = $amount / $number;

        $cuotaAmount = round($cuotaAmount, 2);

        foreach (range(1, $number) as $index) {

            $cuotaDate = match ($type) {
                'semanal' => \Carbon\Carbon::parse($dateInit)->addWeeks($index - 1)->toDateString(),
                'mensual' => \Carbon\Carbon::parse($dateInit)->addMonths($index - 1)->toDateString(),
                default   => throw new \InvalidArgumentException("Tipo de cuota inválido: {$type}"),
            };
            $cuota = [
                'description' => "Cuota {$index}",
                'amount' => $cuotaAmount,
                'type' => 'cuota',
                'date' => $cuotaDate,
            ];

            $arrayCuotas[] = $cuota;
        }
        return $arrayCuotas;
    }
    public function calculatePrestamoAmount(array $details): float
    {
        $totalAmount = 0.0;
        foreach ($details as $detail) {

            if ($detail['type'] == 'prestamo') {
                $totalAmount += $detail['amount'];
            } elseif ($detail['type'] == 'adelanto') {
                $totalAmount -= $detail['amount'];
            } else {
                $totalAmount += 0;
            }
        }
        return number_format((float) $totalAmount, 2, '.', '');
    }
}
