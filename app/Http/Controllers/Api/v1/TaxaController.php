<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use App\Models\Taxas;

use Illuminate\Http\Request;
class TaxaController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function showMarketPlaceFees(Request $request)    {
         // Recebe os parâmetros 'limit' e 'offset' da requisição
         $limit = $request->query('limit', 100);  // Valor padrão de 100 para buscar tudo
         $offset = $request->query('offset', 0);  // Valor padrão de 0 para procurar desde o primeiro
 
         // Busca os registros utilizando limit e offset
         $taxas = Taxas::limit($limit)->offset($offset)->get();
 
         is_object($taxas) ? $taxas = $taxas->toArray() : $taxas; // Garante que sempre será um array, mesmo que tenha só um elemento
 
         return $this->response(200, 'Taxas encontrados com sucesso.', $taxas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeMarketPlaceFee(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "reclamacao" => "boolean",
            "tipo_reclamacao_id" => "integer|min:1|max:4",
            "steamId" => "required",
            "tipo_formato_id" => "integer|min:1|max:7",
            "chaveRecebida" => "required", // identificar a plataforma depois
            "nomeJogo" => "required",
            "precoJogo" => ["required", "decimal:0,2"],
            "notaMetacritic" => "integer|min:0|max:100",
        ]);

        if ($validator->fails()) {
            return $this->error(422, 'Dados inválidos', $validator->errors());
        }

        $data = $validator->getData();
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
