<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda_chave_troca extends Model
{
    use HasFactory;

    protected $table = 'venda_chave_trocas';
    protected $fillable = [
        "id",
        "reclamacoesAnteriores",
        "tipo_reclamacao_id",
        "steamId",
        "chaveRecebida",
        "nomeJogo",
        "precoJogo",
        "notaMetacritic",
        "isSteam",
        "randomClassificationG2A",
        "observacao",
        "id_leilao_G2A",
        "id_leilao_gamivo",
        "id_leilao_kinguin",
        "plataforma",
        "precoCliente",
        "precoVenda",
        "incomeReal",
        "incomeSimulado",
        "chaveEntregue",
        "valorPagoTotal",
        "valorPagoIndividual",
        "vendido",
        "leiloes",
        "quantidade",
        "devolucoes",
        "lucroR$",
        "lucro%",
        "dataAdquirida",
        "dataVenda",
        "dataVendida",
        "perfilOrigem",
        "email"
    ];
}
