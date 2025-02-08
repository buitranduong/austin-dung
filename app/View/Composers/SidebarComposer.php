<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\View\View;

class SidebarComposer
{
    protected ?User $user;
    public array $menuItems = [];

    public function __construct()
    {
        $this->user = auth()->user();
        $this->generateMenuItems();
    }

    protected function generateMenuItems(): void
    {
        $this->menuItems = [
            (object)[
                'id' => 1,
                'name' => __('Bảng điều khiển'),
                'icon' => 'speedometer2',
                'url' => route('admin.dashboard.index'),
                'active' => request()->routeIs('admin.dashboard.index'),
                'children'=>[]
            ],
        ];

        // Thiết lập bán hàng
        if(
            $this->user->can('OrderController.index') or
            $this->user->can('SaleController.index') or
            $this->user->can('WarehouseController.index'))
        {
            $children = [];
            if($this->user->can('OrderController.index')){
                $children[] = (object)[
                    'id' => 15,
                    'name' => __('Đơn hàng'),
                    'icon' => 'cart-check-fill',
                    'url' => route('admin.seller.order.index'),
                    'active' => request()->is('admin/seller/order*'),
                    'children'=>[]
                ];
            }
            if($this->user->can('SaleController.index')){
                $children[] = (object)[
                    'id' => 16,
                    'name' => __('Điều chỉnh giá'),
                    'icon' => 'coin',
                    'url' => route('admin.seller.sale.index'),
                    'active' => request()->is('admin/seller/sale*'),
                    'children'=>[]
                ];
            }
            if($this->user->can('WarehouseController.index')){
                $children[] = (object)[
                    'id' => 17,
                    'name' => __('Cài đặt kho'),
                    'icon' => 'house-gear-fill',
                    'url' => route('admin.seller.warehouse.index'),
                    'active' => request()->is('admin/seller/warehouse*'),
                    'children'=>[]
                ];
            }
            $this->menuItems[] = (object)[
                'id' => 13,
                'name' => __('Thiết lập bán hàng'),
                'icon' => 'bag-heart-fill',
                'url' => '#',
                'active' => request()->is('admin/seller*'),
                'children'=> $children
            ];
        }

        // SEO Optimizer
        if(
            $this->user->can('SeoController.index') or
            $this->user->can('MetaController.index') or
            $this->user->can('FileController.index'))
        {
            $children = [];
            if($this->user->can('SeoController.index')){
                $children[] = (object)[
                    'id' => 18,
                    'name' => __('Cài đặt SEO page sim'),
                    'icon' => 'brilliance',
                    'url' => route('admin.seo.page.index'),
                    'active' => request()->is('admin/seo/page*'),
                    'children'=>[]
                ];
            }
            if($this->user->can('MetaController.index')){
                $children[] = (object)[
                    'id' => 19,
                    'name' => __('SEO sản phẩm'),
                    'icon' => 'telegram',
                    'url' => route('admin.seo.meta.index'),
                    'active' => request()->is('admin/seo/meta*'),
                    'children'=>[]
                ];
            }
            if($this->user->can('FileController.index')){
                $children[] = (object)[
                    'id' => 20,
                    'name' => __('File xác thực'),
                    'icon' => 'file-earmark-check',
                    'url' => route('admin.seo.file.index'),
                    'active' => request()->is('admin/seo/file*'),
                    'children'=>[]
                ];
            }
            $this->menuItems[] = (object)[
                'id' => 14,
                'name' => __('SEO Optimizer'),
                'icon' => 'search-heart-fill',
                'url' => '#',
                'active' => request()->is('admin/seo*'),
                'children'=> $children
            ];
        }

        // Quản lý tin tức
        if(
            $this->user->can('PageController.index') or
            $this->user->can('PostController.index') or
            $this->user->can('CategoryController.index') or
            $this->user->can('TagController.index'))
        {
            $children = [];
            if ($this->user->can('PageController.index')){
                $children[] = (object)[
                    'id' => 21,
                    'name' => __('Trang'),
                    'icon' => 'pin-angle-fill',
                    'url' => route('admin.page.index'),
                    'active' => request()->is('admin/blog/page*'),
                    'children'=>[]
                ];
            }
            if ($this->user->can('PostController.index')){
                $children[] = (object)[
                    'id' => 10,
                    'name' => __('Bài viết'),
                    'icon' => 'pen-fill',
                    'url' => route('admin.post.index'),
                    'active' => request()->is('admin/blog/post*'),
                    'children'=>[]
                ];
            }
            if ($this->user->can('CategoryController.index')){
                $children[] = (object)[
                    'id' => 11,
                    'name' => __('Chuyên mục'),
                    'icon' => 'bookmark-fill',
                    'url' => route('admin.category.index'),
                    'active' => request()->is('admin/blog/category*'),
                    'children'=>[]
                ];
            }
            if ($this->user->can('TagController.index')){
                $children[] = (object)[
                    'id' => 12,
                    'name' => __('Thẻ'),
                    'icon' => 'tags-fill',
                    'url' => route('admin.tag.index'),
                    'active' => request()->is('admin/blog/tag*'),
                    'children'=>[]
                ];
            }
            $this->menuItems[] = (object)[
                'id' => 9,
                'name' => __('Quản lý tin tức'),
                'icon' => 'newspaper',
                'url' => '#',
                'active' => request()->is('admin/blog*'),
                'children'=> $children
            ];
        }

        // Nhóm quyền hệ thống
        if(
            $this->user->can('RoleController.index') or
            $this->user->can('UserController.index') or
            $this->user->can('SettingController.index') or
            $this->user->can('SettingController.redirect')
        )
        {
            $children = [];
            if($this->user->can('RoleController.index')){
                $children[] = (object)[
                    'id' => 3,
                    'name' => __('Nhóm quyền hệ thống'),
                    'icon' => 'person-workspace',
                    'url' => route('admin.role.index'),
                    'active' => request()->is('admin/setting/role*'),
                    'children'=>[]
                ];
            }
            if($this->user->can('UserController.index')){
                $children[] = (object)[
                    'id' => 4,
                    'name' => __('Quản lý người dùng'),
                    'icon' => 'person-vcard',
                    'url' => route('admin.user.index'),
                    'active' => request()->is('admin/setting/user*'),
                    'children'=>[]
                ];
            }
            if($this->user->can('SettingController.index')){
                $children[] = (object)[
                    'id' => 7,
                    'name' => __('Cài đặt chung'),
                    'icon' => 'sliders',
                    'url' => route('admin.setting.index',['group'=>'index']),
                    'active' => request()->is('admin/setting/index') or request()->is('admin/setting/blog'),
                    'children'=>[]
                ];
            }
            if($this->user->can('SettingController.redirect')){
                $children[] = (object)[
                    'id' => 22,
                    'name' => __('Cài đặt chuyển hướng'),
                    'icon' => 'bootstrap-reboot',
                    'url' => route('admin.setting.index',['group'=>'redirect']),
                    'active' => request()->is('admin/setting/redirect'),
                    'children'=>[]
                ];
            }
            $this->menuItems[] = (object)[
                'id' => 6,
                'name' => __('Cấu hình hệ thống'),
                'icon' => 'gear-wide-connected',
                'url' => '#',
                'active' => request()->is('admin/setting*'),
                'children'=> $children
            ];
        }
    }

    public function compose(View $view): void
    {
        $view->with(['sidebarMenuItems'=>collect($this->menuItems)]);
    }
}
