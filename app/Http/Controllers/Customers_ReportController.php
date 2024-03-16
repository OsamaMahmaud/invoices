<?php

namespace App\Http\Controllers;

use App\invoices;
use App\sections;
use Illuminate\Http\Request;

class Customers_ReportController extends Controller
{
    //

    public function index(){

        $sections=sections::all();

        return view('reports.customers_report',compact('sections'));

    }


    public function Search_customers(Request $request)
    {

        if( $request->Section && $request->product && $request->start_at=='' && $request->end_at=='')
       {
           $invoices=invoices::select('*')->where('section_id',$request->Section)->get();

          $sections=sections::all();
          return view('reports.customers_report',compact('sections'))->withDetails($invoices);

       }

       else
       {
             $start_at=date($request->start_at);
             $end_at=date($request->end_at);
             $sections=sections::all();

             $invoices=invoices::select('*')->whereBetween('invoice_Date',[ $start_at,$end_at])->where('section_id',$request->Section)->get();
            return view('reports.customers_report',compact('sections','start_at','end_at'))->withDetails($invoices);

       }

    }
}
