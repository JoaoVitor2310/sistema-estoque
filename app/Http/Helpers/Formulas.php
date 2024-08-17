<?php 

namespace App\Http\Helpers;
use App\Models\Ranges_taxa_G2A;
use App\Models\Recursos;

class Formulas 
{
    // public function calcValorVenda(){}
    
    public function calcPrecoVenda($formato, $plataforma, $precoCliente) {
        // Faixas de valores e descontos da tabela G2A
        $faixas = [
            [0, 0.99, 0.23],
            [1, 2.99, 0.3],
            [3.99, 4.99, 0.2775],
            [6.99, 7, 0.255],
            [7.99, 8.99, 0.243],
            [9, 10.49, 0.2315],
            [10.5, 10.99, 0.2085],
            [11, 11.99, 0.197],
            [12.99, 13.99, 0.185],
            [14, 14.99, 0.174],
            [15, 15.99, 0.162],
            [16, 17.49, 0.156],
            [17.99, 19.99, 0.145],
            [20, 21.99, 0.139],
            [22, 22.99, 0.133],
            [23, 23.99, 0.116],
            [25.99, 49.5, 0.11],
            [49.5, PHP_INT_MAX, 0.0405]
        ];
    
        // Verifica se o formato é "T"
        if ($formato === "T") {
            return $precoCliente;
        }
    
        // Verifica se a plataforma é "Gamivo" ou "Kinguin"
        if ($plataforma === "Gamivo" || $plataforma === "Kinguin") {
            return $precoCliente;
        }
    
        // Verifica a faixa de preço e aplica o desconto correspondente
        foreach ($faixas as $faixa) {
            list($min, $max, $desconto) = $faixa;
        if ($precoCliente >= $min && $precoCliente <= $max) {
            // Usando bcdiv para maior precisão
            return bcdiv($precoCliente, (1 + $desconto), 2);
        }
        }
    
        // Retorna o preço original se não encontrar uma faixa correspondente
        return $precoCliente;
    }

    function calcularPrecoVenda($formato, $plataforma, $precoCliente) {
        // Verifica se o formato é "T"
        if ($formato === "T") {
            return $precoCliente;
        }
    
        // Verifica se a plataforma é "Gamivo" ou "Kinguin"
        if ($plataforma === "Gamivo" || $plataforma === "Kinguin") {
            return $precoCliente;
        }
    
        // Busca todas as faixas de preços e taxas da tabela ranges_taxa_g2a
        $faixas = Ranges_taxa_G2A::all();
    
        // Itera sobre as faixas para encontrar a correspondente ao preço do cliente
        foreach ($faixas as $faixa) {
            if ($precoCliente >= $faixa->min && $precoCliente <= $faixa->max) {
                return $precoCliente / (1 + $faixa->taxa);
            }
        }
    
        // Retorna o preço original se não encontrar uma faixa correspondente
        return $precoCliente;
    }



    public function calcIncomeReal($formato, $plataforma, $precoCliente, $precoVenda, $leiloes, $quantidade) {
        $resultado = 0;
    
        if ($formato == "T") {
            $resultado = $precoCliente;
        } else if ($plataforma == "G2A") {
            $resultado = $precoVenda * 0.898 - 0.4 - (0.15 * $leiloes / $quantidade);
        } else if ($plataforma == "Gamivo") {
            if ($precoCliente < 4) {
                $resultado = ($precoCliente * 0.95) - 0.1;
            } else {
                $resultado = ($precoCliente * 0.921) - 0.35;
            }
        } else if ($plataforma == "Kinguin") {
            $resultado = ($precoCliente * 0.8771929) - 0.306;
        } else {
            $resultado = ""; // Valor padrão caso nenhuma condição seja atendida
        }
    
        return $resultado;
    } 

    public function calcIncomeSimulado($formato, $plataforma, $precoCliente, $precoVenda) {
        $resultado = 0;
    
        if ($formato == "T") {
            $resultado = $precoCliente;
        } else if ($plataforma == "gamivo") {
            if ($precoCliente > 4) {
                $resultado = $precoVenda + (-0.079 * $precoVenda) - 0.35;
            } else {
                $resultado = $precoVenda - (0.05 * $precoVenda) - 0.1;
            }
        } else if ($plataforma == "G2A") {
            $resultado = $precoVenda * 0.898 - 0.55;
        } else { // Kinguin?
            $resultado = $precoVenda + (-0.1228071 * $precoVenda) - 0.306;
        }
    
        return $resultado;
    }

    public function calcValorPagoIndividual($qtdTF2, $somatorioIncomes, $primeiroIncome){
        $recursoModel = new Recursos();

        $valorChaveEUR = $recursoModel->select('*')->where('nome', 'TF2')->first()['precoEUR'];
        return $qtdTF2 * $valorChaveEUR / $somatorioIncomes * $primeiroIncome;
        // return $valorChaveEUR;
    }
    public function calcLucroReal($vendido, $quantidade, $leiloes, $precoCliente, $valorPagoIndividual, $devolucoes){
        return $precoCliente * $vendido * 0.892 - (1.33 * $vendido + (0.57 / $quantidade) * $leiloes) - $valorPagoIndividual - $precoCliente * $devolucoes;
    }
    public function calcLucroPercentual($lucroRS, $valorPagoIndividual){
        return  $lucroRS /$valorPagoIndividual;
    }
    public function classificacaoRandomG2A($precoJogo, $nota){
        if ($precoJogo >= 39.99 && $nota >= 80) {
            return "VIP";
        } elseif ($precoJogo >= 29.99 && $nota >= 80) {
            return "Diamond";
        } elseif ($precoJogo >= 24.99 && $nota >= 70) {
            return "Elite";
        } elseif ($precoJogo >= 19.99 && $nota >= 80) {
            return "Legendary";
        } elseif ($precoJogo >= 10 && $nota >= 70) {
            return "Gold";
        } elseif ($precoJogo >= 8 && $nota >= 75) {
            return "Premium";
        } elseif ($precoJogo < 8 && $precoJogo != 0) {
            return "Random";
        } elseif ($nota < 70 && $nota != 0) {
            return "Random";
        } else {
            return "";
        }
    }

    public function classificacaoRandomKinguin($precoJogo, $nota){
        if (empty($precoJogo) || empty($nota)) {
            return "";
        } elseif ($precoJogo >= 16.99 && $nota >= 80) {
            return "Deluxe";
        } elseif ($precoJogo >= 11.99 && $nota >= 75) {
            return "Gold";
        } elseif ($precoJogo >= 8.99 && $nota >= 70) {
            return "Premium";
        } elseif ($precoJogo >= 2.99 && $nota >= 50) {
            return "Random";
        } else {
            return "Não Se Enquadra";
        }
    }
}
