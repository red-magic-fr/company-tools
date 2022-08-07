<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentLine extends Model
{
    use HasFactory;

    protected $table = 'document_line';
    public $timestamps = false;

    /*
   |--------------------------------------------------------------------------
   | RELATIONS
   |--------------------------------------------------------------------------
   */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
