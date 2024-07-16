<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Tipo_formato;
use App\Models\Tipo_leilao;
use App\Models\Tipo_reclamacao;
use App\Models\Venda_chave_troca;

use App\Http\Helpers\Formulas;

// C:\Users\João Vitor Gouveia\Documents\Programacao\Repositorios\Bestbuy86\sistema-estoque\app\Http\Helpers\Formulas.php
class VendaChaveTrocaController extends Controller
{
    use HttpResponses;

    protected $formulas;
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        $this->formulas = new Formulas();
    }
    
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
            "reclamacoesAnteriores" => "boolean",
            "tipo_reclamacao_id" => "integer|min:1|max:4",
            "steamId" => "required",
            "tipo_formato_id" => "integer|min:1|max:7",
            "chaveRecebida" => "required", // identificar a plataforma depois
            "nomeJogo" => "required",
            "precoJogo" => ["required", "decimal:0,2"],
            "notaMetacritic" => "integer|min:0|max:100",
            "isSteam" => "boolean",
            "observacao" => ["string", "nullable"],
            "id_leilao_G2A" => "integer|min:1|max:4",
            "id_leilao_gamivo" => "integer|min:1|max:4",
            "id_leilao_kinguin" => "integer|min:1|max:4",
            "id_plataforma" => "integer|min:1|max:5",
            "precoCliente" => ["required", "decimal:0,2"],
            "chaveEntregue" => ["string", "nullable"],
            "valorPagoTotal" => "required",
            "quantidade" => "required",
            "devolucoes" => "boolean",
            "dataAdquirida" => ["required", "date"],
            "perfilOrigem" => ["required", "string"],
            "email" => ["required", "email"],
        ]);
        
        if($validator->fails()){
            return $this->error(422, 'Dados inválidos', $validator->errors());
        }

        // Calcula as fórmulas
        
        // $valorVenda = calcValorVenda($precoCliente);
        
        // $lucroPercentual = $this->formulas->calcLucroPercentual();

        
        try {
            $created = Venda_chave_troca::create($validator->validated());
            if ($created) {
                return $this->response(201, 'Jogo cadastrado com sucesso');
            }
    
            return $this->error(400, 'Something went wrong!');
        } catch (\Exception $e) {
            // Log the error
            \Log::error($e);
    
            // Return a JSON response with the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
        
        
        
        
        // return response()->json($validator->validated(), 200);

        // $created = Venda_chave_troca::create($validator->validated());
        
        // if($created){
        //     return $this->response(201, 'Jogo cadastrado com sucesso');
        // }

        return $this->error(400, 'Something went wrong!');
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
        $validator = \Validator::make($request->all(), [
            "reclamacoesAnteriores" => "boolean",
            "tipo_reclamacao_id" => "integer|min:1|max:4",
            "steamId" => "string",
            "tipo_formato_id" => "integer|min:1|max:7",
            "chaveRecebida" => "string", // identificar a plataforma depois
            "nomeJogo" => "string",
            "precoJogo" =>  "decimal:0,2",
            "notaMetacritic" => "integer|min:0|max:100",
            "isSteam" => "boolean",
            "randomClassificationG2A" => "boolean",
            "observacao" => ["string", "nullable"],
            "id_leilao_G2A" => "integer|min:1|max:4",
            "id_leilao_gamivo" => "integer|min:1|max:4",
            "id_leilao_kinguin" => "integer|min:1|max:4",
            "id_plataforma" => "integer|min:1|max:5",
            "precoCliente" =>  "decimal:0,2",
            "precoVenda" =>  "decimal:0,2",
            "incomeReal" =>  "decimal:0,2",
            "incomeSimulado" =>  "decimal:0,2",
            "chaveEntregue" => ["string", "nullable"],
            "valorPagoTotal" => "decimal:0,2",
            "valorPagoIndividual" => "string",
            "quantidade" => "integer",
            "devolucoes" => "boolean",
            "lucroR$" => "decimal:0,2",
            "lucro%" => "decimal:0,2",
            "dataAdquirida" => "date",
            "dataVenda" => "date",
            "dataVendida" => "date",
            "perfilOrigem" => "string",
            "email" => "email",
        ]);
        
        if($validator->fails()){
            return $this->error(422, 'Dados inválidos', $validator->errors());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
