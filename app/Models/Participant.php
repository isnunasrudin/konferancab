<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use HasFactory, SoftDeletes;
    public $guarded = ['id'];

    public function getDelegasi()
    {
        return strtoupper("$this->delegasi_type $this->banom ")." $this->delegasi";
    }

    public function qrStr()
    {
        return hash('sha512', "$this->name_|$this->id|$this->phone");
    }

    public function firstName() : Attribute
    {
        return Attribute::make(fn($val, $attr) => explode(' ', $attr['name'], 2)[0]);
    }
}
