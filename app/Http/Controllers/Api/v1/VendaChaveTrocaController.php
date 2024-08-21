<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Tipo_formato;
use App\Models\Tipo_leilao;
use App\Models\Tipo_reclamacao;
use App\Models\Venda_chave_troca;
use App\Models\Fornecedor;

use App\Http\Helpers\Formulas;

// C:\Users\João Vitor Gouveia\Documents\Programacao\Repositorios\Bestbuy86\sistema-estoque\app\Http\Helpers\Formulas.php
class VendaChaveTrocaController extends Controller
{
    use HttpResponses;

    protected $formulas;
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->formulas = new Formulas();
    }

    public function index(Request $request)
    {
        // Recebe os parâmetros 'limit' e 'offset' da requisição
        $limit = $request->query('limit', 10);  // Valor padrão de 10
        $offset = $request->query('offset', 0);  // Valor padrão de 0

        // Busca os registros utilizando limit e offset
        $jogos = Venda_chave_troca::limit($limit)->offset($offset)->get();

        is_object($jogos) ? $jogos = $jogos->toArray() : $jogos; // Garante que sempre será um array, mesmo que tenha só um jogo

        return $this->response(200, 'Jogos encontrados com sucesso.', $jogos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            "email" => "email",
            "qtdTF2" => "nullable", // A partir daqui é para teste
            "somatorioIncomes" => "nullable",
            "primeiroIncome" => "nullable",
        ]);

        if ($validator->fails()) {
            return $this->error(422, 'Dados inválidos', $validator->errors());
        }

        $data = $validator->getData();

        // Identificar o vendedor e adicionar +1 para ele
        // $fornecedor = Fornecedor::select('*')->where('perfilOrigem', $data['perfilOrigem'])->first();

        // if (!$fornecedor) { // Se não tiver o fornecedor, cria ele
        //     $newFornecedor['perfilOrigem'] = $data['perfilOrigem'];
        //     if ($data['reclamacao'] == true)
        //         $newFornecedor['quantidade_reclamacoes'] = 1; // Se tiver reclamação, adiciona +1
        //     $fornecedor = Fornecedor::create($newFornecedor);
        //     // return $this->error(400, $fornecedor);
        // } else {
        //     // Existe o fornecedor, irá somar mais uma reclamação só se tiver mandado reclamação
        //     if ($data['reclamacao'] == true) {
        //         $fornecedor->where('perfilOrigem', $data['perfilOrigem'])->update(['quantidade_reclamacoes' => $fornecedor->quantidade_reclamacoes + 1]);
        //         // $fornecedor['quantidade_reclamacoes'] = $fornecedor->quantidade_reclamacoes;
        //     }
        // }

        // $data['id_fornecedor'] = $fornecedor->id;
        $data['id_fornecedor'] = $this->criarAdicionarFornecedor($data['perfilOrigem'], $data['reclamacao']);


        // Calcula as fórmulas
        // Checar reclamação vendedores
        $data = $this->calculateFormulas($data);
        
        // return $this->response(201, 'Jogo cadastrado com sucesso', [$data]);



        // $lucroPercentual = $this->formulas->calcLucroPercentual();


        try {
            $created = Venda_chave_troca::create($data);
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
        $jogo = Venda_chave_troca::select('*')->where('id', $id)->first();
        if (!$jogo)
            return $this->error(404, 'Jogo não encontrado');

        $validator = \Validator::make($request->all(), [
            "reclamacao" => "boolean",
            "tipo_reclamacao_id" => "integer|min:1|max:4",
            "steamId" => "string",
            "tipo_formato_id" => "integer|min:1|max:7",
            "chaveRecebida" => "string", // identificar a plataforma depois
            "nomeJogo" => "string",
            "precoJogo" => "decimal:0,2",
            "notaMetacritic" => "integer|min:0|max:100",
            "isSteam" => "boolean",
            // "randomClassificationG2A" => "boolean",
            "observacao" => ["string", "nullable"],
            "id_leilao_G2A" => "integer|min:1|max:4",
            "id_leilao_gamivo" => "integer|min:1|max:4",
            "id_leilao_kinguin" => "integer|min:1|max:4",
            "id_plataforma" => "integer|min:1|max:5",
            "precoCliente" => "decimal:0,2",
            // "precoVenda" =>  "decimal:0,2",
            // "incomeReal" =>  "decimal:0,2",
            // "incomeSimulado" =>  "decimal:0,2",
            "chaveEntregue" => ["string", "nullable"],
            "valorPagoTotal" => "decimal:0,2",
            "valorPagoIndividual" => "decimal:0,2",
            "quantidade" => "integer",
            "devolucoes" => "boolean",
            // "lucroRS" => "decimal:0,2",
            // "lucro%" => "decimal:0,2",
            "dataAdquirida" => "date",
            "dataVenda" => "date",
            "dataVendida" => "date",
            "perfilOrigem" => "string",
            "email" => "email",
        ]);

        if ($validator->fails()) {
            return $this->error(422, 'Dados inválidos', $validator->errors());
        }

        $data = $validator->validated();

        // $data['perfilOrigem'] == $jogo
        $fornecedorCadastrado = Fornecedor::select('*')->where('perfilOrigem', $jogo['perfilOrigem'])->first();

        $fornecedorEnviado = Fornecedor::select('*')->where('perfilOrigem', $data['perfilOrigem'])->first();
        if (!$fornecedorEnviado) { // Se não existe o forncedor enviado, cria
            $data['id_fornecedor'] = $this->criarAdicionarFornecedor($data['perfilOrigem'], $data['reclamacao']);
            // Diminui uma reclamação do fornecedor cadastrado

            $fornecedorCadastrado->where('perfilOrigem', $jogo['perfilOrigem'])->update(['quantidade_reclamacoes' => $fornecedorCadastrado->quantidade_reclamacoes - 1]);
        } else {
            // Comparar pra ver se é o mesmo fornecedor

            if ($fornecedorEnviado['id'] != $fornecedorCadastrado['id']) {
                // Diminuir uma reclamação do fornedor cadastrado e adicionar para o enviado
                $fornecedorCadastrado->where('id', $fornecedorCadastrado['id'])->update(['quantidade_reclamacoes' => $fornecedorCadastrado->quantidade_reclamacoes - 1]);
                $fornecedorEnviado->where('id', $fornecedorEnviado['id'])->update(['quantidade_reclamacoes' => $fornecedorEnviado->quantidade_reclamacoes + 1]);
            }
            // Se for o mesmo, não faz nada
            $data['id_fornecedor'] = $fornecedorEnviado['id'];
        }

        unset($data['reclamacao']);

        // Calcula as fórmulas?
        // Checar reclamação vendedores
        $data = $this->calculateFormulas($data);



        $result = Venda_chave_troca::where('id', $id)->update($data);

        if (!$result)
            return $this->error(500, 'Erro interno ao atualizar jogo');


        return $this->response(200, 'Jogo atualizado com sucesso', $data);

        // Identificar o vendedor
        // $fornecedor = Fornecedor::select('*')->where('perfilOrigem', $data['perfilOrigem'])->first();

        // if (!$fornecedor) {
        //     return $this->error(404, 'Fornecedor não encontrado');
        // }

        // // Existe o fornecedor, irá somar mais uma reclamação só se tiver mandado reclamação
        // if ($data['reclamacao'] == true) {
        //     $fornecedor->where('perfilOrigem', $data['perfilOrigem'])->update(['quantidade_reclamacoes' => $fornecedor->quantidade_reclamacoes + 1]);
        // }

        // $data['id_fornecedor'] = $fornecedor->id;
        $data['id_fornecedor'] = $this->criarAdicionarFornecedor($data['perfilOrigem'], $data['reclamacao']);








        return $this->response(200, 'Jogo atualizado com sucesso', $game);

        // return $this->response(200, 'Jogo atualizado com sucesso');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jogo = Venda_chave_troca::select('*')->where('id', $id)->first();
        if (!$jogo)
            return $this->error(404, 'Jogo não encontrado');


        $result = Venda_chave_troca::where('id', $id)->delete();
        if (!$result)
            return $this->error(500, 'Erro interno ao deletar jogo');

        return $this->response(200, 'Jogo deletado com sucesso', $jogo);
    }

    // Funções auxiliares

    private function criarAdicionarFornecedor($perfilOrigem, $reclamacao)
    {
        $fornecedor = Fornecedor::select('*')->where('perfilOrigem', $perfilOrigem)->first();

        if (!$fornecedor) { // Se não tiver o fornecedor, cria ele
            $newFornecedor['perfilOrigem'] = $perfilOrigem;
            if ($reclamacao == true)
                $newFornecedor['quantidade_reclamacoes'] = 1; // Se tiver reclamação, adiciona +1
            $fornecedor = Fornecedor::create($newFornecedor);
            // return $this->error(400, $fornecedor);
        } else {
            // Existe o fornecedor, irá somar mais uma reclamação só se tiver mandado reclamação
            if ($reclamacao == true) {
                $fornecedor->where('perfilOrigem', $perfilOrigem)->update(['quantidade_reclamacoes' => $fornecedor->quantidade_reclamacoes + 1]);
                // $fornecedor['quantidade_reclamacoes'] = $fornecedor->quantidade_reclamacoes;
            }
        }

        return $fornecedor->id;
    }

    private function calculateFormulas($data){
        $data['precoVenda'] = $this->formulas->calcPrecoVenda($data['tipo_formato_id'], $data['id_plataforma'], $data['precoCliente']); // FEITO

        $data['incomeReal'] = $this->formulas->calcIncomeReal($data['tipo_formato_id'], $data['id_plataforma'], $data['precoCliente'], $data['precoVenda'], $data['leiloes'], $data['quantidade']); // FEITO
        
        $data['incomeSimulado'] = $this->formulas->calcIncomeSimulado($data['tipo_formato_id'], $data['id_plataforma'], $data['precoCliente'], $data['precoVenda']); // FEITO
        
        $data['valorPagoIndividual'] = $this->formulas->calcValorPagoIndividual($data['qtdTF2'], $data['somatorioIncomes'], $data['primeiroIncome']); // CONFERIR
        
        $data['lucroRS'] =  $this->formulas->calcLucroReal($data['incomeSimulado'], $data['valorPagoIndividual']);
        
        $data['lucroPercentual'] =  $this->formulas->calcLucroPercentual($data['lucroRS'], $data['valorPagoIndividual']);
        
        $data['randomClassificationG2A'] =  $this->formulas->classificacaoRandomG2A($data['precoJogo'], $data['notaMetacritic']);
        
        $data['randomClassificationKinguin'] = $this->formulas->classificacaoRandomKinguin($data['precoJogo'], $data['notaMetacritic']);

        return $data;
    }
}
