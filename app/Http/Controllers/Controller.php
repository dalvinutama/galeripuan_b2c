<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



    protected $data = [];
    protected $perPage = 8;

    public function __construct()
    {
        // Nantinya data umum yang sering dipakai (seperti menu, dll) bisa ditaruh di sini
    }

    protected function loadTheme($view, $data =[] )
    {
        // Mengarahkan tampilan ke folder themes/gallerypuan/
        return view('themes/'. env('APP_THEME', 'default'). '/' . $view, $data);
    }



}
