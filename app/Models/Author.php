<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Author extends Model
{
    use HasFactory;

    // public static function create(Request $request)
    // {
    //     $author = new self;
    //     $author->name = $request->author_name;
    //     $author->surname = $request->author_surname;
    //     $author->save();
    // }


    public function authorBooksList()
    {
        return $this->hasMany('App\Models\Book', 'author_id', 'id');
    }


    // public function edit(Request $request)
    // {
    //     $this->name = $request->author_name;
    //     $this->surname = $request->author_surname;
    //     $this->save();
    // }


    public static function new()
    {
        return new self;
    }


    public function refreshAndSave(Request $request)
    {
        
        // $file = $request->file('author_portret');
        // // dd($file);

        // $name = $file->getClientOriginalName(); //originalus vardas

        // $name = rand(10000, 999999).'.'.$file->getgetClientOriginalName(); //suteikiamas random vardas

        // $file->move(public_path('img'), $name); // perkiams is tmp i ten kur reikia
        // $this->portret = 'http://localhost/2021_03_bibl/biblioteka/public/img/'.$name; // perrasom i DB
 
  
        
        
        
        $this->name = $request->author_name;
        $this->surname = $request->author_surname;
        $this->save();
        return $this;
    }




}