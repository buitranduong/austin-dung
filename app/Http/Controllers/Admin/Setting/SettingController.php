<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Settings\BlogSetting;
use App\Settings\GeneralSetting;
use App\Settings\HotlineSetting;
use App\Settings\ImageSetting;
use App\Settings\RedirectSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * @name Cài đặt chung
     */
    public function __construct(
        private readonly GeneralSetting $generalSetting,
        private readonly HotlineSetting $hotlineSetting,
        private readonly ImageSetting $imageSetting,
        private readonly BlogSetting $blogSetting,
        private readonly RedirectSetting $redirectSetting
    )
    {
        $this->middleware('can:SettingController.index')->only('index');
        $this->middleware('can:SettingController.update')->only('update');
        $this->middleware('can:SettingController.redirect')->only('redirect');
    }

    /**
     * @name Cho phép xem
     */
    public function index(string $group)
    {
        switch ($group) {
            case 'blog':
                $this->blogSetting->lock('timezone');
                $blogSetting = (object)[
                    'field_set'=> $this->blogSetting->fieldSet(),
                    'field_value' => $this->blogSetting,
                ];
                $imageSetting = $this->imageSetting;
                return view("admin.setting.general.$group", compact('blogSetting','imageSetting','group'));
            default:
                $generalSetting = (object)[
                    'field_set'=> $this->generalSetting->fieldSet(),
                    'field_value' => $this->generalSetting,
                ];
                $hotlineSetting = (object)[
                    'field_set'=> $this->hotlineSetting->fieldSet(),
                    'field_value' => $this->hotlineSetting
                ];
                return view("admin.setting.general.$group", compact('generalSetting', 'hotlineSetting','group'));
        }
    }

    /**
     * @name Cho phép sửa
     */
    public function update(Request $request, string $group)
    {
        switch ($group) {
            case 'blog':
                $request->validate([
                    'blog.title' => 'required',
                    'blog.description' => 'required',
                    'blog.post_limit' => 'required',
                ]);
                $this->blogSetting->title = $request->input('blog.title');
                $this->blogSetting->description = $request->input('blog.description');
                $this->blogSetting->timezone = $request->input('blog.timezone');
                $this->blogSetting->post_limit = $request->input('blog.post_limit');
                $this->blogSetting->head_script_before = $request->input('blog.head_script_before');
                $this->blogSetting->head_script_after = $request->input('blog.head_script_after');
                $this->blogSetting->body_script_before = $request->input('blog.body_script_before');
                $this->blogSetting->body_script_after = $request->input('blog.body_script_after');
                $this->blogSetting->save();
                break;
            default:
                $request->validate([
                    'general.site_name' => 'required',
                    'general.site_description' => 'required',
                    'general.sim_limit' => 'required',
                    'hotline.seller' => 'required',
                    'hotline.zalo' => 'required',
                    'hotline.phone' => 'required',
                ]);
                $this->generalSetting->site_name = $request->input('general.site_name');
                $this->generalSetting->site_description = $request->input('general.site_description');
                $this->generalSetting->head_script_before = $request->input('general.head_script_before');
                $this->generalSetting->head_script_after = $request->input('general.head_script_after');
                $this->generalSetting->body_script_before = $request->input('general.body_script_before');
                $this->generalSetting->body_script_after = $request->input('general.body_script_after');
                $this->generalSetting->sim_limit = $request->input('general.sim_limit');
                $this->generalSetting->save();

                $this->hotlineSetting->phone = $request->input('hotline.phone');
                $this->hotlineSetting->zalo = $request->input('hotline.zalo');
                $this->hotlineSetting->seller = $request->input('hotline.seller');
                $this->hotlineSetting->save();
                break;
        }
        // ghi log
        activity('GeneralSetting')
            ->causedBy($request->user())
            ->withProperties($request->except('_token'))
            ->log('update setting');
        return redirect()->back()->with(['message'=>__('Cấu hình đã được lưu')]);
    }

    /**
     * @name Cho phép cấu hình chuyển hướng
     */
    public function redirect(Request $request)
    {
        if($request->isMethod('post')){
            $url_array = $request->input('url_array');
            if($url_array){
                $data = [];
                $from = [];
                $to = [];
                foreach ($url_array as $item){
                    if(!empty($item['from']) and !empty($item['code']) and !empty($item['to'])){
                        $data[] = $item;
                        $from[] = $item['from'];
                        $to[] = $item['to'];
                    }
                }
                if($data){
                    $duplicate = array_intersect($from, $to);
                    if(!empty($duplicate)){
                        return redirect()->back()->withErrors(['message'=>__('Trùng lặp giá trị')]);
                    }
                }
                $this->redirectSetting->url_array = $data;
                $this->redirectSetting->save();
            }
            return redirect()->back()->with(['message'=>__('Cấu hình đã được lưu')]);
        }
        $redirectSetting = $this->redirectSetting;
        return view('admin.setting.general.redirect', compact('redirectSetting'));
    }
}
