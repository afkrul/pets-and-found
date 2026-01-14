<?php

namespace App\Http\Controllers;

use App\Actions\Pets\CreatePet;
use App\Actions\Pets\DeletePet;
use App\Actions\Pets\GetPet;
use App\Actions\Pets\ListPets;
use App\Actions\Pets\UpdatePet;
use App\Http\Requests\Pets\DestroyPetRequest;
use App\Http\Requests\Pets\ShowPetRequest;
use App\Http\Requests\Pets\StorePetRequest;
use App\Http\Requests\Pets\UpdatePetRequest;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Return a list of all pets for a user
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ListPets $list)
    {
        $fetchedPets = ($list)($request->user());

        return PetResource::collection($fetchedPets);
    }

    /**
     * Return a specific pet belonging to the user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ShowPetRequest $request, Pet $pet, GetPet $get)
    {
        $fetchedPet = $get($request->user(), $pet);

        return new PetResource($fetchedPet);
    }

    /**
     * Store a new pet in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StorePetRequest $request, CreatePet $create)
    {
        $pet = $create($request->user(), $request->dto());

        return new PetResource($pet);
    }

    /**
     * Update a pet in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePetRequest $request, Pet $pet, UpdatePet $update)
    {
        $updatedPet = $update($pet, $request->dto());

        return new PetResource($updatedPet);
    }

    /**
     * Delete a pet from the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPetRequest $request, Pet $pet, DeletePet $delete)
    {
        $delete($request->user(), $pet);

        return response()->noContent();
    }
}
