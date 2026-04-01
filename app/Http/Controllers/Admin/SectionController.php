<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use Session;
use Auth;

class SectionController extends Controller
{
    public function sections(){
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType=="vendor"){
            $message = "You have no right to access this functionality";
            return redirect('admin/dashboard')->with('error_message',$message);
        }
        Session::put('page','sections');
        $sections = Section::get()->toArray();
        /*dd($sections);*/
        return view('admin.sections.sections')->with(compact('sections'));
    }

    public function updateSectionStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Section::where('id',$data['section_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'section_id'=>$data['section_id']]);
        }
    }

    public function deleteSection($id){
        // Delete Section
        Section::where('id',$id)->delete();
        $message = "Section has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditSection(Request $request,$id=null){
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType=="vendor"){
            $message = "You have no right to access this functionality";
            return redirect('admin/dashboard')->with('error_message',$message);
        }
        Session::put('page','sections');
        if($id==""){
            $title = "Add Section";
            $section = new Section;
            $message = "Section added successfully!";
        }else{
            $title = "Edit Section";
            $section = Section::find($id);
            $message = "Section updated successfully!";    
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $rules = [
                'section_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'url' => 'required|regex:/^[\pL\s\-]+$/u',
            ];

            $customMessages = [
                'section_name.required' => 'Section Name is required',
                'section_name.regex' => 'Valid Section Name is required',
                'url.required' => 'Section URL is required',
                'url.regex' => 'Valid Section URL is required',
            ];

            $this->validate($request,$rules,$customMessages);

            $section->name = $data['section_name'];
            $section->url = $data['url'];
            $section->status = 1;
            $section->save();

            return redirect('admin/sections')->with('success_message',$message);

        }
        return view('admin.sections.add_edit_section')->with(compact('title','section'));
    }
}
