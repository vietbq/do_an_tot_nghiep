<?php
?>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="pages/index" class="site_title"><i class="fa fa-paw"></i> <span>Smart Home</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu prile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img src="assets/images/img/viet.jpg" class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome</span>
                <h2><?php echo AuthComponent::user("username") ?></h2>
            </div>
        </div>
        <!-- /menu prile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
                <h3>Hệ thống</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li>
                                <a href="pages/index">Tổng quan</a>
                            </li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-mobile-phone"></i>Thiết bị di dộng<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li>
                                <a href="devices/index">Thiết bị đã đăng ký</a>
                            </li>
                            <li>
                                <a href="devices/request">Thiết bị đăng ký</a>
                            </li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-lightbulb-o"></i>Thiết bị điện tử<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li>
                                <a href="electronics/index">Danh sách</a>
                            </li>
                            <li>
                                <a href="electronics/add">Thêm thiết bị điện tử</a>
                            </li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-users"></i>Quản lý<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li>
                                <a href="users/index">Danh sách</a>
                            </li>
                            <li>
                                <a href="users/add">Thêm người quản lý</a>
                            </li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-cogs"></i>API<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li>
                                <a href="api/test">Test API</a>
                            </li>
                        </ul>
                    </li>
                </ul>   
            </div>
        </div>
        <!-- /sidebar menu -->
        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>