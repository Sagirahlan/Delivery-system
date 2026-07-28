<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the About page.
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Display the Pricing page.
     */
    public function pricing()
    {
        return view('pages.pricing');
    }

    /**
     * Display the Support & FAQ page.
     */
    public function support()
    {
        return view('pages.support');
    }
}
