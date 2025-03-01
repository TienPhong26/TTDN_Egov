 <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!-- <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search1...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </li> -->
                        <li>
                            <p style="text-align: left;margin: auto;margin-left: 5px; color: cadetblue">Quản lý văn bản</p>
                        </li>
                        <li>
                            {{-- <a href=""><i class="glyphicon glyphicon-home"></i> Trang chủ</a> --}}
                            <a href="admin/home"><i class="fa-solid fa-house"></i> Trang chủ</a>
                        </li>

                       



                        @if(Auth::user()->level !=7)
                        <li>
                            <a href="admin/danhmuc/"><i class="fa-solid fa-list-ul"></i> Danh mục<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="admin/danhmuc/dokhan">Độ khẩn</a>
                                </li>
                                <li>
                                    <a href="admin/danhmuc/domat">Độ mật</a>
                                </li>
                                <li>
                                    <a href="admin/danhmuc/donvi">Đơn vị lĩnh vực</a>
                                </li>
                                <li>
                                    <a href="admin/danhmuc/linhvuc">Lĩnh vực</a>
                                </li>
                                <li>
                                    <a href="admin/danhmuc/loaivanban">Loại văn bản</a>
                                </li>
                                <li>
                                    <a href="admin/danhmuc/nguoiky">Người ký</a>
                                </li>
                                
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @endif
                      
                        <li>
                            <a href="#"><i class="fa-solid fa-down-long"></i>   Văn bản đến<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                               @if (Auth::user()->level == 3 || Auth::user()->level == 2 )
                               <li>
                                   <a href="admin/vanbanden/vaosoden">Vào sổ văn bản</a>
                                </li>
                                <li>
                                    <a href="admin/vanbanden/hoanthanh">Lưu hồ sơ văn bản</a>
                                 </li>
                                @endif
                                @if(Auth::user()->level == 4 || Auth::user()->level == 2  )
                                <li>
                                    <a href="admin/vanbanden/chuyen">Trình chuyển văn bản</a>
                                </li> 
                                @endif
                                @if(Auth::user()->level == 2 ||Auth::user()->level == 5 || Auth::user()->level == 6)
                                <li>
                                    <a href="admin/vanbanden/butphe">Bút phê văn bản</a>
                                </li>  
                                @endif
                                @if(Auth::user()->level == 2 ||Auth::user()->level == 1 || Auth::user()->level == 7)
                                <li>
                                    <a href="admin/vanbanden/xulyvb">Xử lý văn bản</a>
                                </li>  
                                @endif
                                
                                @if(Auth::user()->level == 1 || Auth::user()->level == 2 ||Auth::user()->level == 5 || Auth::user()->level == 6 || Auth::user()->level == 7)
                                <li>
                                    <a href="admin/vanbanden/xuly">Văn bản đang xử lý</a>
                                </li> 
                                <li>
                                    <a href="admin/vanbanden/hoanthanh">Văn bản hoàn thành</a>
                                </li>
                                <li>
                                    <a href="admin/vanbanden/quahan">Văn bản quán hạn</a>
                                </li>
                                @endif
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-up-long"></i>   Văn bản đi<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                               @if(Auth::user()->level == 2 || Auth::user()->level == 1)
                               <li>
                                   <a href="admin/vanbandi/vaosodi">Vào sổ văn bản</a>
                                </li>
                                @endif
                                @if(Auth::user()->level == 2 || Auth::user()->level == 4)
                               <li>
                                   <a href="admin/vanbandi/chuyen">Trình chuyển văn bản</a>
                                </li>
                                @endif
                                
                                @if(Auth::user()->level == 2 ||Auth::user()->level == 5 || Auth::user()->level == 6 )
                                <li>
                                    <a href="admin/vanbandi/pheduyetdi">Phê duyệt văn bản đi</a>
                                </li>
                                @endif
                                {{-- @if(Auth::user()->level == 1 || Auth::user()->level == 2 ||Auth::user()->level == 5 || Auth::user()->level == 6 || Auth::user()->level == 3) --}}
                                <li>
                                    <a href="admin/vanbandi/danhsach">Danh sách văn bản đi</a>
                                </li>
                                {{-- @endif --}}
                                @if(Auth::user()->level == 3 || Auth::user()->level == 2 )
                                <li>
                                    <a href="admin/vanbandi/hoanthanh">Lưu hồ sơ văn bản</a>
                                </li>
                                @endif
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-list-alt"></i> Văn bản nội bộ<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                               @if(Auth::user()->level !=  3 && Auth::user()->level !=7)
                                <li>
                                   <a href="admin/vanbannoibo/vaosonoibo">Vào sổ văn bản nội bộ</a>
                                </li>
                                {{-- @if(Auth::user()->level == 1 || Auth::user()->level == 2 ||Auth::user()->level == 5 || Auth::user()->level == 6) --}}
                                <li>
                                    <a href="admin/vanbannoibo/pheduyet">Xử lý văn bản nội bộ</a>
                                </li>
                                @endif
                                {{-- @endif  --}}
                                <li>
                                    <a href="admin/vanbannoibo/danhsach">Danh sách văn bản nội bộ</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->