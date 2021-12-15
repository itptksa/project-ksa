<?php

namespace App\Http\Controllers;

use Storage;
use Response;
use validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Mail\Gmail;
use App\Models\documentrpk;
use App\Models\User;

class PicRpkController extends Controller
{
    public function rpk(){
        $date = date('m');
        $docrpk = documentrpk::with('user')->where('cabang',Auth::user()->cabang)->whereMonth('created_at', date('m'))->latest()->get();
        return view('picsite.rpk' , compact('docrpk'));
    }

    public function downloadrpk(){
        $path = Storage::path('SuratBarang/stenli-picsiteRPK-1.pdf' );
        return Response::download($path, 'stenli-picsiteRPK-1.pdf');
    }

    public function uploadrpk(Request $request){

        $docrpk = documentrpk::with('user')->where('cabang',Auth::user()->cabang)->latest()->get();

        if(Auth::user()->cabang == 'Babelan'){ 
            $year = date('Y');
            $month = date('m');
            
            $request->validate([
                'rfile1' => 'mimes:pdf|max:1024' ,
                'rfile2' => 'mimes:pdf|max:1024' ,
                'rfile3' => 'mimes:pdf|max:1024' ,
                'rfile4' => 'mimes:pdf|max:1024' ,
                'rfile5' => 'mimes:pdf|max:1024' ,
                'rfile6' => 'mimes:pdf|max:1024' ,
                'rfile7' => 'mimes:pdf|max:1024' 
            ]);
            if ($request->hasFile('rfile1')) {
                //dd($request);
                $file = $request->file('rfile1');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/surat_barang';
                $path = $request->file('rfile1')->storeas('babelan/'. $year . "/". $month . '/RPK', $name1, 's3');
                if (documentrpk::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Babelan' )->update([
                        'status1' => 'on review',
                        'surat_barang' => basename($path),
                        'time_upload1' => date("Y-m-d"),
                    ]);
                }else{
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status1' => 'on review',
                        'surat_barang' => basename($path),
                        'time_upload1' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('rfile2')){
                $file = $request->file('rfile2');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/cargo_manifest';
                $path = $request->file('rfile2')->storeas('babelan/'. $year . "/". $month . '/RPK', $name1, 's3');
                if (documentrpk::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Babelan' )->update([      
                        'status2' => 'on review',
                        'cargo_manifest'=> basename($path) ,
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }else{
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status2' => 'on review',
                        'cargo_manifest'=> basename($path) ,
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }
            }      
            if ($request->hasFile('rfile3')){
                $file = $request->file('rfile3');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/voyage';
                $path = $request->file('rfile3')->storeas('babelan/'. $year . "/". $month . '/RPK', $name1, 's3');
                if (documentrpk::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Babelan' )->update([
                        'status3' => 'on review',
                        'voyage' => basename($path),
                        'time_upload3' => date("Y-m-d"),
                    ]);
                }else{
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status3' => 'on review',
                        'voyage' => basename($path),
                        'time_upload3' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('rfile4')){
                $file = $request->file('rfile4');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/bill_lading';
                $path = $request->file('rfile4')->storeas('babelan/'. $year . "/". $month . '/RPK', $name1, 's3');
                if (documentrpk::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Babelan' )->update([
                        'status4' => 'on review',
                        'bill_lading' => basename($path),
                        'time_upload4' => date("Y-m-d"),
                    ]);
                }else{
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status4' => 'on review',
                        'bill_lading' => basename($path),
                        'time_upload4' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('rfile5')){
                $file = $request->file('rfile5');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/gerak_kapal';
                $path = $request->file('rfile5')->storeas('babelan/'. $year . "/". $month . '/RPK', $name1, 's3');
                if (documentrpk::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Babelan' )->update([                   
                        'status5' => 'on review',
                        'gerak_kapal'=> basename($path) ,
                        'time_upload5' => date("Y-m-d"),
                    ]);
                }else{
                    documentrpk::create([                   
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status5' => 'on review',
                        'gerak_kapal'=> basename($path) ,
                        'time_upload5' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('rfile6')){
                $file = $request->file('rfile6');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/docking';
                $path = $request->file('rfile6')->storeas('babelan/'. $year . "/". $month . '/RPK', $name1, 's3');
                if (documentrpk::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Babelan' )->update([                  
                        'status6' => 'on review',
                        'docking' => basename($path),
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }else{
                    documentrpk::create([      
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status6' => 'on review',
                        'docking' => basename($path),
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('rfile7')){
                $file = $request->file('rfile7');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/surat_kapal';
                $path = $request->file('rfile7')->storeas('babelan/'. $year . "/". $month . '/RPK', $name1, 's3');
                if (documentrpk::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Babelan' )->update([              
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                        'surat_kapal' => basename($path),
                    ]);  
                }else{
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                         
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                        'surat_kapal' => basename($path),
                    ]);
                }
            }
            return redirect('picsite/rpk')->with('message', 'Upload success!');
        }

        if(Auth::user()->cabang == 'Berau'){
            $year = date('Y');
            $month = date('m');
            $request->validate([
                'brfile1' => 'mimes:pdf|max:1024' ,
                'brfile2' => 'mimes:pdf|max:1024' ,
                'brfile3' => 'mimes:pdf|max:1024' ,
                'brfile4' => 'mimes:pdf|max:1024' ,
                'brfile5' => 'mimes:pdf|max:1024' ,
                'brfile6' => 'mimes:pdf|max:1024' ,
                'brfile7' => 'mimes:pdf|max:1024' 
            ]);
            if ($request->hasFile('brfile1')) {
                //dd($request);
                $file = $request->file('brfile1');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/surat_barang';
                $path = $request->file('brfile1')->storeas('berau/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Berau' )->update([
                        'status1' => 'on review',
                        'surat_barang' => basename($path),
                        'time_upload1' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status1' => 'on review',
                        'surat_barang' => basename($path),
                        'time_upload1' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('brfile2')){
                $file = $request->file('brfile2');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/cargo_manifest';
                $path = $request->file('brfile2')->storeas('berau/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Berau' )->update([
                        'status2' => 'on review',
                        'cargo_manifest'=> basename($path) ,
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }else{
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status2' => 'on review',
                        'cargo_manifest'=> basename($path) ,
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }
            }      
            if ($request->hasFile('brfile3')){
                $file = $request->file('brfile3');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/voyage';
                $path = $request->file('brfile3')->storeas('berau/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Berau' )->update([
                        'status3' => 'on review',
                        'voyage' => basename($path),
                        'time_upload3' => date("Y-m-d"),
                    ]);
                }else{
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status3' => 'on review',
                        'voyage' => basename($path),
                        'time_upload3' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('brfile4')){
                $file = $request->file('brfile4');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/bill_lading';
                $path = $request->file('brfile4')->storeas('berau/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Berau' )->update([
                        'status4' => 'on review',
                        'bill_lading' => basename($path),
                        'time_upload4' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status4' => 'on review',
                        'bill_lading' => basename($path),
                        'time_upload4' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('brfile5')){
                $file = $request->file('brfile5');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/gerak_kapal';
                $path = $request->file('brfile5')->storeas('berau/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Berau' )->update([                   
                        'status5' => 'on review',
                        'gerak_kapal'=> basename($path) ,
                        'time_upload5' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([    
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status5' => 'on review',
                        'gerak_kapal'=> basename($path) ,
                        'time_upload5' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('brfile6')){
                $file = $request->file('brfile6');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/docking';
                $path = $request->file('brfile6')->storeas('berau/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Berau' )->update([                
                        'status6' => 'on review',
                        'docking' => basename($path),
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([    
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status6' => 'on review',
                        'docking' => basename($path),
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('brfile7')){
                $file = $request->file('brfile7');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/surat_kapal';
                $path = $request->file('brfile7')->storeas('berau/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Berau' )->update([
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                        'surat_kapal' => basename($path),
                    ]);
                }else{
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                        'surat_kapal' => basename($path),
                    ]);
                }  
            }
            return redirect('picsite/rpk')->with('message', 'Upload success!');
        }

        if(Auth::user()->cabang == 'Banjarmasin'){
            $year = date('Y');
            $month = date('m');
            $request->validate([
                'bjrfile1' => 'mimes:pdf|max:1024' ,
                'bjrfile2' => 'mimes:pdf|max:1024' ,
                'bjrfile3' => 'mimes:pdf|max:1024' ,
                'bjrfile4' => 'mimes:pdf|max:1024' ,
                'bjrfile5' => 'mimes:pdf|max:1024' ,
                'bjrfile6' => 'mimes:pdf|max:1024' ,
                'bjrfile7' => 'mimes:pdf|max:1024' 
            ]);
            if ($request->hasFile('bjrfile1')) {
                //dd($request);
                $file = $request->file('bjrfile1');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/surat_barang';
                $path = $request->file('bjrfile1')->storeas('banjarmasin/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::create([
                        'status1' => 'on review',
                        'surat_barang' => basename($path),
                        'time_upload1' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status1' => 'on review',
                        'surat_barang' => basename($path),
                        'time_upload1' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('bjrfile2')){
                $file = $request->file('bjrfile2');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/cargo_manifest';
                $path = $request->file('bjrfile2')->storeas('banjarmasin/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Banjarmasin' )->update([
                        'status2' => 'on review',
                        'cargo_manifest'=> basename($path) ,
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status2' => 'on review',
                        'cargo_manifest'=> basename($path) ,
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }
            }      
            if ($request->hasFile('bjrfile3')){
                $file = $request->file('bjrfile3');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/voyage';
                $path = $request->file('bjrfile3')->storeas('banjarmasin/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Banjarmasin' )->update([
                        'status3' => 'on review',
                        'voyage' => basename($path),
                        'time_upload3' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status3' => 'on review',
                        'voyage' => basename($path),
                        'time_upload3' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('bjrfile4')){
                $file = $request->file('bjrfile4');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/bill_lading';
                $path = $request->file('bjrfile4')->storeas('banjarmasin/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Banjarmasin' )->update([
                        'status4' => 'on review',
                        'bill_lading' => basename($path),
                        'time_upload4' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status4' => 'on review',
                        'bill_lading' => basename($path),
                        'time_upload4' => date("Y-m-d"),
                    ]);
                }

            }
            if ($request->hasFile('bjrfile5')){
                $file = $request->file('bjrfile5');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/gerak_kapal';
                $path = $request->file('bjrfile5')->storeas('banjarmasin/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Banjarmasin' )->update([                   
                        'status5' => 'on review',
                        'gerak_kapal'=> basename($path) ,
                        'time_upload5' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([       
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status5' => 'on review',
                        'gerak_kapal'=> basename($path) ,
                        'time_upload5' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('bjrfile6')){
                $file = $request->file('bjrfile6');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/docking';
                $path = $request->file('bjrfile6')->storeas('banjarmasin/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Banjarmasin' )->update([                
                        'status6' => 'on review',
                        'docking' => basename($path),
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([         
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status6' => 'on review',
                        'docking' => basename($path),
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('bjrfile7')){
                $file = $request->file('bjrfile7');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/surat_kapal';
                $path = $request->file('bjrfile7')->storeas('banjarmasin/'. $year . "/". $month. '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Banjarmasin' )->update([                
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                        'surat_kapal' => basename($path),
                    ]);
                }else {
                    documentrpk::create([       
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                        'surat_kapal' => basename($path),
                    ]);
                }
            }
            return redirect('picsite/rpk')->with('message', 'Upload success!');
        }

        if(Auth::user()->cabang == 'Samarinda'){
            $year = date('Y');
            $month = date('m');
            $request->validate([
                'smrfile1' => 'mimes:pdf|max:1024' ,
                'smrfile2' => 'mimes:pdf|max:1024' ,
                'smrfile3' => 'mimes:pdf|max:1024' ,
                'smrfile4' => 'mimes:pdf|max:1024' ,
                'smrfile5' => 'mimes:pdf|max:1024' ,
                'smrfile6' => 'mimes:pdf|max:1024' ,
                'smrfile7' => 'mimes:pdf|max:1024' 
            ]);
            if ($request->hasFile('smrfile1')) {
                //dd($request);
                $file = $request->file('smrfile1');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/surat_barang';
                $path = $request->file('smrfile1')->storeas('samarinda/'. $year . "/". $month . '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Samarinda' )->update([
                        'status1' => 'on review',
                        'surat_barang' => basename($path),
                        'time_upload1' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status1' => 'on review',
                        'surat_barang' => basename($path),
                        'time_upload1' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('smrfile2')){
                $file = $request->file('smrfile2');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/cargo_manifest';
                $path = $request->file('smrfile2')->storeas('samarinda/'. $year . "/". $month . '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Samarinda' )->update([                       
                        'status2' => 'on review',
                        'cargo_manifest'=> basename($path) ,
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([    
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status2' => 'on review',
                        'cargo_manifest'=> basename($path) ,
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }
            }      
            if ($request->hasFile('smrfile3')){
                $file = $request->file('smrfile3');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/voyage';
                $path = $request->file('smrfile3')->storeas('samarinda/'. $year . "/". $month . '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Samarinda' )->update([
                        'status3' => 'on review',
                        'voyage' => basename($path),
                        'time_upload3' => date("Y-m-d"),
                    ]);
                }else{
                    documentrpk::create([
                        'status3' => 'on review',
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'voyage' => basename($path),
                        'time_upload3' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('smrfile4')){
                $file = $request->file('smrfile4');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/bill_lading';
                $path = $request->file('smrfile4')->storeas('samarinda/'. $year . "/". $month . '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Samarinda' )->update([
                        'status4' => 'on review',
                        'bill_lading' => basename($path),
                        'time_upload4' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status4' => 'on review',
                        'bill_lading' => basename($path),
                        'time_upload4' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('smrfile5')){
                $file = $request->file('smrfile5');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/gerak_kapal';
                $path = $request->file('smrfile5')->storeas('samarinda/'. $year . "/". $month . '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Samarinda' )->update([                   
                        'status5' => 'on review',
                        'gerak_kapal'=> basename($path) ,
                        'time_upload5' => date("Y-m-d"),
                    ]);
                }else{
                    documentrpk::create([    
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status5' => 'on review',
                        'gerak_kapal'=> basename($path) ,
                        'time_upload5' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('smrfile6')){
                $file = $request->file('smrfile6');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/docking';
                $path = $request->file('smrfile6')->storeas('samarinda/'. $year . "/". $month . '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Samarinda' )->update([                
                        'status6' => 'on review',
                        'docking' => basename($path),
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }else {
                    documentrpk::create([     
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status6' => 'on review',
                        'docking' => basename($path),
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('smrfile7')){
                $file = $request->file('smrfile7');
                $name1 = 'Picsite-'. Auth::user()->cabang . $file->getClientOriginalName();
                $tujuan_upload = 'RPK/surat_kapal';
                $path = $request->file('smrfile7')->storeas('samarinda/'. $year . "/". $month . '/RPK' , $name1, 's3');
                if(documentrpk::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    
                    documentrpk::where('cabang', 'Samarinda' )->update([                 
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                        'surat_kapal' => basename($path),
                    ]);
                }else {
                    documentrpk::create([     
                        'user_id' => Auth::user()->id,
                        'cabang' => Auth::user()->cabang ,
                        
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                        'surat_kapal' => basename($path),
                    ]);
                }
            }
            return redirect('picsite/rpk')->with('message', 'Upload success!');
        }

        //email to user
    // $details = [
    //         'title' => 'Thank you for receiving this email', 
    //         'body' => 'you are a test subject for the project hehe'
    //     ];
        
    //     Mail::to('stanlytong@gmail.com')->send(new Gmail($details));

    //     return redirect('picsite/rpk');
    // }

    }
}
