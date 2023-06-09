<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\ProjectModel;
use App\Models\Admin\DetailProjectModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ProjectController extends Controller
{
    public function __construct()
    {
        $this->ProjectModel = new ProjectModel();
        $this->DetailProjectModel = new DetailProjectModel();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = ProjectModel::all();
        return view('admin.project.v_project', ['project' => $project]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.project.v_createproject');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
        $validated = $request->validate([
            'title' => 'required',
            'type' => 'required',
            'area_size' => 'required',
            'design_style' => 'required',
            'address' => 'required',
            'status' => 'required',
            'date' => 'required',
            'description' => 'required',
            'image_thumbnail' => 'required|mimes:jpg,jpeg,bmp,png',
            // //for change to string
            'image_detail.*' => 'required|mimes:jpg,jpeg,bmp,png',
        ]);
        
        // For Image Thumbnail
        if ($request->hasFile('image_thumbnail')) {
            //Retrieve uploaded image files
            $image_file = $request->file('image_thumbnail');
            //Retrieves uploaded image file extension
            $image_extension = $image_file->extension();
            //Form the name of the image file to be saved
            $image_name = $request->title . "." . $image_extension;
            //Saves the image file to the specified storage directory
            $path = $request->file('image_thumbnail')->storeAs('image_admin/project', $image_name);
            
            $project = new ProjectModel([
                'title' => Request()->title,
                'type' => Request()->type,
                'area_size' => Request()->area_size,
                'design_style' => Request()->design_style,
                'address' => Request()->address,
                'status' => Request()->status,
                'date' => Request()->date,
                'description' => Request()->description,
                'image_thumbnail' => $image_name,
            ]);
            $project->save();
        }

        if ($request->hasFile('detailImage')) {
            $image_files = $request->file('detailImage');
            foreach ($image_files as $fileImage) {
            $imageName = $project->title . '_' . $fileImage->getClientOriginalName();
            $request['id_project'] = $project->id_project;
            $request['image_detail'] = $imageName;
            $fileImage->storeAs('image_admin/project_detail', $imageName);
            DetailProjectModel::create($request->all());
            
            }
        }
        return redirect()->route('project')->with('pesan', 'Data added successfully');
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_project)
    {
        $project = ProjectModel::findOrFail($id_project);
        $detail_project = DetailProjectModel::where('id_project', $id_project)->get();
        return view('admin.project.v_showproject', compact('project', 'detail_project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_project)
    {
        $project = ProjectModel::findOrFail($id_project);
        $detail_project = DetailProjectModel::where('id_project', $id_project)->get();
        return view('admin.project.v_editproject', compact('project', 'detail_project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_project)
    {
        $validated = $request->validate([
            'image_thumbnail' => 'mimes:jpg,jpeg,bmp,png',
            'image_detail.*' => 'mimes:jpg,jpeg,bmp,png',
        ]);

       
        $project = ProjectModel::findOrFail($id_project);
        if($request->hasFile("image_thumbnail")){
            if (File::exists('storage/image_admin/project'. '/' . $project->image_thumbnail) ) {
                File::delete('storage/image_admin/project'. '/' . $project->image_thumbnail);
            }
            $image_file = $request->file('image_thumbnail');
            $image_extension = $image_file->extension();
            $image_name = $request->title . "." . $image_extension;
            $path = $request->file('image_thumbnail')->storeAs('image_admin/project', $image_name);
            
            $project->update([
                'title' => $request->title,
                'type' => $request->type,
                'area_size' => $request->area_size,
                'design_style' => $request->design_style,
                'address' => $request->address,
                'status' => $request->status,
                'date' => $request->date,
                'description' => $request->description,
                'image_thumbnail' => $image_name,
            ]);
        }else {
            $project->update([
                    'title' => $request->title,
                    'type' => $request->type,
                    'area_size' => $request->area_size,
                    'design_style' => $request->design_style,
                    'address' => $request->address,
                    'status' => $request->status,
                    'date' => $request->date,
                    'description' => $request->description,
                ]);
        }
    
        $detail_project = DetailProjectModel::where('id_project',$id_project)->get();
        if($request->hasFile("detailImage")){
            $image_files = $request->file('detailImage');
            foreach ($detail_project as $detail) {
                if (File::exists('storage/image_admin/project_detail'. '/' . $detail->image_detail) ) {
                    File::delete('storage/image_admin/project_detail'. '/' . $detail->image_detail);
                    $hapus=DetailProjectModel::findOrFail($detail->id_detail_project);
                    $hapus->delete();
                }
            }
            foreach ($image_files as $fileImage) {
                $imageName = $project->title . '_' . $fileImage->getClientOriginalName();
                $request['id_project'] = $project->id_project;
                $request['image_detail'] = $imageName;
                $fileImage->storeAs('image_admin/project_detail', $imageName);
                DetailProjectModel::create($request->all());

            }
            
        }
    
        return redirect()->route('project')->with('pesan', 'Data Berhasil Di Update');

        // $project = ProjectModel::findOrFail($id_project);
        // if ($request->hasFile("image_thumbnail") != '') {
      

       
        // } else {
        //     $project->update([
        //         'title' => $request->title,
        //         'type' => $request->type,
        //         'area_size' => $request->area_size,
        //         'design_style' => $request->design_style,
        //         'address' => $request->address,
        //         'status' => $request->status,
        //         'date' => $request->date,
        //         'description' => $request->description,
        //     ]);
        // }

        // if ($request->hasFile('detailImage')) {
        //     $image_files = $request->file('detailImage');
        //     foreach ($image_files as $fileImage) {
        //         $imageName = $project->title . '_' . $fileImage->getClientOriginalName();
        //         $request['id_project'] = $project->id_project;
        //         $request['image_detail'] = $imageName;
        //         $fileImage->storeAs('image_admin/project_detail', $imageName);
        //     }

        //     $detail_project = DetailProjectModel::where('id_project',$id_project)->get();
        //     foreach ($detail_project as $detail) {
        //         if ($detail->image_detail != '') {
        //             File::delete('storage/image_admin/project_detail'. '/' . $detail->image_detail);
        //         }
        //     }
        //     $detail = DetailProjectModel::where('id_project', $id_project)->first();
        //     if ($detail) {
        //         $detail->update(['image_detail' => $request->image_detail]);
        //     }

        // }
    
        // return redirect()->route('project')->with('pesan', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_project)
    {   
        $detail_project = DetailProjectModel::where('id_project',$id_project)->get();
        foreach ($detail_project as $detail) {
            if (File::exists('storage/image_admin/project_detail'. '/' . $detail->image_detail) ) {
                File::delete('storage/image_admin/project_detail'. '/' . $detail->image_detail);
                $hapus=DetailProjectModel::findOrFail($detail->id_detail_project);
                $hapus->delete();
            }
        }

        //searches for the project data based on the $id_project
        $project = ProjectModel::findOrFail($id_project);
        if (File::exists('storage/image_admin/project'. '/' . $project->image_thumbnail) ) {
            File::delete('storage/image_admin/project'. '/' . $project->image_thumbnail);
            $project->delete();
        }
        
        return redirect()->route('project')->with('pesan', 'Data Deleted Successfully');
    }
}
