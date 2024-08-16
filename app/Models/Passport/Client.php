<?php

namespace App\Models\Passport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Client as BaseClient;

class Client extends BaseClient
{
    use HasFactory;

    //override para não aparecer tela de confirmação de client
    public function skipsAuthorization(){
        return true;
    }
}
