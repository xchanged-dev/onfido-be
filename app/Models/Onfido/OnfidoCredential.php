<?php

namespace App\Models\Onfido;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnfidoCredential extends Model
{
    use HasFactory;

    protected $fillable = ['applicant', 'workflow', 'sdk_token'];
}
