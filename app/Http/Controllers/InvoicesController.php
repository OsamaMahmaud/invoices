<?php

namespace App\Http\Controllers;

use App\User;
use App\invoices;
use App\sections;
use App\invoices_detailes;
use App\invoice_attachments;
use Illuminate\Http\Request;
use App\Traits\invoicesTrait;
use App\Exports\InvoicesExport;
use App\Notifications\Add_invoice;
use App\Notifications\Add_Invoice_notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Notification;

class InvoicesController extends Controller
{
    use invoicesTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['update']]);
        $this->middleware('permission:حذف الفاتورة',['only' => ['destroy']]);
    }

    public function index()
    {
         $invoices= invoices::all();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections =sections::all();
        return view('invoices.create',compact('sections'));

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        //  return redirect()->back()->with(['success'=>'تم حفظ المنتج بنجاح']);
        $invoice_id=invoices::latest()->first()->id;

        invoices_detailes::create([
                'id_Invoice' => $invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => 'غير مدفوعة',
                'Value_Status' => 3,
                'note' => $request->note,
                'user' => (Auth::user()->name),
        ]);
        $invoice_number =$request->invoice_number ;

         $file_name=$this->saveImage($request->pic,public_path('Attachments/' . $invoice_number));

          invoice_attachments::create([
            'invoice_id' => $invoice_id,
            'file_name'=>$file_name,
            'Created_by'=>(Auth::user()->name),
            'invoice_number' => $request->invoice_number,
        ]);


         $user=User::first();
         //send maile to mailtraip by using Notification mail
        //  Notification::sendNow($user, new Add_invoice($invoice_id));

         //send notification to admin by using Notification databse

         Notification::sendNow($user, new Add_Invoice_notification($invoice_id));



          $invoices=invoices::all();

         return view('invoices.invoices',compact('invoices'))->with(['success'=>'تم اضافه المنتج بنجاح']);





    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $invoice=invoices::where('id',$id)->find($id);

        return view('invoices.status_update',compact('invoice'));
    }

    public function statusUpdate(Request $request,$id)
    {
        $invoices = invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة')
        {

                $invoices->update([
                    'Value_Status' => 1,
                    'Status' =>$request->Status,
                    'Payment_Date' => $request->Payment_Date,
                ]);

                invoices_detailes::create([
                    'id_Invoice' => $request->invoice_id,
                    'invoice_number' => $request->invoice_number,
                    'product' => $request->product,
                    'Section' => $request->Section,
                    'Status' => $request->Status,
                    'Value_Status' => 1,
                    'note' => $request->note,
                    'Payment_Date' => $request->Payment_Date,
                    'user' => (Auth::user()->name),
                ]);
        }
        elseif ($request->Status === 'مدفوعة جزئيا')
        {
            $invoices->update([
                'Value_Status' =>2,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_detailes::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 2,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        else
        {
                $invoices->update([
                    'Value_Status' =>2,
                    'Status' => $request->Status,
                    'Payment_Date' => $request->Payment_Date,
                ]);
                invoices_detailes::create([
                    'id_Invoice' => $request->invoice_id,
                    'invoice_number' => $request->invoice_number,
                    'product' => $request->product,
                    'Section' => $request->Section,
                    'Status' => $request->Status,
                    'Value_Status' => 2,
                    'note' => $request->note,
                    'Payment_Date' => $request->Payment_Date,
                    'user' => (Auth::user()->name),
                ]);
        }

        return redirect()->back()->with(['success'=>'تم تعديل حاله الدفع بنجاح']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $invoice_id=invoices::find($id);
          $invoice=invoices::select('id','invoice_number','invoice_Date','Due_date','product','section_id','Amount_collection','Amount_Commission','Discount',
        'Value_VAT',
        'Rate_VAT',
        'Total',
        'Status',
        'Value_Status',
        'note',
        'Payment_Date')->find($id);
        $sections =sections::all();

        return view('invoices.editInvoices',compact('sections','invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,$id)
    {
        //

         $invoice_id=invoices::find($id);

        $invoice_id->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        return redirect()->back()->with(['success'=>'تم تعديل الفاتوره بنجاح']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice_id=invoices::find($id);

        $invoice_id->delete();

        return redirect()->back()->with(['success'=>'تم حذف الفاتوره بنجاح']);
    }


    //get product_name by using section_id
    public function getproducts($id)
    {
        $pro_id=DB::table('products')->where('section_id',$id)->Pluck('product_name','id');
        return json_encode($pro_id);

    }

    public function Invoice_Paid()
    {
        $invoices=invoices::where('Value_Status',1)->get();
        return view('invoices.invoices-paid',compact('invoices'));
    }

    public function Invoice_UnPaid()
    {
        $invoices=invoices::where('Value_Status',2)->get();
        return view('invoices.invoices-Unpaid',compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices=invoices::where('Value_Status',3)->get();
        return view('invoices.invoices-Partial',compact('invoices'));
    }

    public function softDelete(Request $request)
    {
          $id= $request->invoice_id;
          $invoice_id=invoices::where('id',$id)->find($id);

        $invoice_id->delete();
        return redirect()->back()->with(['success'=>'تم ارشفه الفاتوره بنجاح']);

    }
    public  function Print_invoice($id)
    {
        $invoices = invoices::where('id',$id)->first();

        return  view('invoices.invoice_print', compact('invoices'));

    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }



    //MarkAsRead_all(notification)

    public function MarkAsRead_all()
    {
        $user_unreadNotification= Auth::user()->unreadNotifications;

        if($user_unreadNotification)
        {
            $user_unreadNotification->markAsRead();

            return back();
        }
    }


}
