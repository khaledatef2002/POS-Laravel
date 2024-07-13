<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $numOfCategories = Category::count();
        $numOfProducts = Product::count();
        $numOfClients = Client::count();
        $numOfUsers = User::count();

        return view('dashboard.index', get_defined_vars());
    } 
}
