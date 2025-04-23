<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coffeeshop;
use App\Models\Style;

class StyleController extends Controller
{
    public function index()
    {
        $styles = Style::all();
        return view('frontend.styles', compact('styles'));

    }

    public function show($id)
    {
        $style = Style::findOrFail($id);
        $coffeeshops = Coffeeshop::where('styles_id', $id)->with('address')->get();
        return view('frontend.styles', compact('style', 'coffeeshops'));
    }
}
