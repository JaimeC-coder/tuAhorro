<?php

namespace App\Http\Controllers;

use App\DTOs\SavingDTO;
use App\Http\Requests\SavingRequest;
use App\Http\Resources\SavingResource;
use App\Models\Saving;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    protected $savingService;
    public function __construct($savingService)
    {
        $this->savingService = $savingService;
    }
    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        //
        $request = SavingDTO::fromRequest($request);
        $savings = $this->savingService->getAllSavings($request);
        return SavingResource::collection($savings);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request = SavingRequest::fromRequest($request);
        $savingDTO = SavingDTO::fromRequest($request);
        $saving = $this->savingService->create($savingDTO);
        return new SavingResource($saving);
    }

    /**
     * Display the specified resource.
     */
    public function show(Saving $saving)
    {
        //
        $saving = $this->savingService->find($saving->id);
        if (!$saving) {
            return response()->json(['message' => 'Saving not found'], 404);
        }
        return new SavingResource($saving);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Saving $saving)
    {
        //
        $request = SavingRequest::fromRequest($request);
        $savingDTO = SavingDTO::fromRequest($request);
        $saving = $this->savingService->update($saving->id, $savingDTO);
        if (!$saving) {
            return response()->json(['message' => 'Saving not found'], 404);
        }
        return new SavingResource($saving);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saving $saving)
    {
        //
        $saving = $this->savingService->delete($saving->id);
        if (!$saving) {
            return response()->json(['message' => 'Saving not found'], 404);
        }
        return response()->json(['message' => 'Saving deleted successfully'], 200);
    }
}
