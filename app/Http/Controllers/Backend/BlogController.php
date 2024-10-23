<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(){
        $blog=Blogs::get();
        return view('backend.blog.index',['blog'=>$blog]);
    }
    public function tambah(){
        return view('backend.blog.tambah');
    }
    public function aksi_tambah(Request $request){
        
        $request->validate([
            'tittle' =>'required','description'=>'required','file'=>'required|file|mimes:jpeg,png|max:2048'
        ]);
        $data = [
            'tittle' => $request->tittle,
            'description' => $request->description,
            'slug' => Str::slug($request->tittle),
            'created_by' => auth()->user()->id,
            'created_at' => date('Y-m-d h:i:s')
        ];

        if ($request->hasFile('file')){
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('blogs'), $filename);

            $data['file'] = 'blogs/' . $filename;
        }
        Blogs::insert($data);
        return redirect()->route('backend.blog')->with('success', 'Blog Berhasil ditambahkan');
    }
        public function aksi_hapus($id){
            $ambilDataBlog=Blogs::where('id',$id)->first();
            Blogs::where('id',$id)->delete();
            $this->hapus_gambar($ambilDataBlog->file);
            return redirect()->back();
        }
        protected function hapus_gambar($gambar){
            if (file_exists($gambar)){
                unlink($gambar);  
            }
        }
        public function edit($id){
            $blog=Blogs::where('id',$id)->first();
            return view('backend.blog.edit',['blog'=>$blog]);
        }

        public function aksi_edit(Request $request,$id){
            $request->validate([
                'tittle'=>'required|string',
                'description'=> 'required|string',
                'file'=>'required|file|mimes:jpg,png|max:2048'
            ]);
            $data = [
                'tittle' => $request->tittle,
                'description' => $request->description,
                'slug' => Str::slug($request->tittle),
            ];
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('blogs'), $filename);
    
                $data['file'] = 'blogs/' . $filename;
                $ambilDataBlog=Blogs::where('id',$id)->first();
                $this->hapus_gambar($ambilDataBlog->file);
            }
            Blogs::where('id',$id)->update($data);
            return redirect()->route('backend.blog');
        }
}
