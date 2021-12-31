<?php

namespace App\Http\Controllers;

use Storage;
use Response;
use validator;
use Carbon\Carbon;
use App\Mail\Gmail;
use App\Models\User;
use App\Models\documents;
use App\Models\Rekapdana;
use App\Models\documentrpk;
use Illuminate\Http\Request;
use App\Models\documentberau;
use App\Models\documentsamarinda;
use Illuminate\Support\Facades\DB;
use App\Models\documentbanjarmasin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class picAdminController extends Controller
{
    public function checkform(Request $request){
        //Review Fund Request page for picAdmin
        //cabang filter
        $searchresult = $request->search;
        if ($searchresult == 'All') {
            $document = DB::table('documents')->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentberau = DB::table('beraudb')->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentbanjarmasin = DB::table('banjarmasindb')->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentsamarinda = DB::table('samarindadb')->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
        }
        elseif ($request->filled('search')) {
            $document = DB::table('documents')->where('cabang', $request->search)->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentberau = DB::table('beraudb')->where('cabang', $request->search)->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentbanjarmasin = DB::table('banjarmasindb')->where('cabang', $request->search)->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentsamarinda = DB::table('samarindadb')->where('cabang', $request->search)->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            return view('picadmin.picAdminDoc' , compact('document', 'documentberau' , 'documentbanjarmasin', 'documentsamarinda'));
        }
        else{{
            $document = DB::table('documents')->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentberau = DB::table('beraudb')->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentbanjarmasin = DB::table('banjarmasindb')->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentsamarinda = DB::table('samarindadb')->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
        }};

        //Search bar
        //check if search-bar is filled or not
        if ($request->filled('search_kapal')) {
            //search for nama kapal in picsite dashboard page dan show sesuai yang mendekati
            //pakai whereColumn untuk membandingkan antar 2 value column agar munculkan data dari pembuatan sampai bulan akhir periode
            $document = documents::where('nama_kapal', 'Like', '%' . $request->search_kapal . '%')
            ->whereColumn('created_at' , '<=', 'periode_akhir')
            ->orderBy('id', 'DESC')
            ->latest()->get();

            //berau search bar
            $documentberau = documentberau::where('nama_kapal', 'Like', '%' . $request->search_kapal . '%')
            ->whereColumn('created_at' , '<=', 'periode_akhir')
            ->orderBy('id', 'DESC')
            ->latest()->get();

            $documentbanjarmasin = documentbanjarmasin::where('nama_kapal', 'Like', '%' . $request->search_kapal . '%')
            ->whereColumn('created_at' , '<=', 'periode_akhir')
            ->orderBy('id', 'DESC')
            ->latest()->get();

            $documentsamarinda = documentsamarinda::where('nama_kapal', 'Like', '%' . $request->search_kapal . '%')
            ->whereColumn('created_at' , '<=', 'periode_akhir')
            ->orderBy('id', 'DESC')
            ->latest()->get();
            return view('picadmin.picAdminDoc' , compact('document', 'documentberau' , 'documentbanjarmasin', 'documentsamarinda'));
        }else{
            $document = documents::whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentberau = documentberau::whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentbanjarmasin = documentbanjarmasin::whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            $documentsamarinda = documentsamarinda::whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            return view('picadmin.picAdminDoc' , compact('document', 'documentberau' , 'documentbanjarmasin', 'documentsamarinda')); 
        }

    }
    
    public function checkrpk(Request $request){
        //review RPK page for picAdmin
        //filter cabang
        $searchresult = $request->search;
        if ($searchresult == 'All') {
            $docrpk = DB::table('rpkdocuments')->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
        }
        elseif ($request->filled('search')) {
            $docrpk = DB::table('rpkdocuments')->where('cabang', $request->search)->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            return view('picadmin.picAdminRpk' , compact('docrpk'));
        }
        else{
            //jika gk milih cabang
            $docrpk = DB::table('rpkdocuments')->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
        }
        //search bar kapal rpk
        if ($request->filled('search_kapal')) {
            //get DocRPK Data as long as the periode_akhir and search based (column database)
            $docrpk = DB::table('rpkdocuments')
            ->where('nama_kapal', 'Like', '%' . $request->search_kapal . '%')
            ->whereColumn('created_at' , '<=', 'periode_akhir')
            ->orderBy('id', 'DESC')
            ->latest()->get();
            return view('picadmin.picAdminRpk' , compact('docrpk'));
        }else{
            //get DocRPK Data as long as the periode_akhir(column database)
            $docrpk = DB::table('rpkdocuments')->whereColumn('created_at' , '<=', 'periode_akhir')->latest()->get();
            return view('picadmin.picAdminRpk' , compact('docrpk'));
        }
    }

    public function reject(Request $request){
        //reject for Fund request picAdmin page
        $request->validate([
            'reasonbox' => 'required|max:180',
        ]);

        if ($request->cabang == 'Babelan'){
        //  dd($request);
            $filename = $request->viewdoc;
            $result = $request->result;

            documents::where($filename, 'Like', '%' . $result . '%')
            ->where('cabang', $request->cabang)
            ->whereNotNull($filename)
            ->whereColumn('created_at' , '<=', 'periode_akhir')->update([
                $request->status => 'rejected',
                $request->reason => $request->reasonbox ,
            ]);
        }
        if ($request->cabang == 'Berau'){
            //  dd($request);
            $filename = $request->viewdoc;
            $result = $request->result;

            documentberau::where($filename, 'Like', '%' . $result . '%')
            ->where('cabang', $request->cabang)
            ->whereNotNull($filename)
            ->whereColumn('created_at' , '<=', 'periode_akhir')->update([
                $request->status => 'rejected',
                $request->reason => $request->reasonbox ,
            ]);
        }
        if ($request->cabang == 'Banjarmasin'){
            //  dd($request);
            $filename = $request->viewdoc;
            $result = $request->result;

            documentbanjarmasin::where($filename, 'Like', '%' . $result . '%')
            ->where('cabang', $request->cabang)
            ->whereNotNull($filename)
            ->whereColumn('created_at' , '<=', 'periode_akhir')->update([
                $request->status => 'rejected',
                $request->reason => $request->reasonbox ,
            ]);
        }
        if ($request->cabang == 'Samarinda'){
            //  dd($request);
            $filename = $request->viewdoc;
            $result = $request->result;

            documentsamarinda::where($filename, 'Like', '%' . $result . '%')
            ->where('cabang', $request->cabang)
            ->whereNotNull($filename)
            ->whereColumn('created_at' , '<=', 'periode_akhir')->update([
                $request->status => 'rejected',
                $request->reason => $request->reasonbox ,
            ]);
        }
        return redirect('/picadmin/dana');
    }
    
    public function approve(Request $request){
        // dd($request);
        //no reason needed for banjarmasin
        if ($request->cabang == 'Banjarmasin'){
            $filename = $request->viewdoc;
            $result = $request->result;
            
            documentbanjarmasin::where($filename, 'Like', '%' . $result . '%')
            ->where('cabang', $request->cabang)
            ->whereNotNull($filename)
            ->whereColumn('created_at' , '<=', 'periode_akhir')->update([
                $request->status => 'approved',
            ]);
        }else{
            $request->validate([
                'reasonbox' => 'required|max:255',
            ]);
            
            if ($request->cabang == 'Babelan'){
                $filename = $request->viewdoc;
                $result = $request->result;
                
                documents::where($filename, 'Like', '%' . $result . '%')
                ->where('cabang', $request->cabang)
                ->whereNotNull($filename)
                ->whereColumn('created_at' , '<=', 'periode_akhir')->update([
                    $request->status => 'approved',
                    $request->reason => $request->reasonbox ,
                ]);
            }
            if ($request->cabang == 'Berau'){
                $filename = $request->viewdoc;
                $result = $request->result;
                
                documentberau::where($filename, 'Like', '%' . $result . '%')
                ->where('cabang', $request->cabang)
                ->whereNotNull($filename)
                ->whereColumn('created_at' , '<=', 'periode_akhir')->update([
                    $request->status => 'approved',
                    $request->reason => $request->reasonbox ,
                ]);
            }
            if ($request->cabang == 'Samarinda'){
                $filename = $request->viewdoc;
                $result = $request->result;
                
                documentsamarinda::where($filename, 'Like', '%' . $result . '%')
                ->where('cabang', $request->cabang)
                ->whereNotNull($filename)
                ->whereColumn('created_at' , '<=', 'periode_akhir')->update([
                    $request->status => 'approved',
                    $request->reason => $request->reasonbox ,
                ]);
            }
        }
        return redirect('/picadmin/dana');
    }
    
    public function approverpk(Request $request){
        // dd($request);
        //check if cabang is banjarmasin
        if ($request->cabang == 'Banjarmasin') {
            $filename = $request->viewdocrpk;
            $result = $request->result;
            
            documentrpk::where($filename, 'Like', '%' . $result . '%')
            ->where('cabang', $request->cabang)
            ->whereNotNull($filename)
            ->whereColumn('created_at' , '<=', 'periode_akhir')->update([
                $request->status => 'approved',
            ]);
        }else{
            $request->validate([
                'reasonbox' => 'required|max:255',
            ]);

            $filename = $request->viewdocrpk;
            $result = $request->result;
            
            documentrpk::where($filename, 'Like', '%' . $result . '%')
            ->where('cabang', $request->cabang)
            ->whereNotNull($filename)
            ->whereColumn('created_at' , '<=', 'periode_akhir')->update([
                $request->status => 'approved',
                $request->reason => $request->reasonbox ,
            ]);
        }
        return redirect('/picadmin/rpk');
    }

    public function rejectrpk(Request $request){
        // dd($request);
        $request->validate([
            'reasonbox' => 'required|max:255',
        ]);

        $filename = $request->viewdocrpk;
        $result = $request->result;

        documentrpk::where($filename, 'Like', '%' . $result . '%')
        ->where('cabang', $request->cabang)
        ->whereNotNull($filename)
        ->whereColumn('created_at' , '<=', 'periode_akhir')->update([
            $request->status => 'rejected',
            $request->reason => $request->reasonbox ,
        ]);

        return redirect('/picadmin/rpk');
    }
    
    public function view(Request $request){
        
        $year = date('Y');
        $month = date('m');
        
        if($request->tipefile == 'DANA'){
            if ($request->cabang == 'Babelan'){
                $filename = $request->viewdoc;
                $result = $request->result;
                $viewer = documents::whereColumn('created_at' , '<=', 'periode_akhir')
                ->whereNotNull ($filename)
                ->where($filename, 'Like', '%' . $result . '%')
                ->pluck($filename)[0];
                // dd($viewer);
                return Storage::disk('s3')->response('babelan/' . $year . "/". $month . "/" . $viewer);
            }
            if ($request->cabang == 'Berau'){
                $filename = $request->viewdoc;
                $result = $request->result;
                $viewer = documentberau::whereColumn('created_at' , '<=', 'periode_akhir')
                ->whereNotNull ($filename)
                ->where($filename, 'Like', '%' . $result . '%')
                ->pluck($filename)[0];
                // dd($viewer);
                return Storage::disk('s3')->response('berau/' . $year . "/". $month . "/" . $viewer);
            }
            if ($request->cabang == 'Banjarmasin'){
                $filename = $request->viewdoc;
                $result = $request->result;
                $viewer = documentbanjarmasin::whereColumn('created_at' , '<=', 'periode_akhir')
                ->whereNotNull ($filename)
                ->where($filename, 'Like', '%' . $result . '%')
                ->pluck($filename)[0];
                // dd($viewer);
                return Storage::disk('s3')->response('banjarmasin/' . $year . "/". $month . "/" . $viewer);
            }
            if ($request->cabang == 'Samarinda'){
                $filename = $request->viewdoc;
                $result = $request->result;
                $viewer = documentsamarinda::whereColumn('created_at' , '<=', 'periode_akhir')
                ->whereNotNull ($filename)
                ->where($filename, 'Like', '%' . $result . '%')
                ->pluck($filename)[0];
                // dd($viewer);
                return Storage::disk('s3')->response('samarinda/' . $year . "/". $month . "/" . $viewer);
            }
        }
    }

    public function viewrpk(Request $request){ 
        $year = date('Y');
        $month = date('m');

        if($request->tipefile == 'RPK'){
            if ($request->cabang == 'Babelan'){
                $filenameRPK = $request->viewdocrpk;
                $result = $request->result;
                $viewer = documentrpk::where('cabang' , $request->cabang)
                ->whereNotNull($filenameRPK)
                ->where($filenameRPK, 'Like', '%' . $result . '%')
                ->whereColumn('created_at' , '<=', 'periode_akhir')
                ->pluck($filenameRPK)[0];
                // dd($viewer);
                return Storage::disk('s3')->response('babelan/' . $year . "/". $month . "/RPK" . "/" . $viewer);
            }
            if ($request->cabang == 'Berau'){
                $filenameRPK = $request->viewdocrpk;
                $result = $request->result;
                $viewer = documentrpk::where('cabang' , $request->cabang)
                ->whereNotNull ($filenameRPK)
                ->where($filenameRPK, 'Like', '%' . $result . '%')
                ->whereColumn('created_at' , '<=', 'periode_akhir')
                ->pluck($filenameRPK)[0]; 
                $viewer = documentrpk::where('cabang' , $request->cabang)->whereMonth('updated_at', $month)->pluck($filenameRPK)[0];
                // dd($viewer);
                return Storage::disk('s3')->response('berau/' . $year . "/". $month . "/RPK" . "/" . $viewer);
            }
            if ($request->cabang == 'Banjarmasin'){
                $filenameRPK = $request->viewdocrpk;
                $result = $request->result;
                $viewer = documentrpk::where('cabang' , $request->cabang)
                ->whereNotNull ($filenameRPK)
                ->where($filenameRPK, 'Like', '%' . $result . '%')
                ->whereColumn('created_at' , '<=', 'periode_akhir')
                ->pluck($filenameRPK)[0]; 
                $viewer = documentrpk::where('cabang' , $request->cabang)->whereMonth('updated_at', $month)->pluck($filenameRPK)[0];
                // dd($viewer);
                return Storage::disk('s3')->response('banjarmasin/' . $year . "/". $month . "/RPK" . "/" . $viewer);
            }
            if ($request->cabang == 'Samarinda'){
                $filenameRPK = $request->viewdocrpk;
                $result = $request->result;
                $viewer = documentrpk::where('cabang' , $request->cabang)
                ->whereNotNull ($filenameRPK)
                ->where($filenameRPK, 'Like', '%' . $result . '%')
                ->whereColumn('created_at' , '<=', 'periode_akhir')
                ->pluck($filenameRPK)[0]; 
                $viewer = documentrpk::where('cabang' , $request->cabang)->whereMonth('updated_at', $month)->pluck($filenameRPK)[0];
                // dd($viewer);
                return Storage::disk('s3')->response('samarinda/' . $year . "/". $month . "/RPK" . "/" . $viewer);
            }
        }
        
    // if ($request->cabang == 'Babelan'){
        //     $viewer = documentrpk::where('cabang' , $request->cabang)->whereMonth('updated_at', $month)->pluck($filename)[0];
        //     // dd($viewer);
        //     return Storage::disk('s3')->response('babelan/' . $year . "/". $month . "/RPK" . "/" . $viewer);
        // }
        // if ($request->cabang == 'Berau'){
        //     $viewer = documentrpk::where('cabang' , $request->cabang)->whereMonth('updated_at', $month)->pluck($filename)[0];
        //     // dd($viewer);
        //     return Storage::disk('s3')->response('berau/' . $year . "/". $month . "/RPK" . "/" . $viewer);
        // }
        // if ($request->cabang == 'Banjarmasin'){
        //     $viewer = documentrpk::where('cabang' , $request->cabang)->whereMonth('updated_at', $month)->pluck($filename)[0];
        //     // dd($viewer);
        //     return Storage::disk('s3')->response('banjarmasin/' . $year . "/". $month . "/RPK" . "/" . $viewer);
        // }
        // if ($request->cabang == 'Samarinda'){
        //     $viewer = documentrpk::where('cabang' , $request->cabang)->whereMonth('updated_at', $month)->pluck($filename)[0];
        //     // dd($viewer);
        //     return Storage::disk('s3')->response('samarinda/' . $year . "/". $month . "/RPK" . "/" . $viewer);
        // }
    }

    // RekapulasiDana delete
    public function destroyrekap(Rekapdana $rekap){
        Rekapdana::destroy($rekap->id); 
        return redirect('/picadmin/RekapulasiDana')->with('success', 'post telah dihapus.'); 
    }
    //update RekapulasiDana
    public function updaterekap(Request $request,Rekapdana $rekap){
        $update = Rekapdana::findorfail($rekap->id);
        $update->DateNote = $request->Datebox;
        $update->Cabang = $request->Cabang;
        $update->No_FormClaim = $request->No_FormClaim;
        $update->Nama_Kapal = $request->NamaKapal;
        $update->status_pembayaran = $request->status_pembayaran;
        $update->Nilai = $request->Nilai;
        $update->mata_uang_nilai = $request->mata_uang_nilai;
        $update->Nilai_Claim = $request->NilaiClaim;
        $update->mata_uang_claim = $request->mata_uang_claim;
        $update->update();
        return redirect('/picadmin/RekapulasiDana')->with('success', 'post telah terupdate.'); 
    }
    //create RekapulasiDana
    public function uploadrekap(Request $request){
        // dd($request);
        // $request->validate([
        //     'Cabang'=> 'required|max:255',
        //     'NamaKapal'=> 'required|max:255',
        //     'NilaiClaim'=> 'required',
        //     'DateNote'=> 'required',
        // ]);

        Rekapdana::create([
            'user_id'=> Auth::user()->id,
            'DateNote' => $request->Datebox ,
            'Cabang' => $request->Cabang ,
            // 'No_FormClaim' => $request->No_FormClaim ,
            'Nama_Kapal' => $request->NamaKapal ,
            'status_pembayaran' => $request->status_pembayaran ,
            'Nilai' => $request->Nilai ,
            'mata_uang_nilai' => $request->mata_uang_nilai ,
            // 'Nilai_Claim' => $request->NilaiClaim ,
            // 'mata_uang_claim' => $request->mata_uang_claim ,
            
        ]);
        return redirect('/picadmin/RekapulasiDana')->with('success', 'Note telah ditambahkan.');
    }

    public function RekapulasiDana(){
        $rekapdana= Rekapdana::all();
        return view('picadmin.picAdminRekapulasiDana', compact('rekapdana'));
    }
}
