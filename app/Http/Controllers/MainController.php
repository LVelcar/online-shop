<?Php 

namespace App\Http\Controllers;

use App\Models\Product;

class MainController extends Controller
{
    public function index()
    {
        return view('welcome')->with([
            'products' => Product::all(),
        ]);
    }
}