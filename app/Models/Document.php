<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'document';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['lines'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function type()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function lines()
    {
        return $this->hasMany(DocumentLine::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getLabelAttribute()
    {
        return $this->type->label . ' #' . $this->number;
    }

    public function getLinesAttribute()
    {
        $documentLines = DocumentLine::where('document_id', $this->id)->get();
        return $documentLines;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    // TODO Manage deleted lines
    // TODO Manage new document, ( $this->id is null )
    public function setLinesAttribute($value)
    {
        $lines = json_decode($value);
        foreach ($lines as $line) {
            $documentLine = null;
            if ($line->id != null) {
                $documentLine = DocumentLine::where('id', $line->id)->where('document_id', $this->id)->first();
            }
            if ($documentLine == null) {
                $documentLine = new DocumentLine();
            }
            $documentLine->document_id = $this->id;
            $documentLine->label = $line->label;
            $documentLine->price = $line->price;
            $documentLine->save();
        }
//        dd($lines);
    }

}
