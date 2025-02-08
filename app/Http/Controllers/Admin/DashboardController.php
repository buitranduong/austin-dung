<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Illuminate\View\View;

class DashboardController extends Controller
{

    public function __construct(protected MetaInterface $meta)
    {

    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        // Test meta tag append to head html
        $this->meta
            ->prependTitle('SimThangLong')
            ->setTitle('Dashboard')
            ->setDescription('Demo description')
            ->addLink('alternate',[
                'href' => route('admin.dashboard.index'),
                'hreflang'=>'vi_VN'
            ])
            ->addLink('canonical',[
                'href' => route('admin.dashboard.index'),
            ])
            ->addMeta('author',[
                'content' => 'Thang Long'
            ])
            ->addMeta('robots',[
                'content' => 'noindex, nofollow'
            ])->addMeta('copyright',[
                'content' => 'Thang Long'
            ])
            ->addMeta('published_time',[
                'property' => 'article:published_time',
                'content' => '2023-11-23T00:00:00+07:00'
            ])
            ->addMeta('modified_time',[
                'property' => 'article:modified_time',
                'content' => '2023-11-24T00:00:00+07:00'
            ])
            ->addMeta('application-name',[
                'content' => 'Thang Long'
            ]);
        return view('admin.dashboard');
    }
}
