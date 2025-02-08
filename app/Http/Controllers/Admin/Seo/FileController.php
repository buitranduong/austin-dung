<?php

namespace App\Http\Controllers\Admin\Seo;

use App\Http\Controllers\Controller;
use App\Models\Seo\FileCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    /**
     * @name Quản lý file xác thực
     */
    public function __construct()
    {
        $this->middleware('can:FileController.index');
        $this->middleware('can:FileController.create')->only('create', 'store');
        $this->middleware('can:FileController.edit')->only('update', 'publish');
        $this->middleware('can:FileController.destroy')->only('destroy');
    }

    /**
     * @name Cho phép xem danh sách
     */
    public function index()
    {
        $files = FileCertificate::paginate();
        return view('admin.seo.file.index', compact('files'));
    }

    /**
     * @name Cho phép tạo mới
     */
    public function create()
    {
        return view('admin.seo.file.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|max:255',
           'content' => 'required',
        ]);
        $file = new FileCertificate();
        $file->fill($request->only('name', 'content'));
        $file->save();
        $this->_writeFileToRoot($file);
        return redirect()->route('admin.seo.file.index')->with(['message' => __('Bản ghi đã được tạo')]);
    }

    /**
     * @name Cho phép sửa
     */
    public function edit($id)
    {
        $file = FileCertificate::findOrFail($id);
        return view('admin.seo.file.edit', compact('file'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'content' => 'required',
        ]);
        $file = FileCertificate::findOrFail($id);
        $file->fill($request->only('name', 'content'));
        $file->save();
        $this->_writeFileToRoot($file);
        return redirect()->route('admin.seo.file.index')->with(['message'=> __('Bản ghi đã cập nhật')]);
    }

    /**
     * @name Cho phép xóa
     */
    public function destroy($id)
    {
        $file = FileCertificate::findOrFail($id);
        if(File::exists($file->name)){
            File::delete($file->name);
        }
        $file->delete();
        return redirect()->route('admin.seo.file.index')->with(['message'=> __('Bản ghi đã được xóa')]);
    }

    private function _writeFileToRoot(FileCertificate $file): void
    {
        try{
            $path = public_path();
            if (!File::isWritable($path)){
                File::chmod($path, 0777);
            }
            File::put($file->name, $file->content);
        }catch (\Exception $exception){
            Log::error($exception);
        }
    }
}
