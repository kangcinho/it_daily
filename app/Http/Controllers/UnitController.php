<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use App\Http\Requests\UnitRequestForm;
class UnitController extends Controller
{
  public function showUnit(){
      return view('unit/showUnit');
  }
  public function getUnit(){
    $units = Unit::orderBy('created_at','desc')->get();
    return response()->json(array('msg' => $units));
  }
  public function tambahUnit(UnitRequestForm $request){
    $slug = uniqid(null,true);
    $unit = new Unit(array(
      'slug' => $slug,
      'nama_unit' => $request->get('nama_unit'),
      'deskripsi_unit' => $request->get('deskripsi_unit'),
    ));
    $unit->save();
    $status = "Nama Unit : <b>".$unit->nama_unit."</b> Berhasil disimpan";
    return response()->json(array('msg' => $status));
  }

  public function editUnit(UnitRequestForm $request, $slug){
    $unit = Unit::where('slug',$slug)->firstOrFail();
    $unit->nama_unit = $request->get('nama_unit');
    $unit->deskripsi_unit = $request->get('deskripsi_unit');
    $unit->save();
    $status = "Nama Unit : <b>".$unit->nama_unit."</b> Berhasil disimpan";
    return response()->json(array('msg' => $status));
  }

  public function deleteUnit($slug){
    $unit = Unit::where('slug',$slug)->firstOrFail();
    $status = "Nama Unit : <b>".$unit->nama_unit."</b> Berhasil dihapus";
    $unit->delete();
    return response()->json(array('msg' => $status));
  }
}
