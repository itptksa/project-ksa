<?php

namespace App\Http\Controllers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Storage;
use Response;
use validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\Gmail;
use App\Models\documents;
use App\Models\documentberau;
use App\Models\documentbanjarmasin;
use App\Models\documentsamarinda;
use App\Models\User;

class PicsiteController extends Controller
{
    public function uploadform(){
        $date = date('m');
        $document = documents::with('user')->where('cabang',Auth::user()->cabang)->whereMonth('created_at', date('m'))->latest()->get();
        $documentberau = documentberau::with('user')->where('cabang',Auth::user()->cabang)->whereMonth('created_at', date('m'))->latest()->get();
        $documentbanjarmasin = documentbanjarmasin::with('user')->where('cabang',Auth::user()->cabang)->whereMonth('created_at', date('m'))->latest()->get();
        $documentsamarinda = documentsamarinda::with('user')->where('cabang',Auth::user()->cabang)->whereMonth('created_at', date('m'))->latest()->get();
        // dd($document);
        
        return view('picsite.upload',compact('document' , 'documentberau','documentbanjarmasin','documentsamarinda'));
    }
    
    public function uploadfile(Request $request){

        $document = documents::with('user')->where('cabang',Auth::user()->cabang)->latest()->get();
        $documentberau = documentberau::with('user')->where('cabang',Auth::user()->cabang)->latest()->get();
        $documentbanjarmasin = documentbanjarmasin::with('user')->where('cabang',Auth::user()->cabang)->latest()->get();
        $documentsamarinda = documentsamarinda::with('user')->where('cabang',Auth::user()->cabang)->latest()->get();
        //dd($document->created_at);
        if (Auth::user()->cabang == 'Babelan') {

            $year = date('Y');
            $month = date('m');

            $request->validate([
                'ufile1' => 'mimes:pdf|max:3072' ,
                'ufile2' => 'mimes:pdf|max:3072' ,
                'ufile3' => 'mimes:pdf|max:3072' ,
                'ufile4' => 'mimes:pdf|max:3072' ,
                'ufile5' => 'mimes:pdf|max:3072' , 
                'ufile6' => 'mimes:pdf|max:3072' ,
                'ufile7' => 'mimes:pdf|max:3072' ,
                'ufile8' => 'mimes:pdf|max:3072' ,
                'ufile9' => 'mimes:pdf|max:3072' ,
                'ufile10' => 'mimes:pdf|max:3072' ,
                'ufile11' => 'mimes:pdf|max:3072' ,
                'ufile12' => 'mimes:pdf|max:3072' ,
                'ufile13' => 'mimes:pdf|max:3072' ,
                'ufile14' => 'mimes:pdf|max:3072' ,
                'ufile15' => 'mimes:pdf|max:3072' ,
                'ufile16' => 'mimes:pdf|max:3072' ,
            ]);

            if ($request->hasFile('ufile1')) {
                $file1 = $request->file('ufile1');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'babelan/sertifikat_keselamatan';   
                       
                $path = $request->file('ufile1')->storeas('babelan/'. $year . "/". $month , $name1, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){

                documents::where('cabang', 'Babelan')->update([
                        //babelan
                        'status1' => 'on review',
                        'time_upload1' => date("Y-m-d"),
                        'sertifikat_keselamatan' => basename($path),
                    ]);
                }else{
                    documents::create([
                        //babelan
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                        'status1' => 'on review',
                        
                        'time_upload1' => date("Y-m-d"),
                        'sertifikat_keselamatan' => basename($path),]);
                }
            }

            if ($request->hasFile('ufile2')) {
                $file2 = $request->file('ufile2');
                $name2 = 'Picsite-'. Auth::user()->cabang . $file2->getClientOriginalName();
                $tujuan_upload = 'babelan/sertifikat_garis_muat';     

                $path = $request->file('ufile2')->storeas('babelan/'. $year . "/". $month , $name2, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                documents::where('cabang', 'Babelan' )->update([                                        
                        'sertifikat_garis_muat' => basename($path),
                        'status2' => 'on review',
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'sertifikat_garis_muat' => basename($path),
                        'status2' => 'on review',
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }
            }

            if ($request->hasFile('ufile3')) {
                $file3 = $request->file('ufile3');
                $name3 = 'Picsite-'. Auth::user()->cabang . $file3->getClientOriginalName();
                $tujuan_upload = 'babelan/penerbitan_sekali_jalan';

                $path = $request->file('ufile3')->storeas('babelan/'. $year . "/". $month , $name3, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                documents::where('cabang', 'Babelan') ->update([
                        //babelan                       
                            'penerbitan_sekali_jalan' => basename($path),
                            'status3' => 'on review',
                            'time_upload3' => date("Y-m-d"),
                    ]);
                }else {
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'penerbitan_sekali_jalan' => basename($path),
                        'status3' => 'on review',
                        'time_upload3' => date("Y-m-d"),
                    ]); 
                }
            }
            
            if ($request->hasFile('ufile4')) {
                $file4 = $request->file('ufile4');
                $name4 = 'Picsite-'. Auth::user()->cabang . $file4->getClientOriginalName();
                $tujuan_upload = 'babelan/sertifikat_safe_manning';
               
                $path = $request->file('ufile4')->storeas('babelan/'. $year . "/". $month , $name4, 's3');
               if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                documents::where('cabang', 'Babelan')->update([
                    //babelan
                    'sertifikat_safe_manning'=> basename($path),
                    'status4' => 'on review',
                    'time_upload4' => date("Y-m-d"),
                ]);
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                        
                        'sertifikat_safe_manning'=> basename($path),
                        'status4' => 'on review',
                        'time_upload4' => date("Y-m-d"),
                    ]);
                }
            }
            
            if ($request->hasFile('ufile5')) {
                $file5 = $request->file('ufile5');
                $name5 = 'Picsite-'. Auth::user()->cabang . $file5->getClientOriginalName();
                $tujuan_upload = 'babelan/endorse_surat_laut';
                
                $path = $request->file('ufile5')->storeas('babelan/'. $year . "/". $month , $name5, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                documents::where('cabang', 'Babelan')->update([
                        'endorse_surat_laut'=> basename($path),
                        'status5' => 'on review',
                        'time_upload5' => date("Y-m-d"),
                    ]);   
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'endorse_surat_laut'=> basename($path),
                        'status5' => 'on review',
                        'time_upload5' => date("Y-m-d"),
                    ]);
                }
            }
            
            if ($request->hasFile('ufile6')) {
                $file6 = $request->file('ufile6');
                $name6 = 'Picsite-'. Auth::user()->cabang . $file6->getClientOriginalName();
                $tujuan_upload = 'babelan/perpanjangan_sertifikat_sscec';
               
                $path = $request->file('ufile6')->storeas('babelan/'. $year . "/". $month , $name6, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                documents::where('cabang', 'Babelan')->update([
                        'perpanjangan_sertifikat_sscec'=> basename($path),
                        'status6' => 'on review',
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'perpanjangan_sertifikat_sscec'=> basename($path),
                        'status6' => 'on review',
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }
            }
            
            if ($request->hasFile('ufile7')) {
                $file7 = $request->file('ufile7');
                $name7 ='Picsite-'. Auth::user()->cabang . $file7->getClientOriginalName();
                $tujuan_upload = 'babelan/perpanjangan_sertifikat_p3k';
                
                $path = $request->file('ufile7')->storeas('babelan/'. $year . "/". $month , $name7, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                documents::where('cabang', 'Babelan')->update([
                        //babelan
                        'perpanjangan_sertifikat_p3k'=> basename($path),
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                    ]);
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                        //babelan
                        'perpanjangan_sertifikat_p3k'=> basename($path),
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                    ]);
                }
                
            }
            
            if ($request->hasFile('ufile8')) {
                $file8 = $request->file('ufile8');
                $name8 = 'Picsite-'. Auth::user()->cabang . $file8->getClientOriginalName();
                $tujuan_upload = 'babelan/biaya_laporan_dok';
               
                $path = $request->file('ufile8')->storeas('babelan/'. $year . "/". $month , $name8, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                documents::where('cabang', 'Babelan')->update([
                        //babelan
                        'biaya_laporan_dok'=> basename($path),
                        'status8' => 'on review',
                        'time_upload8' => date("Y-m-d"),
                    ]);     
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                        //babelan
                        'biaya_laporan_dok'=> basename($path),
                        'status8' => 'on review',
                        'time_upload8' => date("Y-m-d"),
                    ]); 
                }  
            }
            
            if ($request->hasFile('ufile9')) {
                $file9 = $request->file('ufile9');
                $name9 = 'Picsite-'. Auth::user()->cabang . $file9->getClientOriginalName();
                $tujuan_upload = 'babelan/pnpb_sertifikat_keselamatan';
               
                $path = $request->file('ufile9')->storeas('babelan/'. $year . "/". $month , $name9, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                documents::where('cabang', 'Babelan')->update([
                        //babelan
                        'pnpb_sertifikat_keselamatan'=> basename($path),
                        'status9' => 'on review',
                        'time_upload9' => date("Y-m-d"),
                    ]);                   
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                        //babelan
                        'pnpb_sertifikat_keselamatan'=> basename($path),
                        'status9' => 'on review',
                        'time_upload9' => date("Y-m-d"),
                    ]);
                }
            }
            
            if ($request->hasFile('ufile10')) {
                $file10 = $request->file('ufile10');
                $name10 = 'Picsite-'. Auth::user()->cabang . $file10->getClientOriginalName();
                $tujuan_upload = 'babelan/pnpb_sertifikat_garis_muat';
               
                $path = $request->file('ufile10')->storeas('babelan/'. $year . "/". $month , $name10, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documents::where('cabang', 'Babelan')->update([
                        //babelan
                        'pnpb_sertifikat_garis_muat'=> basename($path),
                        'status10' => 'on review',
                        'time_upload10' => date("Y-m-d"),
                    ]);          
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                        //babelan
                        'pnpb_sertifikat_garis_muat'=> basename($path),
                        'status10' => 'on review',
                        'time_upload10' => date("Y-m-d"),
                    ]);
                }
            }
            
            if ($request->hasFile('ufile11')) {
                $file11 = $request->file('ufile11');
                $name11 = 'Picsite-'. Auth::user()->cabang . $file11->getClientOriginalName();
                $tujuan_upload = 'babelan/pnpb_surat_laut';
               
                $path = $request->file('ufile11')->storeas('babelan/'. $year . "/". $month , $name11, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documents::where('cabang', 'Babelan')->update([
                        //babelan
                        'pnpb_surat_laut'=> basename($path),
                        'status11' => 'on review',
                        'time_upload11' => date("Y-m-d"),
                    ]);
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'pnpb_surat_laut'=> basename($path),
                        'status11' => 'on review',
                        'time_upload11' => date("Y-m-d"),
                    ]);
                }
            }
            
            if ($request->hasFile('ufile12')) {
                $file12 = $request->file('ufile12');
                $name12 = 'Picsite-'. Auth::user()->cabang . $file12->getClientOriginalName();
                $tujuan_upload = 'babelan/sertifikat_snpp';
               
                $path = $request->file('ufile12')->storeas('babelan/'. $year . "/". $month , $name12, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documents::where('cabang', 'Babelan')->update([
                        //babelan
                        'sertifikat_snpp'=> basename($path),
                        'status12' => 'on review',
                        'time_upload12' => date("Y-m-d"),
                    ]);
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'sertifikat_snpp'=> basename($path),
                        'status12' => 'on review',
                        'time_upload12' => date("Y-m-d"),
                    ]);
                }
            }
            
            if ($request->hasFile('ufile13')) {
                $file13 = $request->file('ufile13');
                $name13 = 'Picsite-'. Auth::user()->cabang . $file13->getClientOriginalName();
                $tujuan_upload = 'babelan/sertifikat_anti_teritip';
                
                $path = $request->file('ufile13')->storeas('babelan/'. $year . "/". $month , $name13, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documents::where('cabang', 'Babelan')->update([
                        //babelan
                        'sertifikat_anti_teritip'=> basename($path),
                        'status13' => 'on review',
                        'time_upload13' => date("Y-m-d"),
                    ]);
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                        //babelan
                        'sertifikat_anti_teritip'=> basename($path),
                        'status13' => 'on review',
                        'time_upload13' => date("Y-m-d"),
                    ]);
                }
            }
            
            if ($request->hasFile('ufile14')) {
                $file14 = $request->file('ufile14');
                $name14 = 'Picsite-'. Auth::user()->cabang . $file14->getClientOriginalName();
                $tujuan_upload = 'babelan/pnbp_snpp&snat';
                
                $path = $request->file('ufile14')->storeas('babelan/'. $year . "/". $month , $name14, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documents::where('cabang', 'Babelan')->update([
                        //babelan
                        'pnbp_snpp&snat'=> basename($path),
                        'status14' => 'on review',
                        'time_upload14' => date("Y-m-d"),
                    ]);
                }else {
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                        //babelan
                        'pnbp_snpp&snat'=> basename($path),
                        'status14' => 'on review',
                        'time_upload14' => date("Y-m-d"),
                    ]);
                }
            }  
            if ($request->hasFile('ufile15')) {
                $file15 = $request->file('ufile15');
                $name15 = 'Picsite-'. Auth::user()->cabang . $file15->getClientOriginalName();
                $tujuan_upload = 'babelan/biaya_survey';
               
                $path = $request->file('ufile15')->storeas('babelan/'. $year . "/". $month , $name15, 's3');
                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documents::where('cabang', 'Babelan')->update([
                        //babelan
                        'biaya_survey'=> basename($path),
                        'status15' => 'on review',
                        'time_upload15' => date("Y-m-d"),
                    ]);
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                        //babelan
                        'biaya_survey'=> basename($path),
                        'status15' => 'on review',
                        'time_upload15' => date("Y-m-d"),
                    ]);                    
                }
            }
            if ($request->hasFile('ufile16')) {
                $file16 = $request->file('ufile16');
                $name16 = 'Picsite-'. Auth::user()->cabang . $file16->getClientOriginalName();
                $tujuan_upload = 'babelan/pnpb_sscec';
              
                $path = $request->file('ufile16')->storeas('babelan/'. $year . "/". $month , $name16 , 's3');

                if (documents::where('cabang', 'Babelan')->whereMonth('created_at', date('m'))->exists()){
                    
                    documents::where('cabang', 'Babelan')->update([
                        //babelan
                        'pnpb_sscec'=> basename($path),
                        'status16' => 'on review',
                        'time_upload16' => date("Y-m-d"),
                    ]);
                }else{
                    documents::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'pnpb_sscec'=> basename($path),
                        'status16' => 'on review',
                        'time_upload16' => date("Y-m-d"),
                    ]);
                }
            }
            return redirect('/picsite/upload')->with('success', 'Upload Success!');
        }

        if (Auth::user()->cabang == 'Berau') {
            // dd($request);

            $year = date('Y');
            $month = date('m');

            $request->validate([
                'beraufile1'=> 'mimes:pdf|max:3072' ,
                'beraufile2'=> 'mimes:pdf|max:3072' ,
                'beraufile3'=> 'mimes:pdf|max:3072' ,
                'beraufile4'=> 'mimes:pdf|max:3072' ,
                'beraufile5'=> 'mimes:pdf|max:3072' ,
                'beraufile6'=> 'mimes:pdf|max:3072' ,
                'beraufile7'=> 'mimes:pdf|max:3072' ,
                'beraufile8'=> 'mimes:pdf|max:3072' ,
                'beraufile9'=> 'mimes:pdf|max:3072' ,
                'beraufile10'=> 'mimes:pdf|max:3072' ,
                'beraufile11'=> 'mimes:pdf|max:3072' ,
                'beraufile12'=> 'mimes:pdf|max:3072' ,
                'beraufile13'=> 'mimes:pdf|max:3072' ,
                'beraufile14'=> 'mimes:pdf|max:3072' ,
                'beraufile15'=> 'mimes:pdf|max:3072' ,
                'beraufile16'=> 'mimes:pdf|max:3072' ,
                'beraufile17'=> 'mimes:pdf|max:3072' ,
                'beraufile18'=> 'mimes:pdf|max:3072' ,
                'beraufile19'=> 'mimes:pdf|max:3072' ,
                'beraufile20'=> 'mimes:pdf|max:3072' , 
                'beraufile21'=> 'mimes:pdf|max:3072' ,
                'beraufile22'=> 'mimes:pdf|max:3072' ,
                'beraufile23'=> 'mimes:pdf|max:3072' ,
                'beraufile24'=> 'mimes:pdf|max:3072' , 
                'beraufile25'=> 'mimes:pdf|max:3072' ,
                'beraufile26'=> 'mimes:pdf|max:3072' ,
            ]);
            if ($request->hasFile('beraufile1')) {
                $file1 = $request->file('beraufile1');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pnbp_sertifikat_konstruksi';
                $path = $request->file('beraufile1')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([
                    'pnbp_sertifikat_konstruksi' => basename($path),
                    'cabang' => Auth::user()->cabang ,
                    'status1' => 'on review',]);

                }else{
                    documentberau::create([
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,
                    
                    'status1' => 'on review',
                    'time_upload1' => date("Y-m-d"),
                    'pnbp_sertifikat_konstruksi' => basename($path),]);
                }
            }
            if ($request->hasFile('beraufile2')) {
                $file1 = $request->file('beraufile2');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/jasa_urus_sertifikat';
                $path = $request->file('beraufile2')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'jasa_urus_sertifikat' => basename($path),
                        'status2' => 'on review',
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }else{
                    documentberau::create([       
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'jasa_urus_sertifikat' => basename($path),
                        'status2' => 'on review',
                        'time_upload2' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile3')) {
                $file1 = $request->file('beraufile3');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pnbp_sertifikat_perlengkapan';
                $path = $request->file('beraufile3')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'pnbp_sertifikat_perlengkapan' => basename($path),
                        'status3' => 'on review',
                        'time_upload3' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'pnbp_sertifikat_perlengkapan' => basename($path),
                        'status3' => 'on review',
                        'time_upload3' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile4')) {
                $file1 = $request->file('beraufile4');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pnbp_sertifikat_radio';
                $path = $request->file('beraufile4')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'pnbp_sertifikat_radio' => basename($path),
                        'status4' => 'on review',
                        'time_upload4' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'pnbp_sertifikat_radio' => basename($path),
                        'status4' => 'on review',
                        'time_upload4' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile5')) {
                $file1 = $request->file('beraufile5');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pnbp_sertifikat_ows';
                $path = $request->file('beraufile5')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'pnbp_sertifikat_ows' => basename($path),
                        'status5' => 'on review',
                        'time_upload5' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'pnbp_sertifikat_ows' => basename($path),
                        'status5' => 'on review',
                        'time_upload5' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile6')) {
                $file1 = $request->file('beraufile6');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pnbp_garis_muat';
                $path = $request->file('beraufile6')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'pnbp_garis_muat' => basename($path),
                        'status6' => 'on review',
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'pnbp_garis_muat' => basename($path),
                        'status6' => 'on review',
                        'time_upload6' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile7')) {
                $file1 = $request->file('beraufile7');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pnbp_pemeriksaan_endorse_sl';
                $path = $request->file('beraufile7')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'pnbp_pemeriksaan_endorse_sl' => basename($path),
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'pnbp_pemeriksaan_endorse_sl' => basename($path),
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile8')) {
                $file1 = $request->file('beraufile8');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pemeriksaan_sertifikat';
                $path = $request->file('beraufile8')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'pemeriksaan_sertifikat' => basename($path),
                        'status8' => 'on review',
                        'time_upload8' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'pemeriksaan_sertifikat' => basename($path),
                        'status8' => 'on review',
                        'time_upload8' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile9')) {
                $file1 = $request->file('beraufile9');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/marine_inspektor';
                $path = $request->file('beraufile9')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'marine_inspektor' => basename($path),
                        'status9' => 'on review',
                        'time_upload9' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'marine_inspektor' => basename($path),
                        'status9' => 'on review',
                        'time_upload9' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile10')) {
                $file1 = $request->file('beraufile10');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/biaya_clearance';
                $path = $request->file('beraufile10')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'biaya_clearance' => basename($path),
                        'status10' => 'on review',
                        'time_upload10' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'biaya_clearance' => basename($path),
                        'status10' => 'on review',
                        'time_upload10' => date("Y-m-d"),
                    ]);
                }
            }          
            if ($request->hasFile('beraufile11')) {
                $file1 = $request->file('beraufile11');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pnbp_master_cable';
                $path = $request->file('beraufile11')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'pnbp_master_cable' => basename($path),
                        'status11' => 'on review',
                        'time_upload11' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'pnbp_master_cable' => basename($path),
                        'status11' => 'on review',
                        'time_upload11' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile12')) {
                $file1 = $request->file('beraufile12');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/cover_deck_logbook';
                $path = $request->file('beraufile12')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'cover_deck_logbook' => basename($path),
                        'status12' => 'on review',
                        'time_upload12' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'cover_deck_logbook' => basename($path),
                        'status12' => 'on review',
                        'time_upload12' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile13')) {
                $file1 = $request->file('beraufile13');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/cover_engine_logbook';
                $path = $request->file('beraufile13')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'cover_engine_logbook' => basename($path),
                        'status13' => 'on review',
                        'time_upload13' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'cover_engine_logbook' => basename($path),
                        'status13' => 'on review',
                        'time_upload13' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile14')) {
                $file1 = $request->file('beraufile14');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/exibitum_dect_logbook';
                $path = $request->file('beraufile14')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'exibitum_dect_logbook' => basename($path),
                        'status14' => 'on review',
                        'time_upload14' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'exibitum_dect_logbook' => basename($path),
                        'status14' => 'on review',
                        'time_upload14' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile15')) {
                $file1 = $request->file('beraufile15');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/exibitum_engine_logbook';
                $path = $request->file('beraufile15')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'exibitum_engine_logbook' => basename($path),
                        'status15' => 'on review',
                        'time_upload15' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'exibitum_engine_logbook' => basename($path),
                        'status15' => 'on review',
                        'time_upload15' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile16')) {
                $file1 = $request->file('beraufile16');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pnbp_deck_logbook';
                $path = $request->file('beraufile16')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'pnbp_deck_logbook' => basename($path),
                        'status16' => 'on review',
                        'time_upload16' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'pnbp_deck_logbook' => basename($path),
                        'status16' => 'on review',
                        'time_upload16' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile17')) {
                $file1 = $request->file('beraufile17');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pnbp_engine_logbook';             
                $path = $request->file('beraufile17')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([
                        'status17' => 'on review',
                        'time_upload17' => date("Y-m-d"),
                        'pnbp_engine_logbook' => basename($path),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
    
                        'status17' => 'on review',
                        'time_upload17' => date("Y-m-d"),
                        'pnbp_engine_logbook' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('beraufile18')) {
                $file1 = $request->file('beraufile18');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/biaya_docking';
                $path = $request->file('beraufile18')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'biaya_docking' => basename($path),
                        'status18' => 'on review',
                        'time_upload18' => date("Y-m-d"),
                    ]);
                }else {
                    documentberau::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'biaya_docking' => basename($path),
                        'status18' => 'on review',
                        'time_upload18' => date("Y-m-d"),
                    ]);
                }
            }
            if ($request->hasFile('beraufile19')) {
                $file1 = $request->file('beraufile19');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/lain-lain';
                $path = $request->file('beraufile19')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'lain-lain' => basename($path),
                        'status19' => 'on review',
                        'time_upload19' => date("Y-m-d"),]); 
                }else {
                    documentberau::create([                   
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,


                        'lain-lain' => basename($path),
                        'status19' => 'on review',
                        'time_upload19' => date("Y-m-d"),
                    ]);
                }
            }
                if ($request->hasFile('beraufile20')) {
                $file1 = $request->file('beraufile20');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/biaya_labuh_tambat';
                $path = $request->file('beraufile20')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'biaya_labuh_tambat' => basename($path),
                        'status20' => 'on review',
                        'time_upload20' => date("Y-m-d"),]);
                }else {
                    documentberau::create([                   
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
            
                        'biaya_labuh_tambat' => basename($path),
   
                        'status20' => 'on review',
                        'time_upload20' => date("Y-m-d"),
                    ]);
                }
            }
                if ($request->hasFile('beraufile21')) {
                $file1 = $request->file('beraufile21');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/biaya_rambu';
                $path = $request->file('beraufile21')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'biaya_rambu' => basename($path),
                        'status21' => 'on review',
                        'time_upload20' => date("Y-m-d"),]);
                }else {
                    documentberau::create([                   
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'biaya_rambu' => basename($path),
                        'status21' => 'on review',
                        'time_upload20' => date("Y-m-d"),
                    ]);
                }
            }
                if ($request->hasFile('beraufile22')) {
                $file1 = $request->file('beraufile22');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pnbp_pemeriksaan';
                $path = $request->file('beraufile22')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'pnbp_pemeriksaan' => basename($path),
                        'status22' => 'on review',
                        'time_upload22' => date("Y-m-d"),]);
                }else {
                    documentberau::create([                   
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,


                        'pnbp_pemeriksaan' => basename($path),
                        'status22' => 'on review',
                        'time_upload22' => date("Y-m-d"),
                    ]);
                }
            }
                if ($request->hasFile('beraufile23')) {
                $file1 = $request->file('beraufile23');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/sertifikat_bebas_sanitasi&p3k';
                $path = $request->file('beraufile23')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'sertifikat_bebas_sanitasi&p3k' => basename($path),
                        'status23' => 'on review',
                        'time_upload23' => date("Y-m-d"),]);
                }else {
                    documentberau::create([                   
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,


                        'sertifikat_bebas_sanitasi&p3k' => basename($path),
                        'status23' => 'on review',
                        'time_upload23' => date("Y-m-d"),
                    ]);
                }
            }
                if ($request->hasFile('beraufile24')) {
                $file1 = $request->file('beraufile24');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/sertifikat_garis_muat';
                $path = $request->file('beraufile25')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'sertifikat_garis_muat' => basename($path),
                        'status24' => 'on review',
                        'time_upload24' => date("Y-m-d"),]);
                }else {
                    documentberau::create([                   
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'sertifikat_garis_muat' => basename($path),
                        'status24' => 'on review',
                        'time_upload24' => date("Y-m-d"),
                    ]);
                }
            }
                if ($request->hasFile('beraufile25')) {
                $file1 = $request->file('beraufile25');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/ijin_sekali_jalan';
                $path = $request->file('beraufile25')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'ijin_sekali_jalan' => basename($path),
                        'status25' => 'on review',
                        'time_upload25' => date("Y-m-d"),]);
                }else {
                    documentberau::create([                   
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
    

                        'ijin_sekali_jalan' => basename($path),
                        'status25' => 'on review',
                        'time_upload25' => date("Y-m-d"),
                    ]);
                }
            }
                if ($request->hasFile('beraufile26')) {
                $file1 = $request->file('beraufile26');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'berau/pnpb_sscec';
                $path = $request->file('beraufile26')->storeas('berau/'. $year . "/". $month , $name1, 's3');
                if (documentberau::where('cabang', 'Berau')->whereMonth('created_at', date('m'))->exists()){
                documentberau::where('cabang', 'Berau' )->update([                   
                        'pnpb_sscec' => basename($path),
                        'status26' => 'on review',
                        'time_upload26' => date("Y-m-d"),]);
                }else {
                    documentberau::create([                   
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
    

                        'pnpb_sscec' => basename($path),
                        'status26' => 'on review',
                        'time_upload26' => date("Y-m-d"),
                    ]);
                }
            }
            return redirect('/picsite/upload')->with('success', 'Upload success!');
        }
            
        if (Auth::user()->cabang == 'Banjarmasin') {
            $year = date('Y');
            $month = date('m');
            $request->validate([
                //Banjarmasin
                'banjarmasinfile1'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile2'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile3'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile4'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile5'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile6'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile7'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile8'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile9'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile10'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile11'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile12'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile13'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile14'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile15'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile16'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile17'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile18'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile19'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile20'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile21'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile22'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile23'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile24'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile25'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile26'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile27'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile28'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile29'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile30'=> 'mimes:pdf|max:3072' ,
                'banjarmasinfile31'=> 'mimes:pdf|max:3072' ,
            ]);
            
            if ($request->hasFile('banjarmasinfile1')) {
                $file1 = $request->file('banjarmasinfile1');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/perjalanan';
                $path = $request->file('banjarmasinfile1')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status1' => 'on review',
                        'time_upload1' => date("Y-m-d"),
                        'perjalanan' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status1' => 'on review',
                        'time_upload1' => date("Y-m-d"),
                        'perjalanan' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile2')) {
                $file1 = $request->file('banjarmasinfile2');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/sertifikat_keselamatan';
                $path = $request->file('banjarmasinfile2')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
               if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                
                    documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status2' => 'on review',
                        'time_upload2' => date("Y-m-d"),
                        'sertifikat_keselamatan' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                       'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status2' => 'on review',
                        'time_upload2' => date("Y-m-d"),
                        'sertifikat_keselamatan' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile3')) {
                $file1 = $request->file('banjarmasinfile3');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/sertifikat_anti_fauling';
                $path = $request->file('banjarmasinfile3')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
               if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                
                    documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status3' => 'on review',
                        'time_upload3' => date("Y-m-d"),
                        'sertifikat_anti_fauling' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                       'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status3' => 'on review',
                        'time_upload3' => date("Y-m-d"),
                        'sertifikat_anti_fauling' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile4')) {
                $file1 = $request->file('banjarmasinfile4');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/surveyor';
                $path = $request->file('banjarmasinfile4')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
               if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                
                    documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status4' => 'on review',
                        'time_upload4' => date("Y-m-d"),      
                        'surveyor' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                       'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status4' => 'on review',
                        'time_upload4' => date("Y-m-d"),      
                        'surveyor' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile5')) {
                $file1 = $request->file('banjarmasinfile5');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/drawing&stability';
                $path = $request->file('banjarmasinfile5')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
               if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                
                    documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status5' => 'on review',
                        'time_upload5' => date("Y-m-d"),        
                        'drawing&stability' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                       'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status5' => 'on review',
                        'time_upload5' => date("Y-m-d"),        
                        'drawing&stability' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile6')) {
                $file1 = $request->file('banjarmasinfile6');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/laporan_pengeringan';
                $path = $request->file('banjarmasinfile6')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
               if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                
                    documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status6' => 'on review',
                        'time_upload6' => date("Y-m-d"),       
                        'laporan_pengeringan' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                       'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status6' => 'on review',
                        'time_upload6' => date("Y-m-d"),       
                        'laporan_pengeringan' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile7')) {
                $file1 = $request->file('banjarmasinfile7');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/laporan_pemeriksaan_nautis';
                $path = $request->file('banjarmasinfile7')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
               if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                
                    documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),   
                        'laporan_pemeriksaan_nautis' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                       'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),   
                        'laporan_pemeriksaan_nautis' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile8')) {
                $file1 = $request->file('banjarmasinfile8');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/laporan_pemeriksaan_anti_faulin';
                $path = $request->file('banjarmasinfile8')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
               if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                
                    documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status8' => 'on review',
                        'time_upload8' => date("Y-m-d"),      
                        'laporan_pemeriksaan_anti_faulin' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                       'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status8' => 'on review',
                        'time_upload8' => date("Y-m-d"),      
                        'laporan_pemeriksaan_anti_faulin' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile9')) {
                $file1 = $request->file('banjarmasinfile9');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/laporan_pemeriksaan_radio';
                $path = $request->file('banjarmasinfile9')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
               if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                
                    documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status9' => 'on review',
                        'time_upload9' => date("Y-m-d"),       
                        'laporan_pemeriksaan_radio' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status9' => 'on review',
                        'time_upload9' => date("Y-m-d"),       
                        'laporan_pemeriksaan_radio' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile10')) {
                $file1 = $request->file('banjarmasinfile10');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/berita_acara_lambung';
                $path = $request->file('banjarmasinfile10')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status10' => 'on review',
                        'time_upload10' => date("Y-m-d"),
                        'berita_acara_lambung' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status10' => 'on review',
                        'time_upload10' => date("Y-m-d"),
                        'berita_acara_lambung' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile11')) {
                $file1 = $request->file('banjarmasinfile11');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/laporan_pemeriksaan_snpp';
                $path = $request->file('banjarmasinfile11')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status11' => 'on review',
                        'time_upload11' => date("Y-m-d"),
                        'laporan_pemeriksaan_snpp' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status11' => 'on review',
                        'time_upload11' => date("Y-m-d"),
                        'laporan_pemeriksaan_snpp' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile12')) {
                $file1 = $request->file('banjarmasinfile12');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/bki';
                $path = $request->file('banjarmasinfile12')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status12' => 'on review',
                        'time_upload12' => date("Y-m-d"),
                        'bki' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status12' => 'on review',
                        'time_upload12' => date("Y-m-d"),
                        'bki' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile13')) {
                $file1 = $request->file('banjarmasinfile13');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/snpp_permanen';
                $path = $request->file('banjarmasinfile13')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status13' => 'on review',
                        'time_upload13' => date("Y-m-d"),
                        'snpp_permanen' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status13' => 'on review',
                        'time_upload13' => date("Y-m-d"),
                        'snpp_permanen' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile14')) {
                $file1 = $request->file('banjarmasinfile14');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/snpp_endorse';
                $path = $request->file('banjarmasinfile14')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status14' => 'on review',
                        'time_upload14' => date("Y-m-d"),
                        'snpp_endorse' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status14' => 'on review',
                        'time_upload14' => date("Y-m-d"),
                        'snpp_endorse' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile15')) {
                $file1 = $request->file('banjarmasinfile15');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/surat_laut_endorse';
                $path = $request->file('banjarmasinfile15')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status15' => 'on review',
                        'time_upload15' => date("Y-m-d"),
                        'surat_laut_endorse' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status15' => 'on review',
                        'time_upload15' => date("Y-m-d"),
                        'surat_laut_endorse' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile16')) {
                $file1 = $request->file('banjarmasinfile16');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/surat_laut_permanen';
                $path = $request->file('banjarmasinfile16')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status16' => 'on review',
                        'time_upload16' => date("Y-m-d"),
                        'surat_laut_permanen' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status16' => 'on review',
                        'time_upload16' => date("Y-m-d"),
                        'surat_laut_permanen' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile17')) {
                $file1 = $request->file('banjarmasinfile17');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/compas_seren';
                $path = $request->file('banjarmasinfile17')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status17' => 'on review',
                        'time_upload17' => date("Y-m-d"),
                        'compas_seren' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status17' => 'on review',
                        'time_upload17' => date("Y-m-d"),
                        'compas_seren' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile18')) {
                $file1 = $request->file('banjarmasinfile18');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/keselamatan_(tahunan)';
                $path = $request->file('banjarmasinfile18')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status18' => 'on review',
                        'time_upload18' => date("Y-m-d"),
                        'keselamatan_(tahunan)' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status18' => 'on review',
                        'time_upload18' => date("Y-m-d"),
                        'keselamatan_(tahunan)' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile19')) {
                $file1 = $request->file('banjarmasinfile19');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/keselamatan_(pengaturan_dok)';
                $path = $request->file('banjarmasinfile19')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status19' => 'on review',
                        'time_upload19' => date("Y-m-d"),
                        'keselamatan_(pengaturan_dok)' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status19' => 'on review',
                        'time_upload19' => date("Y-m-d"),
                        'keselamatan_(pengaturan_dok)' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile20')) {
                $file1 = $request->file('banjarmasinfile20');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/keselamatan_(dok)';
                $path = $request->file('banjarmasinfile20')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status20' => 'on review',
                        'time_upload20' => date("Y-m-d"),
                        'keselamatan_(dok)' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status20' => 'on review',
                        'time_upload20' => date("Y-m-d"),
                        'keselamatan_(dok)' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile21')) {
                $file1 = $request->file('banjarmasinfile21');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/garis_muat';
                $path = $request->file('banjarmasinfile21')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status21' => 'on review',
                        'time_upload21' => date("Y-m-d"),
                        'garis_muat' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status21' => 'on review',
                        'time_upload21' => date("Y-m-d"),
                        'garis_muat' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile22')) {
                $file1 = $request->file('banjarmasinfile22');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/dispensasi_isr';
                $path = $request->file('banjarmasinfile22')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status22' => 'on review',
                        'time_upload22' => date("Y-m-d"),
                        'dispensasi_isr' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status22' => 'on review',
                        'time_upload22' => date("Y-m-d"),
                        'dispensasi_isr' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile23')) {
                $file1 = $request->file('banjarmasinfile23');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/life_raft_1_2_pemadam';
                $path = $request->file('banjarmasinfile23')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status23' => 'on review',
                        'time_upload23' => date("Y-m-d"),
                        'life_raft_1_2_pemadam' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status23' => 'on review',
                        'time_upload23' => date("Y-m-d"),
                        'life_raft_1_2_pemadam' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile24')) {
                $file1 = $request->file('banjarmasinfile24');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/sscec';
                $path = $request->file('banjarmasinfile24')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status24' => 'on review',
                        'time_upload24' => date("Y-m-d"),
                        'sscec' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status24' => 'on review',
                        'time_upload24' => date("Y-m-d"),
                        'sscec' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile25')) {
                $file1 = $request->file('banjarmasinfile25');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/seatrail';
                $path = $request->file('banjarmasinfile25')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status25' => 'on review',
                        'time_upload25' => date("Y-m-d"),
                        'seatrail' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status25' => 'on review',
                        'time_upload25' => date("Y-m-d"),
                        'seatrail' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile26')) {
                $file1 = $request->file('banjarmasinfile26');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/laporan_pemeriksaan_umum';
                $path = $request->file('banjarmasinfile26')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status26' => 'on review',
                        'time_upload26' => date("Y-m-d"),
                        'laporan_pemeriksaan_umum' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status26' => 'on review',
                        'time_upload26' => date("Y-m-d"),
                        'laporan_pemeriksaan_umum' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile27')) {
                $file1 = $request->file('banjarmasinfile27');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/laporan_pemeriksaan_mesin';
                $path = $request->file('banjarmasinfile27')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status27' => 'on review',
                        'time_upload27' => date("Y-m-d"),
                        'laporan_pemeriksaan_mesin' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status27' => 'on review',
                        'time_upload27' => date("Y-m-d"),
                        'laporan_pemeriksaan_mesin' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile28')) {
                $file1 = $request->file('banjarmasinfile28');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/nota_dinas_perubahan_kawasan';
                $path = $request->file('banjarmasinfile28')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status28' => 'on review',
                        'time_upload28' => date("Y-m-d"),
                        'nota_dinas_perubahan_kawasan' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status28' => 'on review',
                        'time_upload28' => date("Y-m-d"),
                        'nota_dinas_perubahan_kawasan' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile29')) {
                $file1 = $request->file('banjarmasinfile29');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/PAS';
                $path = $request->file('banjarmasinfile29')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status29' => 'on review',
                        'time_upload29' => date("Y-m-d"),
                        'PAS' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status29' => 'on review',
                        'time_upload29' => date("Y-m-d"),
                        'PAS' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile30')) {
                $file1 = $request->file('banjarmasinfile30');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/invoice_bki';
                $path = $request->file('banjarmasinfile30')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status30' => 'on review',
                        'time_upload30' => date("Y-m-d"),
                        'invoice_bki' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status30' => 'on review',
                        'time_upload30' => date("Y-m-d"),
                        'invoice_bki' => basename($path),
                    ]);
                }
            }
            if ($request->hasFile('banjarmasinfile31')) {
                $file1 = $request->file('banjarmasinfile31');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'banjarmasin/safe_manning';
                $path = $request->file('banjarmasinfile31')->storeas('banjarmasin/'. $year . "/". $month , $name1, 's3');
                if (documentbanjarmasin::where('cabang', 'Banjarmasin')->whereMonth('created_at', date('m'))->exists()){
                        documentbanjarmasin::where('cabang', 'Banjarmasin' )->update([
                        'status31' => 'on review',
                        'time_upload31' => date("Y-m-d"),
                        'safe_manning' => basename($path),]);
                    }else{
                        documentbanjarmasin::create([
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status31' => 'on review',
                        'time_upload31' => date("Y-m-d"),
                        'safe_manning' => basename($path),
                    ]);
                }
            }
            return redirect('/picsite/upload')->with('success', 'Upload success!');
        }
            
        if (Auth::user()->cabang == 'Samarinda') {
            $year = date('Y');
            $month = date('m');
            //Samarinda
            $request->validate([
                'samarindafile1' => 'mimes:pdf|max:3072' , 
                'samarindafile2' => 'mimes:pdf|max:3072' ,
                'samarindafile3' => 'mimes:pdf|max:3072' ,
                'samarindafile4' => 'mimes:pdf|max:3072' ,
                'samarindafile5' => 'mimes:pdf|max:3072' ,
                'samarindafile6' => 'mimes:pdf|max:3072' ,
                'samarindafile7' => 'mimes:pdf|max:3072' ,
                'samarindafile8' => 'mimes:pdf|max:3072' ,
                'samarindafile9' => 'mimes:pdf|max:3072' ,
                'samarindafile10'=> 'mimes:pdf|max:3072' ,
                'samarindafile11'=> 'mimes:pdf|max:3072' ,
                'samarindafile12'=> 'mimes:pdf|max:3072' ,
                'samarindafile13'=> 'mimes:pdf|max:3072' ,
                'samarindafile14'=> 'mimes:pdf|max:3072' ,
                'samarindafile15'=> 'mimes:pdf|max:3072' ,
                'samarindafile16'=> 'mimes:pdf|max:3072' ,
                'samarindafile17'=> 'mimes:pdf|max:3072' ,
                'samarindafile18'=> 'mimes:pdf|max:3072' ,
                'samarindafile19'=> 'mimes:pdf|max:3072' ,
                'samarindafile20'=> 'mimes:pdf|max:3072' ,
                'samarindafile21'=> 'mimes:pdf|max:3072' ,
                'samarindafile22'=> 'mimes:pdf|max:3072' ,
                'samarindafile23'=> 'mimes:pdf|max:3072' ,
                'samarindafile24'=> 'mimes:pdf|max:3072' ,
                'samarindafile25'=> 'mimes:pdf|max:3072' ,
                'samarindafile26'=> 'mimes:pdf|max:3072' ,
                'samarindafile27'=> 'mimes:pdf|max:3072' ,
                'samarindafile28'=> 'mimes:pdf|max:3072' ,
                'samarindafile29'=> 'mimes:pdf|max:3072' ,
                'samarindafile30'=> 'mimes:pdf|max:3072' ,
                'samarindafile31'=> 'mimes:pdf|max:3072' ,
                'samarindafile32'=> 'mimes:pdf|max:3072' ,
                'samarindafile33'=> 'mimes:pdf|max:3072' ,
                'samarindafile34'=> 'mimes:pdf|max:3072' ,
                'samarindafile35'=> 'mimes:pdf|max:3072' ,
                'samarindafile36'=> 'mimes:pdf|max:3072' ,
                'samarindafile37'=> 'mimes:pdf|max:3072' ,
                'samarindafile38'=> 'mimes:pdf|max:3072' ,
            ]);
            if ($request->hasFile('samarindafile1')) {
                $file1 = $request->file('samarindafile1');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/sertifikat_keselamatan(perpanjangan)';
                $path = $request->file('samarindafile1')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()) {
                        documentsamarinda::where('cabang', 'Samarinda')->update([
                            'status1' => 'on review',
                            'time_upload1' => date("Y-m-d"),
                            'sertifikat_keselamatan(perpanjangan)' => basename($path),]);
                }else{
                    documentsamarinda::create([
                            'cabang' => Auth::user()->cabang ,
                            'user_id' => Auth::user()->id,

                            'status1' => 'on review',
                            'time_upload1' => date("Y-m-d"),
                            'sertifikat_keselamatan(perpanjangan)' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile2')) {
            $file1 = $request->file('samarindafile2');
            $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
            $tujuan_upload = 'samarinda/perubahan_ok_13_ke_ok_1';
                $path = $request->file('samarindafile2')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
            if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                documentsamarinda::where('cabang', 'Samarinda')->update([
                        'status2' => 'on review',
                        'time_upload2' => date("Y-m-d"),
                        'perubahan_ok_13_ke_ok_1' => basename($path),]);
            }else{
                documentsamarinda::create([
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,
                            
                    'status2' => 'on review',
                    'time_upload2' => date("Y-m-d"),
                    'perubahan_ok_13_ke_ok_1' => basename($path),]);
            }
            }
            if ($request->hasFile('samarindafile3')) {
                $file1 = $request->file('samarindafile3');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/keselamatan_(tahunan)';
                $path = $request->file('samarindafile3')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status3' => 'on review',
                            'time_upload3' => date("Y-m-d"),
                            'keselamatan_(tahunan)' => basename($path),]);
                }else{
                    documentsamarinda::create([  
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                            
                        'status3' => 'on review',
                        'time_upload3' => date("Y-m-d"),
                        'keselamatan_(tahunan)' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile4')) {
                $file1 = $request->file('samarindafile4');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/keselamatan_(dok)';
                $path = $request->file('samarindafile4')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status4' => 'on review',
                            'time_upload4' => date("Y-m-d"),
                            'keselamatan_(dok)' => basename($path),]);
                            
                }else{
                    documentsamarinda::create([  
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                            
                        'status4' => 'on review',
                        'time_upload4' => date("Y-m-d"),
                        'keselamatan_(dok)' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile5')) {
                $file1 = $request->file('samarindafile5');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/keselamatan_(pengaturan_dok)';
                $path = $request->file('samarindafile5')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status5' => 'on review',
                            'time_upload5' => date("Y-m-d"),
                            'keselamatan_(pengaturan_dok)' => basename($path),]);
                }else{
                    documentsamarinda::create([  
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                            
                        'status5' => 'on review',
                        'time_upload5' => date("Y-m-d"),
                        'keselamatan_(pengaturan_dok)' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile6')) {
                $file1 = $request->file('samarindafile6');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/keselamatan_(penundaan_dok)';
                $path = $request->file('samarindafile6')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status6' => 'on review',
                            'time_upload6' => date("Y-m-d"),
                            'keselamatan_(penundaan_dok)' => basename($path),]);
                }else{
                    documentsamarinda::create([  
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                            
                        'status6' => 'on review',
                        'time_upload6' => date("Y-m-d"),
                        'keselamatan_(penundaan_dok)' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile7')) {
                $file1 = $request->file('samarindafile7');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/sertifikat_garis_muat';
                $path = $request->file('samarindafile7')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status7' => 'on review',
                            'time_upload7' => date("Y-m-d"),
                            'sertifikat_garis_muat' => basename($path),]);
                }else{
                    documentsamarinda::create([  
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                            
                        'status7' => 'on review',
                        'time_upload7' => date("Y-m-d"),
                        'sertifikat_garis_muat' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile8')) {
                $file1 = $request->file('samarindafile8');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/laporan_pemeriksaan_garis_muat';
                $path = $request->file('samarindafile8')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status8' => 'on review',
                            'time_upload8' => date("Y-m-d"),
                            'laporan_pemeriksaan_garis_muat' => basename($path),]);
                }else{
                    documentsamarinda::create([  
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,
                            
                        'status8' => 'on review',
                        'time_upload8' => date("Y-m-d"),
                        'laporan_pemeriksaan_garis_muat' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile9')) {
                    $file1 = $request->file('samarindafile9');
                    $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                    $tujuan_upload = 'samarinda/sertifikat_anti_fauling';
                        $path = $request->file('samarindafile9')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                    if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                            documentsamarinda::where('cabang', 'Samarinda')->update([  
                        'status9' => 'on review',
                        'time_upload9' => date("Y-m-d"),
                        'sertifikat_anti_fauling' => basename($path),]);
                    }else{
                        documentsamarinda::create([  
                            'cabang' => Auth::user()->cabang ,
                            'user_id' => Auth::user()->id,

                            'status9' => 'on review',
                            'time_upload9' => date("Y-m-d"),
                            'sertifikat_anti_fauling' => basename($path),]);
                    }
            }
            if ($request->hasFile('samarindafile10')) {
                $file1 = $request->file('samarindafile10');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/surat_laut_permanen';
                $path = $request->file('samarindafile10')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status10' => 'on review',
                            'time_upload10' => date("Y-m-d"),
                            'surat_laut_permanen' => basename($path),]);
                }else{
                    documentsamarinda::create([  
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status10' => 'on review',
                        'time_upload10' => date("Y-m-d"),
                        'surat_laut_permanen' => basename($path),]);
                    }
            }
            if ($request->hasFile('samarindafile11')) {
                $file1 = $request->file('samarindafile11');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/surat_laut_endorse';
                $path = $request->file('samarindafile11')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status11' => 'on review',
                            'time_upload11' => date("Y-m-d"),
                            'surat_laut_endorse' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status11' => 'on review',
                    'time_upload11' => date("Y-m-d"),
                    'surat_laut_endorse' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile12')) {
                    $file1 = $request->file('samarindafile12');
                    $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                    $tujuan_upload = 'samarinda/call_sign';
                $path = $request->file('samarindafile12')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                    if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                            documentsamarinda::where('cabang', 'Samarinda')->update([  
                                'status12' => 'on review',
                                'time_upload12' => date("Y-m-d"),
                                'call_sign' => basename($path),]);
                    }else{
                        documentsamarinda::create([  
                            'cabang' => Auth::user()->cabang ,
                            'user_id' => Auth::user()->id,
                            
                            'status12' => 'on review',
                            'time_upload12' => date("Y-m-d"),
                            'call_sign' => basename($path),]);
                        }
            }
            if ($request->hasFile('samarindafile13')) {
                    $file1 = $request->file('samarindafile13');
                    $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                    $tujuan_upload = 'samarinda/perubahan_sertifikat_keselamatan';
                $path = $request->file('samarindafile13')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                    if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                            documentsamarinda::where('cabang', 'Samarinda')->update([  
                                'status13' => 'on review',
                                'time_upload13' => date("Y-m-d"),
                                'perubahan_sertifikat_keselamatan' => basename($path),]);
                    }else{
                        documentsamarinda::create([  
                            'cabang' => Auth::user()->cabang ,
                            'user_id' => Auth::user()->id,

                            'status13' => 'on review',
                            'time_upload13' => date("Y-m-d"),
                            'perubahan_sertifikat_keselamatan' => basename($path),]);
                        }
            }
            if ($request->hasFile('samarindafile14')) {
                    $file1 = $request->file('samarindafile14');
                    $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                    $tujuan_upload = 'samarinda/perubahan_kawasan_tanpa_notadin';
                $path = $request->file('samarindafile14')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                    if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                            documentsamarinda::where('cabang', 'Samarinda')->update([  
                                'status14' => 'on review',
                                'time_upload14' => date("Y-m-d"),
                                'perubahan_kawasan_tanpa_notadin' => basename($path),]);
                    }else{
                        documentsamarinda::create([  
                            'cabang' => Auth::user()->cabang ,
                            'user_id' => Auth::user()->id,

                            'status14' => 'on review',
                            'time_upload14' => date("Y-m-d"),
                            'perubahan_kawasan_tanpa_notadin' => basename($path),]);
                        }
            }
            if ($request->hasFile('samarindafile15')) {
                    $file1 = $request->file('samarindafile15');
                    $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                    $tujuan_upload = 'samarinda/snpp_permanen';
                $path = $request->file('samarindafile15')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                    if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                            documentsamarinda::where('cabang', 'Samarinda')->update([  
                                'status15' => 'on review',
                                'time_upload15' => date("Y-m-d"),
                                'snpp_permanen' => basename($path),]);
                    }else{
                        documentsamarinda::create([  
                            'cabang' => Auth::user()->cabang ,
                            'user_id' => Auth::user()->id,

                            'status15' => 'on review',
                            'time_upload15' => date("Y-m-d"),
                            'snpp_permanen' => basename($path),]);
                        }
            }
            if ($request->hasFile('samarindafile16')) {
                $file1 = $request->file('samarindafile16');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/snpp_endorse';
                $path = $request->file('samarindafile16')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status16' => 'on review',
                            'time_upload16' => date("Y-m-d"),
                            'snpp_endorse' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status16' => 'on review',
                    'time_upload16' => date("Y-m-d"),
                    'snpp_endorse' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile17')) {
                $file1 = $request->file('samarindafile17');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/laporan_pemeriksaan_snpp';
                $path = $request->file('samarindafile17')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status17' => 'on review',
                            'time_upload17' => date("Y-m-d"),
                            'laporan_pemeriksaan_snpp' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status17' => 'on review',
                    'time_upload17' => date("Y-m-d"),
                    'laporan_pemeriksaan_snpp' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile18')) {
                $file1 = $request->file('samarindafile18');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/laporan_pemeriksaan_keselamatan';
                $path = $request->file('samarindafile18')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status18' => 'on review',
                            'time_upload18' => date("Y-m-d"),
                            'laporan_pemeriksaan_keselamatan' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status18' => 'on review',
                    'time_upload18' => date("Y-m-d"),
                    'laporan_pemeriksaan_keselamatan' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile19')) {
                $file1 = $request->file('samarindafile19');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/buku_kesehatan';
                $path = $request->file('samarindafile19')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status19' => 'on review',
                            'time_upload19' => date("Y-m-d"),
                            'buku_kesehatan' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status19' => 'on review',
                    'time_upload19' => date("Y-m-d"),
                    'buku_kesehatan' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile20')) {
                $file1 = $request->file('samarindafile20');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/sertifikat_sanitasi_water&p3k';
                $path = $request->file('samarindafile20')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status20' => 'on review',
                            'time_upload20' => date("Y-m-d"),
                            'sertifikat_sanitasi_water&p3k' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status20' => 'on review',
                    'time_upload20' => date("Y-m-d"),
                    'sertifikat_sanitasi_water&p3k' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile21')) {
            $file1 = $request->file('samarindafile21');
            $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
            $tujuan_upload = 'samarinda/pengaturan_non_ke_klas_bki';
            $path = $request->file('samarindafile21')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
            if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
            documentsamarinda::where('cabang', 'Samarinda')->update([  
                        'status21' => 'on review',
                        'time_upload21' => date("Y-m-d"),
                        'pengaturan_non_ke_klas_bki' => basename($path),]);
            }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status21' => 'on review',
                    'time_upload21' => date("Y-m-d"),
                    'pengaturan_non_ke_klas_bki' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile22')) {
                $file1 = $request->file('samarindafile22');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/pengaturan_klas_bki_(dok_ss)';
                $path = $request->file('samarindafile22')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status22' => 'on review',
                            'time_upload22' => date("Y-m-d"),
                            'pengaturan_klas_bki_(dok_ss)' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status22' => 'on review',
                    'time_upload22' => date("Y-m-d"),
                    'pengaturan_klas_bki_(dok_ss)' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile23')) {
                $file1 = $request->file('samarindafile23');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/surveyor_endorse_tahunan_bki';
                $path = $request->file('samarindafile23')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status23' => 'on review',
                            'time_upload23' => date("Y-m-d"),
                            'surveyor_endorse_tahunan_bki' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status23' => 'on review',
                    'time_upload23' => date("Y-m-d"),
                    'surveyor_endorse_tahunan_bki' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile24')) {
                $file1 = $request->file('samarindafile24');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/pr_supplier_bki';
                $path = $request->file('samarindafile24')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status24' => 'on review',
                            'time_upload24' => date("Y-m-d"),
                            'pr_supplier_bki' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status24' => 'on review',
                    'time_upload24' => date("Y-m-d"),
                    'pr_supplier_bki' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile25')) {
                $file1 = $request->file('samarindafile25');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/balik_nama_grosse';
                $path = $request->file('samarindafile25')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status25' => 'on review',
                            'time_upload25' => date("Y-m-d"),
                            'balik_nama_grosse' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status25' => 'on review',
                    'time_upload25' => date("Y-m-d"),
                    'balik_nama_grosse' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile26')) {
                $file1 = $request->file('samarindafile26');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/kapal_baru_body_(set_dokumen)';
                $path = $request->file('samarindafile26')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status26' => 'on review',
                            'time_upload26' => date("Y-m-d"),
                            'kapal_baru_body_(set_dokumen)' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status26' => 'on review',
                    'time_upload26' => date("Y-m-d"),
                    'kapal_baru_body_(set_dokumen)' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile27')) {
                $file1 = $request->file('samarindafile27');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/halaman_tambahan_grosse';
                $path = $request->file('samarindafile27')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status27' => 'on review',
                            'time_upload27' => date("Y-m-d"),
                            'halaman_tambahan_grosse' => basename($path),]);
                }else{
                    documentsamarinda::create([  
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status27' => 'on review',
                        'time_upload27' => date("Y-m-d"),
                        'halaman_tambahan_grosse' => basename($path),]);
                    }
            }
            if ($request->hasFile('samarindafile28')) {
                $file1 = $request->file('samarindafile28');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/pnbp&pup';
                $path = $request->file('samarindafile28')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status28' => 'on review',
                            'time_upload28' => date("Y-m-d"),
                            'pnbp&pup' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status28' => 'on review',
                    'time_upload28' => date("Y-m-d"),
                    'pnbp&pup' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile29')) {
                $file1 = $request->file('samarindafile29');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/laporan_pemeriksaan_anti_teriti';
                $path = $request->file('samarindafile29')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status29' => 'on review',
                            'time_upload29' => date("Y-m-d"),
                            'laporan_pemeriksaan_anti_teriti' => basename($path),]);
                }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status29' => 'on review',
                    'time_upload29' => date("Y-m-d"),
                    'laporan_pemeriksaan_anti_teriti' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile30')) {
            $file1 = $request->file('samarindafile30');
            $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
            $tujuan_upload = 'samarinda/surveyor_pengedokan';
            $path = $request->file('samarindafile30')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
            if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
            documentsamarinda::where('cabang', 'Samarinda')->update([  
                        'status30' => 'on review',
                        'time_upload30' => date("Y-m-d"),
                        'surveyor_pengedokan' => basename($path),]);
                        
            }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,
                    
                    'status30' => 'on review',
                    'time_upload30' => date("Y-m-d"),
                    'surveyor_pengedokan' => basename($path),]);
                }
            }
            if ($request->hasFile('samarindafile31')) {
                $file1 = $request->file('samarindafile31');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/surveyor_penerimaan_klas_bki';
                $path = $request->file('samarindafile31')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status31' => 'on review',
                            'time_upload31' => date("Y-m-d"),
                            'surveyor_penerimaan_klas_bki' => basename($path),]);   
                }else{
                    documentsamarinda::create([  
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status31' => 'on review',
                        'time_upload31' => date("Y-m-d"),
                        'surveyor_penerimaan_klas_bki' => basename($path),]);
                    }
            }
            if ($request->hasFile('samarindafile32')) {
                $file1 = $request->file('samarindafile32');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/nota_tagihan_jasa_perkapalan';
                $path = $request->file('samarindafile32')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status32' => 'on review',
                            'time_upload32' => date("Y-m-d"),
                            'nota_tagihan_jasa_perkapalan' => basename($path),]);
                }else{
                    documentsamarinda::create([  
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status32' => 'on review',
                        'time_upload32' => date("Y-m-d"),
                        'nota_tagihan_jasa_perkapalan' => basename($path),]);
                    }
        }
        if ($request->hasFile('samarindafile33')) {
            $file1 = $request->file('samarindafile33');
            $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
            $tujuan_upload = 'samarinda/gambar_kapal_baru_(bki)';
            $path = $request->file('samarindafile33')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
            if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
            documentsamarinda::where('cabang', 'Samarinda')->update([  
                        'status33' => 'on review',
                        'time_upload33' => date("Y-m-d"),
                        'gambar_kapal_baru_(bki)' => basename($path),]);
            }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status33' => 'on review',
                    'time_upload33' => date("Y-m-d"),
                    'gambar_kapal_baru_(bki)' => basename($path),]);
                }
        }
        if ($request->hasFile('samarindafile34')) {
            $file1 = $request->file('samarindafile34');
            $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
            $tujuan_upload = 'samarinda/samarinda_jam1nan_(clc)';
            $path = $request->file('samarindafile34')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
            if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
            documentsamarinda::where('cabang', 'Samarinda')->update([  
                        'status34' => 'on review',
                        'time_upload34' => date("Y-m-d"),
                        'samarinda_jam1nan_(clc)' => basename($path),]);
            }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status34' => 'on review',
                    'time_upload34' => date("Y-m-d"),
                    'samarinda_jam1nan_(clc)' => basename($path),]);
                }
        }
        if ($request->hasFile('samarindafile35')) {
                $file1 = $request->file('samarindafile35');
                $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
                $tujuan_upload = 'samarinda/surat_ukur_dalam_negeri';
            $path = $request->file('samarindafile35')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
                if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
                    documentsamarinda::where('cabang', 'Samarinda')->update([  
                            'status35' => 'on review',
                            'time_upload35' => date("Y-m-d"),
                            'surat_ukur_dalam_negeri' => basename($path),]);
                }else{
                    documentsamarinda::create([  
                        'cabang' => Auth::user()->cabang ,
                        'user_id' => Auth::user()->id,

                        'status35' => 'on review',
                        'time_upload35' => date("Y-m-d"),
                        'surat_ukur_dalam_negeri' => basename($path),]);
                    }
        }
        if ($request->hasFile('samarindafile36')) {
            $file1 = $request->file('samarindafile36');
            $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
            $tujuan_upload = 'samarinda/penerbitan_sertifikat_kapal_baru';
            $path = $request->file('samarindafile36')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
            if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
            documentsamarinda::where('cabang', 'Samarinda')->update([  
                        'status36' => 'on review',
                        'time_upload36' => date("Y-m-d"),
                        'penerbitan_sertifikat_kapal_baru' => basename($path),]);
            }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status36' => 'on review',
                    'time_upload36' => date("Y-m-d"),
                    'penerbitan_sertifikat_kapal_baru' => basename($path),]);
                }
        }
        if ($request->hasFile('samarindafile37')) {
            $file1 = $request->file('samarindafile37');
            $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
            $tujuan_upload = 'samarinda/buku_stabilitas';
            $path = $request->file('samarindafile37')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
            if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
            documentsamarinda::where('cabang', 'Samarinda')->update([  
                        'status37' => 'on review',
                        'time_upload37' => date("Y-m-d"),
                        'buku_stabilitas' => basename($path),]);
            }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status37' => 'on review',
                    'time_upload37' => date("Y-m-d"),
                    'buku_stabilitas' => basename($path),]);
                }
        }
        if ($request->hasFile('samarindafile38')) {
            $file1 = $request->file('samarindafile38');
            $name1 =  'Picsite-'. Auth::user()->cabang . $file1->getClientOriginalName();
            $tujuan_upload = 'samarinda/grosse_akta';
            $path = $request->file('samarindafile38')->storeas('samarinda/'. $year . "/". $month , $name1, 's3');
            if(documentsamarinda::where('cabang', 'Samarinda')->whereMonth('created_at', date('m'))->exists()){
            documentsamarinda::where('cabang', 'Samarinda')->update([  
                        'status38' => 'on review',
                        'time_upload38' => date("Y-m-d"),
                        'grosse_akta' => basename($path),]);
            }else{
                documentsamarinda::create([  
                    'cabang' => Auth::user()->cabang ,
                    'user_id' => Auth::user()->id,

                    'status38' => 'on review',
                    'time_upload38' => date("Y-m-d"),
                    'grosse_akta' => basename($path),]);
                }
        }
        return redirect('/picsite/upload')->with('success', 'Upload success!');
    }
        
//email to user
    // $details = [
    //         'title' => 'Thank you for receiving this email', 
    //         'body' => 'you are a test subject for the project hehe'
    //     ];
        
    //     Mail::to('stanlytong@gmail.com')->send(new Gmail($details));

        return view('picsite.upload',compact('document', 'documentberau' , 'documentsamarinda' , 'documentbanjarmasin'));
        // return redirect('picsite/upload')->with('success', 'Upload success!');
    }
    
    public function view(){
        $name1 = Auth::user()->name .'Picsite-Babelan-1.pdf';
          //basename($path)= storage::path('babelan/sertifikat_keselamatan/stenliPicsite-1.pdf');

        // re . turn Storage::disk('s3')->response('images/' . $image->name1);

        // return Response::make(file_get_contents(basename($path), 200,
        //  [
        //     'Content-Type' => 'application//pdf',
        //     'Content-Disposition' => 'inline; name1="'.$name1.'"']);
    }
    
}
