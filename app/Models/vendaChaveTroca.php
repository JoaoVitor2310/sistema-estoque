<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda_chave_troca extends Model
{
    use HasFactory;
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

    const RECLAMACAO_VALUES = ['Dup', 'Revo', 'Reg'];

    public function setReclamacaoAttribute($value)
    {
        if (!in_array($value, self::RECLAMACAO_VALUES) && $value !== '') {
            throw new \InvalidArgumentException("Invalid value for reclamacao: $value");
        }

        $this->attributes['reclamacao'] = $value;
    }

}
