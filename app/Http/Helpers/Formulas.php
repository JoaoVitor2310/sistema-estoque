<?php 

namespace App\Http\Helpers;
class Formulas 
{
    // public function calcValorVenda(){}
    
    function calcValorVenda($id_formato, $id_plataforma, $precoCliente, $tabelaG2A) {
        if ($id_formato == 7) {
            return $precoCliente;
        }
    
        if ($id_plataforma == 3 || $id_plataforma == 4) { // Gamivo ou Kinguin
            return $precoCliente;
        }
    
        if ($precoCliente <= $tabelaG2A['A2']) {
            return $precoCliente;
        }
    
        if ($precoCliente >= $tabelaG2A['A2'] && $precoCliente <= $tabelaG2A['B2']) {
            return $precoCliente / (1 + $tabelaG2A['A3']);
        }
    
        if ($precoCliente >= $tabelaG2A['C2'] && $precoCliente <= $tabelaG2A['D2']) {
            return $precoCliente / (1 + $tabelaG2A['C3']);
        }
    
        if ($precoCliente >= $tabelaG2A['E2'] && $precoCliente <= $tabelaG2A['F2']) {
            return $precoCliente / (1 + $tabelaG2A['E3']);
        }
    
        if ($precoCliente >= $tabelaG2A['G2'] && $precoCliente <= $tabelaG2A['H2']) {
            return $precoCliente / (1 + $tabelaG2A['G3']);
        }
    
        if ($precoCliente >= $tabelaG2A['I2'] && $precoCliente <= $tabelaG2A['J2']) {
            return $precoCliente / (1 + $tabelaG2A['I3']);
        }
    
        if ($precoCliente >= $tabelaG2A['A4'] && $precoCliente <= $tabelaG2A['B4']) {
            return $precoCliente / (1 + $tabelaG2A['A5']);
        }
    
        if ($precoCliente >= $tabelaG2A['C4'] && $precoCliente <= $tabelaG2A['D4']) {
            return $precoCliente / (1 + $tabelaG2A['C5']);
        }
    
        if ($precoCliente >= $tabelaG2A['E4'] && $precoCliente <= $tabelaG2A['F4']) {
            return $precoCliente / (1 + $tabelaG2A['E5']);
        }
    
        if ($precoCliente >= $tabelaG2A['G4'] && $precoCliente <= $tabelaG2A['H4']) {
            return $precoCliente / (1 + $tabelaG2A['G5']);
        }
    
        if ($precoCliente >= $tabelaG2A['I4'] && $precoCliente <= $tabelaG2A['J4']) {
            return $precoCliente / (1 + $tabelaG2A['I5']);
        }
    
        if ($precoCliente >= $tabelaG2A['A6'] && $precoCliente <= $tabelaG2A['B6']) {
            return $precoCliente / (1 + $tabelaG2A['A7']);
        }
    
        if ($precoCliente >= $tabelaG2A['C6'] && $precoCliente <= $tabelaG2A['D6']) {
            return $precoCliente / (1 + $tabelaG2A['C7']);
        }
    
        if ($precoCliente >= $tabelaG2A['E6'] && $precoCliente <= $tabelaG2A['F6']) {
            return $precoCliente / (1 + $tabelaG2A['E7']);
        }
    
        if ($precoCliente >= $tabelaG2A['G6'] && $precoCliente <= $tabelaG2A['H6']) {
            return $precoCliente / (1 + $tabelaG2A['G7']);
        }
    
        if ($precoCliente >= $tabelaG2A['I6'] && $precoCliente <= $tabelaG2A['J6']) {
            return $precoCliente / (1 + $tabelaG2A['I7']);
        }
    
        if ($precoCliente >= $tabelaG2A['A8'] && $precoCliente <= $tabelaG2A['B8']) {
            return $precoCliente / (1 + $tabelaG2A['B9']);
        }
    
        if ($precoCliente >= $tabelaG2A['C8'] && $precoCliente <= $tabelaG2A['D8']) {
            return $precoCliente / (1 + $tabelaG2A['C9']);
        }
    
        if ($precoCliente >= $tabelaG2A['E8'] && $precoCliente <= $tabelaG2A['F8']) {
            return $precoCliente / (1 + $tabelaG2A['E9']);
        }
    
        if ($precoCliente >= $tabelaG2A['G8'] && $precoCliente <= $tabelaG2A['H8']) {
            return $precoCliente / (1 + $tabelaG2A['G9']);
        }
    
        if ($precoCliente >= $tabelaG2A['I8'] && $precoCliente <= $tabelaG2A['J8']) {
            return $precoCliente / (1 + $tabelaG2A['I9']);
        }
    
        if ($precoCliente >= $tabelaG2A['A10']) {
            return $precoCliente / (1 + $tabelaG2A['A11']);
        }
    
        return null;
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

    public function calcValorPagoIndividual(){}
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
