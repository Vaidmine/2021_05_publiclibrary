<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if('name' == $request->sort) {
            $authors = Author::orderBy('name')->get();
        } 
        elseif ('surname' ==$request->sort){
            $authors = Author::orderBy('surname')->get();
        }
        else {
            $authors = Author::all();
        }


        // $authors = $request->sort ? Author::orderBy('surname')->get() : Author::all();
        // $authors = Author::all(); 
        // $authors = Author::orderBy('surname')->get();

        return view('author.index', ['authors' => $authors]);
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('author.create');
          dd($file);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'author_name' =>['required', 'min:3', 'max:64'],
                'author_surname' =>['required', 'min:3', 'max:64'],

            ],
            [
                
                'author_name.required' => 'Name is missing!',
                'author_name.min' => 'Name is too short!',
                // 'author_name.regex' => 'Name should contain letters!',
                'author_surname.required' => 'Surname is missing!',
                'author_surname.min' => 'Surname is too short!',
                // 'author_surname.regex' => 'Surname should contain letters!',
            ]

            );
            if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }
     

        $author = new Author;
        $author->name = $request->author_name;
        $author->surname = $request->author_surname;
        $author->save();
        return redirect()->route('author.index')->with('success_message', 'The Author was created. Nice nice nice!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        return view('author.edit', ['author' => $author]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {


        $validator = Validator::make($request->all(),
            [
                'author_name' =>['required', 'min:3', 'max:64'],
                'author_surname' =>['required', 'min:3', 'max:64'],

            ],
            [
                
                'author_name.required' => 'Name is missing!',
                'author_name.min' => 'Name is too short!',
                // 'author_name.regex' => 'Name should contain letters!',
                'author_surname.required' => 'Surname is missing!',
                'author_surname.min' => 'Surname is too short!',
                // 'author_surname.regex' => 'Surname should contain letters!',
            ]

            );
            if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }
     
        //paveiksliuko ikelimas
        $file = $request->file('author_portret');
        // dd($file);
        $name = $file->getClientOriginalName(); //originalus vardas
        $name = rand(10000, 999999).'.'.$file->getClientOriginalName(); //suteikiamas random vardas
        $file->move(public_path('img'), $name); // perkeliamas is tmp i ten kur reikia
        $author -> portret = 'http://localhost/2021_03_bibl/biblioteka/public/img/'.$name; // perrasom i DB



        $author->name = $request->author_name;
        $author->surname = $request->author_surname;
        $author->save();
        return redirect()->route('author.index')->with('success_message', 'The Author was renamed. Nice nice nice!');
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */

    // public function destroy(Author $author)
    // {

    //     if($author->authorBooksList->count()!== 0){
    //         return redirect()->back()->with('author.index')->
    //         with('success_message', 'The Author is immortal! You can not delete...');
    //     }
    //     $author->delete();
    //     return redirect()->route('author.index')->
    //     with('success_message', 'The Author was deleted. How sad!');
 
 
    // }

    public function destroy(Author $author)
    {
        if ($author->authorBooksList->count() !== 0) {
            return redirect()->back()->with('info_message', 'The Author is immortal. You cant kill him. Nice try!');
        }
        $addedLink = 'http://bi.com/img/'; // pridetas linkas
        $imgName = str_replace($addedLink, '', $author->portret); // prideta linka istrinam 
        if (file_exists(public_path('img').'/'.$imgName) && is_file(public_path('img').'/'.$imgName)) {
            unlink(public_path('img').'/'.$imgName); // istrinam
        }
        
        $author->delete();
        return redirect()->route('author.index')->with('info_message', 'The Author was killed. Nice job!');
    }


    
    
}
