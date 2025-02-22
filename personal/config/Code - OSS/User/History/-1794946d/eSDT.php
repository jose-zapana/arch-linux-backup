namespace App\Http\Controllers;

use App\Http\Middleware\VerifyStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  // Asegúrate de que esté importado correctamente.

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifyStock::class);  // Middleware aplicado aquí
    }

    public function index()
    {
        return view('cart.index');
    }
}
