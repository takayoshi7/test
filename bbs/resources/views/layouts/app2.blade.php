<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel研修</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/pepper-grinder/jquery-ui.css">
    <!-- Bootstrap CSS-->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="css/app_y.css">
    <!-- jQuery -->
    <script src="{{ mix('/js/sample.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- jQuery-UI -->
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Bootstrap JavaScript-->
    {{-- <script src="{{ mix('/js/app.js') }}"></script> --}}
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
    <script type="text/javascript">
    $(function() {
        // 入力ダイアログを表示
        $("#btn2").click(function() {

        //ダイアログを開くたびに表示を初期化
        $('#csv_file').val("");
        $('#error').html("");

        $("#app2").dialog("open");
        return false;
        });

        // 入力ダイアログを定義
        $("#app2").dialog({
        autoOpen: false,
        modal: true,
        title:"CSVファイルインポート",
        buttons: {
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });


    $(function() {
        // 入力ダイアログを表示
        $("#btn3").click(function() {

        $('#csv_file').val("");
        $('#error').html("");

        $("#app").dialog("open");
        return false;
        });

        // 入力ダイアログを定義
        $("#app").dialog({
        autoOpen: false,
        modal: true,
        title:"CSVファイルインポート",
        buttons: {
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });


        // 入力ダイアログを表示
    function img1func(empno) {
        $('#simg1').val("");
        $('#img1error').html("");
        $('#dialog_empno').val(empno);

        $("#select_img1").dialog("open");
    }

    $(function() {

        // 入力ダイアログを定義
        $("#select_img1").dialog({
        autoOpen: false,
        modal: true,
        title:"画像選択",
        buttons: {
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

        // 入力ダイアログを表示
    function img2func(empno) {
        $('#simg2').val("");
        $('#img2error').html("");
        $('#dialog_empno').val(empno);

        $("#select_img2").dialog("open");
    }

    $(function() {

        // 入力ダイアログを定義
        $("#select_img2").dialog({
        autoOpen: false,
        modal: true,
        title:"画像選択",
        buttons: {
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });


        // 入力ダイアログを表示
        function roleselect(empno) {
        $('#tag-id').val("");
        $('#roleerror').html("");
        $('#dialog_empno').val(empno);

        $("#role_edit").dialog("open");
    }

    $(function() {

        // 入力ダイアログを定義
        $("#role_edit").dialog({
        autoOpen: false,
        modal: true,
        title:"役割選択",
        buttons: {
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });


    </script>
  </head>
  <body>
    {{-- @include('inc.navbar') --}}
    {{-- <div class="container">
      <div class="row">
        <div class="col-md-offset-2 col-md-8 col-lg-8"> --}}
          {{-- @include('inc.messages') --}}
          @yield('content')
        {{-- </div>
      </div>
    </div> --}}

    {{-- <footer id="footer" class="text-center"> --}}
      {{-- <p>Copyright 2022 &copy; nys-t </p> --}}
    {{-- </footer> --}}
  </body>
</html>
