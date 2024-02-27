<?php

namespace App\Http\Controllers;

use App\Models\Statut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeFirst(Request $request)
    {
        // Récupérons l'identifiant de la personne connectée
        $id = Auth::user()->id;

        // Générons un identifiant unique pour chaque post
        $uuid = uniqid("statut-uuid-", true);

        if(isset($request->contenu))
        {
                try {
                    Statut::create(
                        [
                            "user_id" => $id,
                            "uuid" => $uuid,
                            "bgc" => $request->select,
                            "body" => $request->contenu !== null ? nl2br($request->contenu) : null,
                        ]
                    );
                } catch (\Throwable $th) {
                    return json_encode(["error" => "Une erreur est survenue lors de l'opération !"]);
                }
        }
        return json_encode(["success" => "Suppression réussie"]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Récupérons l'identifiant de la personne connectée
        $id = Auth::user()->id;

        // Générons un identifiant unique pour chaque post
        $uuid = uniqid("post-uuid-", true);

        if(isset($request->tableau) && count($request->tableau) > 0)
        {
            foreach($request->tableau as $key => $value)
            {
                try {
                    Statut::create(
                        [
                            "user_id" => $id,
                            "uuid" => $uuid,
                            "body" => $value["contenu"] !== null ? nl2br($value["contenu"]) : null,
                            "image" => $value["image"] ?? null,
                            "video" => $value["video"] ?? null,
                        ]
                    );
                } catch (\Throwable $th) {
                    return json_encode(["error" => "Une erreur est survenue lors de l'opération !"]);
                }
            }
        }
        return json_encode(["success" => "Suppression réussie"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Statut $statut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statut $statut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Statut $statut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Statut $statut)
    {
        //
    }
}
