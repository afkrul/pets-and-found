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
use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class PetController extends Controller
{
    /**
     * Return a list of all pets for a user
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormRequest $request, ListPets $listPets)
    {
        $user = $request->user();
        $fetchedPets = $listPets($user);

        return response()->json($fetchedPets);
    }

    /**
     * Return a specific pet belonging to the user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ShowPetRequest $request, Pet $pet, GetPet $getPet)
    {
        $user = $request->user();
        $fetchedPet = $getPet($user, $pet);

        return response()->json($fetchedPet);
    }

    /**
     * Store a new pet in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StorePetRequest $request, CreatePet $createPet)
    {
        $user = $request->user();
        $petData = $request->validated();
        $pet = $createPet($user, $petData);

        return response()->json($pet, 201); // Created
    }

    /**
     * Update a pet in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePetRequest $request, Pet $pet, UpdatePet $updatePet)
    {
        $petData = $request->validated();
        $updatedPet = $updatePet($pet, $petData);

        return response()->json($updatedPet);
    }

    /**
     * Delete a pet from the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPetRequest $request, Pet $pet, DeletePet $deletePet)
    {
        $user = $request->user();
        $deletePet($user, $pet);

        return response()->json(null, 204); // No Content
    }
}
