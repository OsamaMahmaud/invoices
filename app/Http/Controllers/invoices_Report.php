<?php

namespace App\Http\Controllers;

use App\invoices;
use Illuminate\Http\Request;

class invoices_Report extends Controller
{
    //

    public function index()
    {
        return view('reports.invoices_report');
    }


    public function Search_invoices(Request $request)
    {
        if($request->rdio==1)
        {
            if($request->start_at==''&&$request->end_at==''&&$request->type)
            {
                 $invoices=invoices::select('*')->where('Status',$request->type)->get();
                  $type=$request->type;
                  return view('reports.invoices_report',compact('type'))->withDetails($invoices);
            }
            else
            {
                $start_at=date($request->start_at);
                $end_at=date($request->end_at);
                $type=$request->type;
                $invoices=invoices::whereBetween('invoice_Date',[ $start_at,$end_at])->where('Status',$request->type)->get();
                return view('reports.invoices_report',compact('type','end_at','start_at'))->withDetails($invoices);;
            }
        }

        else
        {
            $invoices=invoices::select('*')->where('invoice_number',$request->invoice_number)->get();

            return view('reports.invoices_report')->withDetails($invoices);

        }

    }
}
