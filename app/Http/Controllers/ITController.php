<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IT;
use App\Unit;
use App\Http\Requests\ITDailyRequestForm;
use Maatwebsite\Excel\Facades\Excel;

class ITController extends Controller
{
    public function showITdaily(){
      $units = Unit::all();
      return view('itdaily/showITdaily',compact('units'));
    }
    public function getITdaily(){
      $job = IT::with('unit')->orderBy('status','asc')->orderBy('created_at','desc')->get();

      return response()->json(array('msg' => $job));
    }
    public function tambahITdaily(ITDailyRequestForm $request){
      $slug = uniqid(null, true);
      $unit = Unit::where('slug', $request->get('unit'))->firstOrFail();
      $job = new IT(array(
        'slug' => $slug,
        'id_unit' => $unit->id,
        'nama_user_request' => $request->get('nama_user_request'),
        'tgl_kejadian' => $request->get('tgl_kejadian'),
        'waktu_kejadian' => $request->get('waktu_kejadian'),
        'problem' => $request->get('problem'),
        'it_solved_by' => $request->get('it_solved_by'),
        'solusi' => $request->get('solusi'),
        'status' => $request->get('status')?1:0,
      ));
      $job->save();
      $status = "Job problem : <b>".$job->problem."</b> Berhasil disimpan";
      return response()->json(array('msg' => $status));
    }

    public function editITdaily(ITDailyRequestForm $request, $slug){
      $job = IT::with('unit')->where('slug',$slug)->firstOrFail();
      $unit = Unit::where('slug', $request->get('unit'))->firstOrFail();
      $job->id_unit = $unit->id;
      $job->nama_user_request = $request->get('nama_user_request');
      $job->tgl_kejadian = $request->get('tgl_kejadian');
      $job->waktu_kejadian = $request->get('waktu_kejadian');
      $job->problem = $request->get('problem');
      $job->it_solved_by = $request->get('it_solved_by');
      $job->solusi = $request->get('solusi');
      $job->status = $request->get('status')?1:0;
      $job->save();
      $status = "Job problem : <b>".$job->problem."</b> Berhasil disimpan";
      return response()->json(array('msg' => $status));
    }

    public function deleteITdaily($slug){
      $job = IT::with('unit')->where('slug',$slug)->firstOrFail();
      $status = "Job problem : <b>".$job->problem."</b> Berhasil disimpan";
      $job->delete();
      return response()->json(array('msg' => $status));
    }

    public function exportToExcel($search){
      $dataSearch = explode("&hobayu&", $search);
      if($dataSearch[0] == ""){ //Tampilkan semua data
        if($dataSearch[1] != '' && $dataSearch[2] != ''){
          $reservasi = IT::with('unit')
          ->where('created_at','>=', $dataSearch[1]." 00:00:00")
          ->where('created_at','<=', $dataSearch[2]." 23:59:59")
          ->orderBy('created_at','asc')->get();
        }else if($dataSearch[1] == ''){
          $reservasi = IT::with('unit')
          ->where('created_at','<=', $dataSearch[2]." 23:59:59")
          ->orderBy('created_at','asc')->get();
        }else if($dataSearch[2] == ''){
          $reservasi = IT::with('unit')
          ->where('created_at','>=', $dataSearch[1]." 00:00:00")
          ->orderBy('created_at','asc')->get();
        }
        if($dataSearch[1] == '' && $dataSearch[2] == ''){
          $reservasi = IT::with('unit')
          ->orderBy('created_at','asc')->get();
        }
      }else{
        if($dataSearch[1] != '' && $dataSearch[2] != ''){
          $reservasi = IT::with('unit')
          ->where('created_at','>=', $dataSearch[1]." 00:00:00")
          ->where('created_at','<=', $dataSearch[2]." 23:59:59")
          ->where('status',$dataSearch[0])
          ->orderBy('created_at','asc')->get();
        }else if($dataSearch[1] == ''){
          $reservasi = IT::with('unit')
          ->where('created_at','<=', $dataSearch[2]." 23:59:59")
          ->where('status',$dataSearch[0])
          ->orderBy('created_at','asc')->get();
        }else if($dataSearch[2] == ''){
          $reservasi = IT::with('unit')
          ->where('created_at','>=', $dataSearch[1]." 00:00:00")
          ->where('status',$dataSearch[0])
          ->orderBy('created_at','asc')->get();
        }
        if($dataSearch[1] == '' && $dataSearch[2] == ''){
          $reservasi = IT::with('unit')
          ->where('status',$dataSearch[0])
          ->orderBy('created_at','asc')->get();
        }
      }

      if($dataSearch[0] ==""){
        $dataKurung = " (Semua Data Status)";
      }else if($dataSearch[0] == "1"){
        $dataKurung = " (Data Status Sudah Done)";
      }else{
        $dataKurung = " (Data Status Masih Progress)";
      }

      $namaFile = 'Daily Job IT Tanggal '.$this->tanggal($dataSearch[1]).' Sampai '.$this->tanggal($dataSearch[2]).$dataKurung;

      Excel::create('Daily Job IT', function($excel) use ($reservasi, $namaFile) {
        $excel->setTitle($namaFile);
        $excel->setDescription($namaFile);
        $excel->setCreator('Agus Setiawan dan Putu Bayu Negara')
          ->setCompany('Puri Bunda');
        $excel->sheet('it_sheet1', function($sheet) use ($reservasi, $namaFile) {
          $sheet->setOrientation('landscape');
          $sheet->freezeFirstRow();
          $sheet->setAutoSize(true);
          $sheet->loadView('itdaily.exportExcel', array('reservasies' => $reservasi, 'namaFile' => $namaFile));
        });
      })->export('xls');
    }

    public function exportToPdf($search){
      $dataSearch = explode("&hobayu&", $search);
      if($dataSearch[0] == ""){ //Tampilkan semua data
        if($dataSearch[1] != '' && $dataSearch[2] != ''){
          $reservasi = IT::with('unit')
          ->where('created_at','>=', $dataSearch[1]." 00:00:00")
          ->where('created_at','<=', $dataSearch[2]." 23:59:59")
          ->orderBy('created_at','asc')->get();
        }else if($dataSearch[1] == ''){
          $reservasi = IT::with('unit')
          ->where('created_at','<=', $dataSearch[2]." 23:59:59")
          ->orderBy('created_at','asc')->get();
        }else if($dataSearch[2] == ''){
          $reservasi = IT::with('unit')
          ->where('created_at','>=', $dataSearch[1]." 00:00:00")
          ->orderBy('created_at','asc')->get();
        }
        if($dataSearch[1] == '' && $dataSearch[2] == ''){
          $reservasi = IT::with('unit')
          ->orderBy('created_at','asc')->get();
        }
      }else{
        if($dataSearch[1] != '' && $dataSearch[2] != ''){
          $reservasi = IT::with('unit')
          ->where('created_at','>=', $dataSearch[1]." 00:00:00")
          ->where('created_at','<=', $dataSearch[2]." 23:59:59")
          ->where('status',$dataSearch[0])
          ->orderBy('created_at','asc')->get();
        }else if($dataSearch[1] == ''){
          $reservasi = IT::with('unit')
          ->where('created_at','<=', $dataSearch[2]." 23:59:59")
          ->where('status',$dataSearch[0])
          ->orderBy('created_at','asc')->get();
        }else if($dataSearch[2] == ''){
          $reservasi = IT::with('unit')
          ->where('created_at','>=', $dataSearch[1]." 00:00:00")
          ->where('status',$dataSearch[0])
          ->orderBy('created_at','asc')->get();
        }
        if($dataSearch[1] == '' && $dataSearch[2] == ''){
          $reservasi = IT::with('unit')
          ->where('status',$dataSearch[0])
          ->orderBy('created_at','asc')->get();
        }
      }

      if($dataSearch[0] ==""){
        $dataKurung = " (Semua Data Status)";
      }else if($dataSearch[0] == "1"){
        $dataKurung = " (Data Status Sudah Done)";
      }else{
        $dataKurung = " (Data Status Masih Progress)";
      }

      $namaFile = 'Daily Job IT Tanggal '.$this->tanggal($dataSearch[1]).' Sampai '.$this->tanggal($dataSearch[2]).$dataKurung;

      $pdf = \PDF::loadView('itdaily.exportToPdf', array('reservasies'=>$reservasi, 'namaFile'=>$namaFile))->setPaper('a4', 'landscape');
      return $pdf->download($namaFile.'.pdf');
    }

    private function tanggal($tgl){
      if($tgl==""){
       return '';
      }
      $tgl = explode('-',$tgl);
      $bulan = '';
      switch($tgl[1]){
       case "01" : $bulan = "Januari"; break;
       case "02" : $bulan = "Februari"; break;
       case "03" : $bulan = "Maret"; break;
       case "04" : $bulan = "April"; break;
       case "05" : $bulan = "Mei"; break;
       case "06" : $bulan = "Juni"; break;
       case "07" : $bulan = "Juli"; break;
       case "08" : $bulan = "Agustus"; break;
       case "09" : $bulan = "September"; break;
       case "10" : $bulan = "Oktober"; break;
       case "11" : $bulan = "November"; break;
       case "12" : $bulan = "Desember"; break;
      }
      return $tgl[2].' '.$bulan.' '.$tgl[0];
    }
}
