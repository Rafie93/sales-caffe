<?php

namespace App\Http\Controllers\Api;

use App\Models\Regions\City;
use App\Models\Regions\RegionQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionsController extends Controller
{
    private $queryObject;

    public function __construct(RegionQuery $queryObject)
    {
        $this->queryObject = $queryObject;
    }

    public function provinces()
    {
        return $this->queryObject->getProvincesList();
    }

    public function cities(Request $request)
    {
        if ($provinceId = $request->get('province_id'))
            return $this->queryObject->getCitiesList($provinceId);

        return $this->queryObject->getCitiesList();
    }

    public function city(Request $request)
    {
        $data = City::select('id','name')->get();
        if ($provinceId = $request->get('province_id'))
            $data = City::select('id','name')->where('province_id',$provinceId)->get();

        return response()->json([ 'success' => true,'data' => $data],200);
    }

    public function districts(Request $request)
    {
        if ($cityId = $request->get('city_id'))
            return $this->queryObject->getDistrictsList($cityId);

        return [];
    }

    public function destinationCity(Request $request)
    {
        $cityId = $request->get('city_id');
        $data = City::select('id','name')->whereIn('id',function($query){
                        $query->select('dest_city_id')->from('rates')
                                ->groupBy('dest_city_id');
                })->get();

        return response()->json([ 'success' => true,'data' => $data],200);

    }

    public function destinationDistricts(Request $request)
    {
        return $this->queryObject->getDestinationDistrict($request->city_id);
    }

    public function destinationDistricts2(Request $request)
    {
        $destinationDistricts = [];
        if ($request->has('orig_city_id') && $request->has('dest_city_id')) {
            $districts = City::findOrFail($request->get('orig_city_id'))
                ->destinationDistricts()
                ->where('dest_city_id', $request->get('dest_city_id'))
                ->get();

            foreach ($districts as $district)
                $destinationDistricts[$district->id] = $district->name;
        }

        return $destinationDistricts;
    }
}
