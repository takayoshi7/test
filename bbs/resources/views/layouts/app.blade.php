<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/pepper-grinder/jquery-ui.css">
        {{-- <link rel="stylesheet" type="text/css" href="css/app.css"> --}}
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- jQuery -->
        <script src="{{ mix('/js/sample.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- jQuery-UI -->
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
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


        $(function() {
            // 入力ダイアログを表示
            $("#logserch").click(function() {

            $('#rog_list').val("");
            $('#word').val("");

            $("#rog_get").dialog("open");
            return false;
            });

            // 入力ダイアログを定義
            $("#rog_get").dialog({
            autoOpen: false,
            modal: true,
            title:"絞り込み検索",
            // height: 400,
            // width: 400,
            buttons: {
            "キャンセル": function() {
                $(this).dialog("close");
            },
            "適用": function() {
                $('#rog_display').click();
                $(this).dialog("close");
            },
            }
            });
        });


    </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
