<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Traits\QueryScopes;

class GalleryCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'parent_id',
        'lft',
        'rgt',
        'level',
        'image',
        'icon',
        'album',
        'publish',
        'follow',
        'order',
        'user_id',
    ];

    protected $table = 'gallery_catalogues';

    public function languages(){
        return $this->belongsToMany(Language::class, 'gallery_catalogue_language' , 'gallery_catalogue_id', 'language_id')
        ->withPivot(
            'gallery_catalogue_id',
            'language_id',
            'name',
            'canonical',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'description',
            'content'
        )->withTimestamps();
    }

    public function gallerys(){
        return $this->belongsToMany(Gallery::class, 'gallery_catalogue_gallery' , 'gallery_catalogue_id', 'gallery_id');
    }


    public function gallery_catalogue_language(){
        return $this->hasMany(GalleryCatalogueLanguage::class, 'gallery_catalogue_id', 'id');
    }

    public static function isNodeCheck($id = 0){
        $galleryCatalogue = GalleryCatalogue::find($id);

        if($galleryCatalogue->rgt - $galleryCatalogue->lft !== 1){
            return false;
        } 
        return true;
    }
}
