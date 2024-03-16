<?php

namespace App\Http\Controllers;

use App\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\sectionRequest;
use Illuminate\Support\Facades\Validator;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
         $this->middleware('permission:اضافة قسم', ['only' => ['store']]);
         $this->middleware('permission:تعديل قسم', ['only' => ['update']]);
         $this->middleware('permission:حذف قسم',['only' => ['destroy']]);
     }

    public function index()
    {
        $sections=sections::all();
        return view('sections.all',compact('sections'));
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

        // $sections= $request->all();
            $rules=[
                'section_name' =>'required|max:100|unique:sections,section_name',
                'description'=>'required',
               ];

            $message=[
                'section_name.required' =>'section_name  required',
                'section_name.unique' =>'section_name  must be unique',
                'description.required' =>'description  required',


            ];

             $validator= Validator::make($request->all(),$rules, $message);

      if($validator->fails())//فشل
      {
         // return $validator->errors();
         return redirect()->route('sections.store')->withErrors($validator)->withInputs($request->all());
      }

        // if(!$sections)
        // {
        //    session()->flash('Error', 'يرجي ادخال البيانات');
        //    return redirect('/sections');
        // }
        else
        {
            sections::create([
                    'section_name'=>$request->section_name,
                    'description'=>$request->description,
                    'Created_by'=>(Auth::user()->name),
            ]);
            // session()->flash('Add', 'تم اضافة القسم بنجاح');
            return redirect('/sections')->with(['success'=>'تم اضافة القسم بنجاح']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit($sec_id)
    {
        //

           $sec= sections::find($sec_id);

            // $sctions =offer::find($sction_id);
            if(!$sec)
            return redirect()->back();

           else{

            $sec=  sections::select('id','section_name','description')->find($sec_id);
            return view('sections.empty',compact('sec'));

           }

            //   return redirect()->back();

            // return view('sections.all',compact('sctions'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
          $section=$request->id;//return ex: 1
         if(!$section)
          return redirect()->back()->with(['Error'=>'error ']);

             $sections = sections::find($section);
          $sections->update([
              'section_name' => $request->section_name,
              'description' => $request->description,
          ]);
           return redirect()->back()->with(['success'=>'تم التحديث بنجاح']);



}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
           $section=$request->id;//return ex: 1
            if(!$section)
            return redirect()->back()->with(['Error'=>'error ']);

            $sections = sections::find($section);
            $sections->delete();
            return redirect()->back()->with(['success'=>'تم الحذف بنجاح']);
    }
}
