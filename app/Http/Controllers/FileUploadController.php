<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function create()
    {
        return view('file-upload');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
