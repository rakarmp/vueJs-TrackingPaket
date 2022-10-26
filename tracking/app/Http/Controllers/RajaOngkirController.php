<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    protected $API_KEY = 'c9c328fbb8d779426c71056ffc78b75a';

    public function getProvinces(){
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://api.rajaongkir.com/starter/province');

        $provinces = $response['rajaongkir']['results'];

        return $response()->json([
            'success' => true,
            'message' => 'Mengambil Semua Provinsi',
            'data' => $provinces
        ]);
    }

    public function getCities($id){
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://api.rajaongkir.com/starter/city?&province='.$id.'');

        $cities = $response['rajaongkir']['results'];
        return $response()->json([
            'success' => true,
            'message' => 'Mengambil Semua Kota Berdasarkan ID : '.$id,
            'data' => $cities
        ]);
    }

    public function checkOngkir(Request $request){
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin'            => $request->origin,
            'destination'       => $request->destination,
            'weight'            => $request->weight,
            'courier'           => $request->courier
        ]);

        $ongkir = $response['rajaongkir']['results'];

        return $response()->json([
            'success' => true,
            'message' => 'Total Const Ongkir',
            'data' => $ongkir
        ]);
    }
}
