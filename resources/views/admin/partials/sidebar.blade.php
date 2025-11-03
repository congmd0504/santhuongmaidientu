<style>
	body {
		font-family: 'Open Sans', sans-serif;
		background-color: #fff!important;
	}
	@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap');
	.nav-item i {
		padding-right: 5px;
	}
	.nav-sidebar>.nav-item a p {
		font-size: 15px;
	}
	.nav-treeview>.nav-item>.nav-link {
		color: #eee;
		padding: 4px 20px 4px 32px;
	}
	.nav-treeview>.nav-item>.nav-link p {
		font-size: 13px;
	}
	.nav-treeview>.nav-item>.nav-link i {
		font-size: 13px;
	}
	.sidebar {
		background: #333;
	}
	.sidebar a {
		color: #17a2b8;
	}
	.form-inline {
		padding: 15px 0;
	}
</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #333;">
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3  d-flex" style="padding: 0px 0 0 0;">
            <div class="image">
                <img src="{{asset('admin_asset/images/username.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                @if (Auth::guard('admin')->check())
                {{ Auth::guard('admin')->user()->name }}
                @endif
                </a>
            </div>
        </div>
       {{-- <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
             <input class="form-control form-control-sidebar" type="search" placeholder="Tìm kiếm" aria-label="Tìm kiếm">
             <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
             </div>
          </div>
       </div> --}}
       <!-- Sidebar Menu -->
       @php
           $routerName=request()->route()->getName();
       @endphp
       <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            @canany(['menu-list','menu-add'])
            <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-bars"></i>
                   <p>
                      Menu
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('menu-list')
                   <li class="nav-item">
                      <a href="{{route('admin.menu.index')}}" class="nav-link">
                         <i class="far fa-folder-open"></i>
                         <p>List menu</p>
                      </a>
                   </li>
                   @endcan
                   @can('menu-add')
                   <li class="nav-item">
                      <a href="{{route('admin.menu.create')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Thêm menu</p>
                      </a>
                   </li>
                   @endcan
                </ul>
            </li>
             @endcan
             @canany(['category-product-list','category-product-add','product-list','product-add'])
             <li class="nav-item">
                <a href="#" class="nav-link ">
                   <i class="fab fa-product-hunt"></i>
                   <p>
                      Quản lý Sản phẩm
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('category-product-list')
                   	<li class="nav-item">
                      <a href="{{route('admin.categoryproduct.index')}}" class="nav-link">
                         <i class="far fa-folder-open"></i>
                         <p>Danh mục</p>
                      </a>
                   	</li>
                       @endcan
                     {{--@can('category-product-add')
                   	<li class="nav-item">
                      <a href="{{route('admin.categoryproduct.create')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Thêm danh mục</p>
                      </a>
                   	</li>
                       @endcan--}}
                       @can('product-list')
					      <li class="nav-item">
                      <a href="{{route('admin.product.index')}}" class="nav-link">
                         <i class="fas fa-archive"></i>
                         <p>Sản phẩm</p>
                      </a>
                   	</li>
                       @endcan
                     {{--@can('product-add')
					      <li class="nav-item">
                      <a href="{{route('admin.product.create')}}" class="nav-link">
                         <i class="fas fa-plus-square"></i>
                         <p>Thêm sản phẩm mới</p>
                      </a>
                     </li>
                     @endcan--}}
                </ul>
            </li>
             @endcan
             @canany(['category-post-list','category-post-add','post-list','post-add'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="far fa-newspaper"></i>
                   <p>
                      Quản lý Tin tức
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('category-post-list')
                   <li class="nav-item">
                      <a href="{{route('admin.categorypost.index')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Danh mục</p>
                      </a>
                   </li>
                   @endcan
                   {{--@can('category-post-add')
                   <li class="nav-item">
                      <a href="{{route('admin.categorypost.create')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Thêm danh mục</p>
                      </a>
                   </li>
                   @endcan--}}
                   @can('post-list')
					<li class="nav-item">
                      <a href="{{route('admin.post.index')}}" class="nav-link">
                         <i class="fas fa-archive"></i>
                         <p>Tin tức</p>
                      </a>
                   </li>
                   @endcan
                   {{--@can('post-add')
                   <li class="nav-item">
                      <a href="{{route('admin.post.create')}}" class="nav-link">
                         <i class="fas fa-plus-square"></i>
                         <p>Thêm tin tức</p>
                      </a>
                   </li>
                   @endcan--}}
                </ul>
            </li>
             @endcan
             @canany(['bank-list','bank-add'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-university"></i>
                   <p>
                     Quản lý Ngân hàng
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('bank-list')
                   <li class="nav-item">
                      <a href="{{route('admin.bank.index')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Danh sách ngân hàng</p>
                      </a>
                   </li>
                   @endcan
                  {{-- @can('bank-add')
                   <li class="nav-item">
                      <a href="{{route('admin.bank.create')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Thêm ngân hàng</p>
                      </a>
                   </li>
                   @endcan--}}
                </ul>
             </li>
             @endcan
             {{-- @canany(['store-list','store-add'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-warehouse"></i>
                   <p>
                     Quản lý kho
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('store-list')
                   <li class="nav-item">
                      <a href="{{route('admin.store.index')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Danh sách xuất nhập</p>
                      </a>
                   </li>
                   @endcan
                   @can('store-input')
                   <li class="nav-item">
                      <a href="{{route('admin.store.create',['type'=>1])}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Nhập kho</p>
                      </a>
                   </li>
                   <li class="nav-item">
                      <a href="{{route('admin.store.create',['type'=>3])}}" class="nav-link">
                          <i class="fas fa-folder-plus"></i>
                          <p>Xuất kho</p>
                      </a>
                    </li>
                    @endcan
                    @can('product-list')
                    <li class="nav-item">
                        <a href="{{route('admin.product.index')}}" class="nav-link">
                            <i class="fas fa-folder-plus"></i>
                            <p>Tổng kho</p>
                        </a>
                    </li>
                    @endcan
                </ul>
             </li>
             @endcan --}}
             @canany(['slider-list','slider-add'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-images"></i>
                   <p>
                      Quản lý Hình ảnh
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('slider-list')
                   <li class="nav-item">
                      <a href="{{route('admin.slider.index')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Danh sách slider</p>
                      </a>
                   </li>
                   @endcan
                   {{--@can('slider-add')
                   <li class="nav-item">
                      <a href="{{route('admin.slider.create')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Thêm slider</p>
                      </a>
                   </li>
                   @endcan--}}
                </ul>
             </li>
             @endcan
             @canany(['setting-list','setting-add'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-user-cog"></i>
                   <p>
                      Quản lý Hệ thống
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('setting-list')
                   <li class="nav-item">
                      <a href="{{route('admin.setting.index')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>List hệ thống</p>
                      </a>
                   </li>
                   @endcan
                   {{--@can('setting-add')
                   <li class="nav-item">
                      <a href="{{route('admin.setting.create')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Thêm hệ thống</p>
                      </a>
                   </li>
                   @endcan--}}
                </ul>
             </li>
             @endcan
             @canany(['admin-user-list','admin-user-add'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-users"></i>
                   <p>
                      Quản lý Nhân viên
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('admin-user-list')
                   <li class="nav-item">
                      <a href="{{route('admin.user.index')}}" class="nav-link">
                         <i class="fas fa-user-check"></i>
                         <p>Danh sách nhân viên</p>
                      </a>
                   </li>
                   @endcan
                   {{--@can('admin-user-add')
                   <li class="nav-item">
                      <a href="{{route('admin.user.create')}}" class="nav-link">
                         <i class="fas fa-user-plus"></i>
                         <p>Thêm nhân viên</p>
                      </a>
                   </li>
                   @endcan--}}
                </ul>
             </li>
             @endcan
             @canany(['admin-user_frontend-list','admin-user_frontend-add'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-users"></i>
                   <p>
                      Quản lý Thành viên
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('admin-user_frontend-list')
                   <li class="nav-item">
                      <a href="{{route('admin.user_frontend.index')}}" class="nav-link">
                         <i class="fas fa-user-check"></i>
                         <p>Danh sách thành viên</p>
                      </a>
                   </li>

                   <li class="nav-item">
                        <a href="{{route('admin.user_frontend.index',['fill_action'=>'userActive'])}}" class="nav-link">
                        <i class="fas fa-user-check"></i>
                        <p>Đã kích hoạt</p>
                        </a>
                    </li>

                   <li class="nav-item">
                        <a href="{{route('admin.user_frontend.index',['fill_action'=>'userNoActive'])}}" class="nav-link">
                        <i class="fas fa-user-clock"></i>
                        <p>Đang đợi kích hoạt</p>
                        </a>
                    </li>

                    @endcan
                    @can('admin-user_frontend-banTien')
                    <li class="nav-item">
                        <a href="{{route('admin.user_frontend.banDiem')}}" class="nav-link">
                        <i class="fas fa-user-clock"></i>
                        <p>Bắn điểm cho toàn bộ thành viên</p>
                        </a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a href="{{route('admin.user_frontend.napTienIndex')}}" class="nav-link">
                        <i class="fas fa-user-clock"></i>
                        <p>Danh sách nạp tiền</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.user_frontend.napTienDuyetIndex')}}" class="nav-link">
                        <i class="fas fa-user-clock"></i>
                        <p>Danh sách nạp tiền bằng chuyển khoản</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.user_frontend.banDiemIndex')}}" class="nav-link">
                        <i class="fas fa-user-clock"></i>
                        <p>Danh sách nạp tiền từ admin</p>
                        </a>
                    </li>
                    {{--@can('admin-user_frontend-add')
                   <li class="nav-item">
                      <a href="{{route('admin.user_frontend.create')}}" class="nav-link">
                         <i class="fas fa-user-plus"></i>
                         <p>Thêm thành viên</p>
                      </a>
                   </li>
                   @endcan--}}
                </ul>
             </li>
             @endcan
             @canany(['pay-list'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-tasks"></i>
                   <p>
                      Quản lý rút điểm
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('pay-list')
                   <li class="nav-item">
                      <a href="{{route('admin.pay.index')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Danh sách rút điểm</p>
                      </a>
                   </li>
                   @endcan
{{--
                   <li class="nav-item">
                       <a href="{{ route('admin.pay.historyPoint') }}" class="nav-link">
                        <i class="fas fa-folder-plus"></i>
                        Lịch sử bắn điểm</a>
                   </li> --}}
                </ul>
             </li>
             @endcan

             @canany(['role-list','role-add'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-tasks"></i>
                   <p>
                      Quản lý Vai trò
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('role-list')
                   <li class="nav-item">
                      <a href="{{route('admin.role.index')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Danh sách vai trò</p>
                      </a>
                   </li>
                   @endcan
                   {{--@can('role-add')
                   <li class="nav-item">
                      <a href="{{route('admin.role.create')}}" class="nav-link">
                         <i class="fas fa-user-plus"></i>
                         <p>Thêm vai trò</p>
                      </a>
                   </li>
                   @endcan--}}
                </ul>
             </li>
             @endcan
             @canany(['permission-list','permission-add'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-tasks"></i>
                   <p>
                      Quản lý Quyền
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>

                <ul class="nav nav-treeview">
                    @can('permission-list')
                   <li class="nav-item">
                      <a href="{{route('admin.permission.index')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Danh sách Quyền</p>
                      </a>
                   </li>
                   @endcan
                   @can('permission-add')
                   <li class="nav-item">
                      <a href="{{route('admin.permission.create')}}" class="nav-link">
                         <i class="fas fa-user-plus"></i>
                         <p>Thêm Quyền</p>
                      </a>
                   </li>
                   @endcan
                </ul>
             </li>
             @endcan
             @canany(['code_sale-list','code_sale-add'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-tasks"></i>
                   <p>
                      Quản lý mã giảm giá
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>

                <ul class="nav nav-treeview">
                    @can('code_sale-list')
                   <li class="nav-item">
                      <a href="{{route('admin.codeSale.index')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Danh sách mã giảm giá</p>
                      </a>
                   </li>
                   @endcan
                   @can('code_sale-add')
                   <li class="nav-item">
                      <a href="{{route('admin.codeSale.create')}}" class="nav-link">
                         <i class="fas fa-user-plus"></i>
                         <p>Thêm mã giảm giá</p>
                      </a>
                   </li>
                   @endcan
                </ul>
             </li>
             @endcan
             @canany(['transaction-list'])
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-cart-plus"></i>
                   <p>
                      Quản lý đơn hàng
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                    {{-- @can('permission-add') --}}
                   <li class="nav-item">
                      <a href="{{route('admin.transaction.index')}}" class="nav-link">
                         <i class="fas fa-cart-plus"></i>
                         <p>Đơn hàng</p>
                      </a>
                   </li>
                   {{-- @endcan --}}
                </ul>
             </li>
             @endcan
             <li class="nav-item">
                <a href="#" class="nav-link">
                   <i class="fas fa-id-card-alt"></i>
                   <p>
                      Thông tin liên hệ
                      <i class="right fas fa-angle-right"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview">
                   <li class="nav-item">
                      <a href="{{route('admin.contact.index')}}" class="nav-link">
                         <i class="fas fa-folder-plus"></i>
                         <p>Danh sách liên hệ</p>
                      </a>
                   </li>
                </ul>
             </li>

             {{-- <li class="nav-item">
                <a href="{{ route('admin.numberMain') }}" class="nav-link">
                   <i class="nav-icon fas fa-th"></i>
                   <p>
                      Những con số
                      <span class="right badge badge-danger">New</span>
                   </p>
                </a>
             </li> --}}
          </ul>
       </nav>
    </div>
 </aside>
