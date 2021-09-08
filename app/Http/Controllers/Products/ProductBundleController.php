<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Image;

class ProductBundleController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->IN_STORE()) {
            $products = Product::orderBy('id','desc')
                        ->where('product_type',2)
                        ->where('store_id',auth()->user()->store_id)
                        ->paginate(10);
        }

        return view('bundle.index',compact('products'));
    }
    public function create(Request $request)
    {
        $product = Product::where('store_id',auth()->user()->store_id)
                            ->where('status',1)
                            ->where('product_type',1)
                            ->where('is_ready',1)
                            ->get();
         $categorys = Category::where('store_id',auth()->user()->store_id)
                            ->where('status',1)->get() ;
 
       return view('bundle.create',compact('product','categorys'));
    }

      public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:2',
            'category_id'    => 'required',
            'cost_of_goods'=>'numeric',
            'price_sales'=> 'required|numeric',
            'file' => 'required',
            'bundle' => 'required'
        ]);
        $store_id = auth()->user()->store_id;
      
        DB::beginTransaction();
            $productBundle = [];
            foreach ($request->bundle as $i => $bundle) {
                 $productBundle[] = array(
                    "id" => $bundle,
                    "name" => Product::where('id',$bundle)->first()->name,
                    "qty" => $request->qty[$i]
                 );
            }
            $request->merge([
                'store_id' => $store_id,
                'product_type' => 2,
                'createdBy'=>auth()->user()->id,
                'is_ready' => 0,
                'status' => 0,
                'bundle_product' => json_encode($productBundle)
            ]);
            $product = Product::create($request->all());
            if ($request->hasFile('file')) {
                $image      = $request->file('file');
                $fileName   = time() . '.' . $image->getClientOriginalExtension();

                $img = Image::make($image->getRealPath());
                $img->resize(250, 250, function ($constraint) {
                    $constraint->aspectRatio();                 
                });

                $img->stream(); 
                Storage::disk('local')->put('public/images/product/'.$store_id.'/'.$product->id.'/'.$fileName, $img, 'public');
                $product->cover = $fileName;
                $product->save();
            }
        DB::commit();
        return redirect()->route('product.bundle')->with('message','Produk Bundle Berhasil ditambahkan');
    }
}
