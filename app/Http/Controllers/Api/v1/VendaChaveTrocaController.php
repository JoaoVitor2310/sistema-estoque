<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Venda_chave_troca;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Tipo_formato;
use App\Models\Tipo_leilao;
use App\Models\Tipo_reclamacao;

class VendaChaveTrocaController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tipo_leilao::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "chaveRecebida" => "required",
            "nomeJogo" => "required",
            "precoJogo" => "required",
            // "notaMetacritic" => "required",
            // "isSteam" => "required",
            // "plataforma" => "required",
            "precoCliente" => "required",
            // "chaveEntregue" => "required",
            "valorPagoTotal" => "required",
            "quantidade" => "required",
            "dataAdquirida" => "required",
            "perfilOrigem" => "required",
            "email" => "required",
        ]);

        if($validator->fails()){
            return $this->error(422, 'Data invalid', $validator->errors());
            // return response()->json($validator->errors(), 422);
        }
        
        $created = Venda_chave_troca::create($validator->validated());
        
        if(!$created){
            return $this->error(400, 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
