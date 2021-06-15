<?php

namespace App\Http\Controllers\APIS;

use App\Helpers\Traits;
use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;

class apiController extends Controller
{
    use Traits;

    public function index()
    {
        $category = Category::Selection()->get();
        return response()->json($category);
    }

    public function categoryId(Request $request)
    {

        $category = Category::Selection()->get()->find($request->id);
        if (!$category) {
            return $this->returnError(500, 'هذ الحقل غير موجود ');
        }
        return $this->returnData('category', $category, 'data has  sent successfully');
    }

    public function ChangeStatus(Request $request)
    {
        $category = Category::where('id', $request -> id)-> update([
            'active'=> $request -> active
        ]);
        return $this -> returnSuccessMessage('Status cahnged successfully','200');
    }

}
