<?php

namespace App\Http\Controllers;

use App\invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //sum
        $total                 = number_format(invoices::sum('Total'),2);
        $invoices_paid         = number_format(invoices::where('Value_Status',1)->sum('Total'),2);
        $invoices_Partial_Paid = number_format(invoices::where('Value_Status',2)->sum('Total'),2);
        $invoices_Unpaid       = number_format(invoices::where('Value_Status',3)->sum('Total'),2);

        //count
        $total_count                 = invoices::all()->count();
        $invoices_paid_count         = invoices::where('Value_Status',1)->count();
        $invoices_Partial_Paid_count = invoices::where('Value_Status',2)->count();
        $invoices_Unpaid_count       = invoices::where('Value_Status',3)->count();

        //precentage
        $percentage_invoices_paid         = round(($invoices_paid_count/ $total_count)*100);
        $percentage_invoices_Partial_Paid = round(($invoices_Partial_Paid_count/ $total_count)*100);
        $percentage_invoices_Unpaid       = round(($invoices_Unpaid_count/ $total_count)*100);

        //chartjs

        $chartjs = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels([' الفواتير المدفوعة جزئيا', ' الفواتير المدفوعة',' الفواتير الغير المدفوعة'])
        ->datasets([
            [
                'backgroundColor' => ['#f76a2d','#48d6a8','#f93a5a'],
                'hoverBackgroundColor' => ['#f76a2d','#48d6a8','#f93a5a'],
                'data' => [ $percentage_invoices_Partial_Paid , $percentage_invoices_paid , $percentage_invoices_Unpaid]
            ]
        ])
        ->options([]);

        $chart = app()->chartjs
         ->name('barChartTest')
         ->type('bar')
         ->size(['width' =>350, 'height' => 200])

         ->datasets([


            [
                "label" => "الفواتير المدفوعة جزئيا",
                'backgroundColor' => ['#f76a2d'],
                'hoverBackgroundColor' => ['#f76a2d'],
                'data' => [$percentage_invoices_Partial_Paid]
            ],
            [
                "label" => "الفواتير المدفوعة",
                'backgroundColor' => ['#48d6a8'],
                'hoverBackgroundColor' => ['#48d6a8'],
                'data' => [$percentage_invoices_paid ]
            ],
            [
                "label" => "الفواتير الغير المدفوعة",
                'backgroundColor' => ['#f93a5a'],
                'hoverBackgroundColor' => ['#f93a5a'],
                'data' => [$percentage_invoices_Unpaid]
            ]

         ])
         ->options([]);


        return view('home',compact('total','invoices_paid','invoices_Unpaid','invoices_Partial_Paid','percentage_invoices_paid','percentage_invoices_Partial_Paid','percentage_invoices_Unpaid','chartjs','chart'));
    }
}
