<?php

namespace App\Http\Controllers;

use App\invoices;
use App\invoices_detailes;
use App\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices_detailes  $invoices_detailes
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_detailes $invoices_detailes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices_detailes  $invoices_detailes
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        // return $request->id;
          $invoices=invoices::where('id',$id)->first();
          $invoices_detailes=invoices_detailes::where('id_Invoice',$id)->get();
          $attachment=invoice_attachments::where('invoice_id',$id)->get();
        return view('invoices.invoicesDetailes',compact('invoices','invoices_detailes','attachment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices_detailes  $invoices_detailes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_detailes $invoices_detailes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices_detailes  $invoices_detailes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

    }

    public function delete(Request $request)
    {
        $attachment=invoice_attachments::find($request->id_file);
      if(!$attachment)
         return redirect()->back()->with(['error'=>('attachment not exist')]);

        $attachment->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        return redirect()->back()->with(['success'=>('attachment deleted successfully')]);
    }


    public function openfile($invoice_number, $file_name)
{
    $filePath = Storage::disk('public_uploads')->path($invoice_number . '/' . $file_name);
    return response()->file($filePath);
}

public function download($invoice_number, $file_name)
{
    $filePath = Storage::disk('public_uploads')->path($invoice_number . '/' . $file_name);
    return response()->download($filePath);
}
}
