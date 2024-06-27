<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendaChaveTroca extends Model
{
    use HasFactory;
    protected $fillable;

    const RECLAMACAO_VALUES = ['Dup', 'Revo', 'Reg'];

    public function setReclamacaoAttribute($value)
    {
        if (!in_array($value, self::RECLAMACAO_VALUES) && $value !== '') {
            throw new \InvalidArgumentException("Invalid value for reclamacao: $value");
        }

        $this->attributes['reclamacao'] = $value;
    }
    
}
