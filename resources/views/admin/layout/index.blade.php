<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hệ thống quản lý văn bản hành chính">
    <meta name="author" content="Ngô Tiên Phong"">
    <link rel="icon" type="image/png" href="https://cdn-001.haui.edu.vn//img/logo-haui-size.png">
    <base href="{{ asset('') }}">
    <title>@yield('title') | Hệ thống quản lý văn bản hành chính</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <!-- Boxicons CSS -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!-- Bootstrap Core CSS -->
    <link href="admin_asset/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="admin_asset/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="admin_asset/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="admin_asset/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link href="admin_asset/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="admin_asset/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

     <!-- jQuery -->
    <script src="admin_asset/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="admin_asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="admin_asset/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="admin_asset/dist/js/sb-admin-2.js"></script>

    <!-- DataTables JavaScript -->
    <script src="admin_asset/bower_components/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script src="admin_asset/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>

    @yield('script')
    <style>
        #dataTables-example th{
            text-align: center;
            vertical-align: bottom;
        }
        #dataTables-example td{
            text-align: left;
        }
        .line_chart{
            width: 300px;
            height: 100px;
            background-color: white;
            border-radius: 10px; /* Bo góc nhẹ */
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2); /* Bóng mờ */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
        }
        .wrapper{
        width:60%;
        display:block;
        overflow:hidden;
        margin-left: 1%;
        margin-top: 20px; 
        padding: 60px 50px;
        background:#fff;
        border-radius:4px;
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2); /* Bóng mờ */
        }
        canvas{
        background:#fff;
        }
        #clock {
            font-family: 'Arial', sans-serif;
            font-size: 40px;
            text-align: center;
            margin-top: -35%;
            margin-left: 70%;
            padding: 20px;
            background-color: #ffffff;
            color: #000000;
            border-radius: 10px;
            width: 400px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2); /* Bóng mờ */
        }
        .wrapper-2{
            width: 450px;
            background: #fff;
            border-radius: 10px;
            margin-top: 1%;
            margin-left: 68%;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
            }
            .wrapper-2 header{
            display: flex;
            align-items: center;
            padding: 25px 30px 10px;
            justify-content: space-between;
            }
            header .icons{
            display: flex;
            }
            header .icons span{
            height: 38px;
            width: 38px;
            margin: 0 1px;
            cursor: pointer;
            color: #878787;
            text-align: center;
            line-height: 38px;
            font-size: 1.9rem;
            user-select: none;
            border-radius: 50%;
            }
            .icons span:last-child{
            margin-right: -10px;
            }
            header .icons span:hover{
            background: #f2f2f2;
            }
            header .current-date{
            font-size: 1.45rem;
            font-weight: 500;
            }
            .calendar{
            padding: 20px;
            }
            .calendar ul{
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            text-align: center;
            }
            .calendar .days{
            margin-bottom: 20px;
            }
            .calendar li{
            color: #333;
            width: calc(100% / 7);
            font-size: 1.07rem;
            }
            .calendar .weeks li{
            font-weight: 500;
            cursor: default;
            }
            .calendar .days li{
            z-index: 1;
            cursor: pointer;
            position: relative;
            margin-top: 30px;
            }
            .days li.inactive{
            color: #aaa;
            }
            .days li.active{
            color: #fff;
            }
            .days li::before{
            position: absolute;
            content: "";
            left: 50%;
            top: 50%;
            height: 40px;
            width: 40px;
            z-index: -1;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            }
            .days li.active::before{
            background: #9B59B6;
            }
            .days li:not(.active):hover::before{
            background: #f2f2f2;
            }
    </style>
</head>

<body>

    <div id="wrapper">

        @include('admin.layout.header')

        @yield('content')

    </div>
    <!-- /#wrapper -->



</body>

</html>
