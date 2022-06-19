<x-app-layout>
    <x-slot name="header">
    <div class="wrap">
        <div class="title">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('部署一覧') }}
        </h2>
        </div>
        <div class="insert">
        @if(in_array(4, $array))
            <input type="button" id="insert2"   value="部署追加">
        @endif
        </div>
        <div class="category">
        <form action="{{ url('/deptcsvd') }}" method="post">
        @csrf
            <input type="button" id="search2"  value="検索">
            <input type="submit" id="dep"  value="CSVエクスポート">
            <input type="button" id="btn3" value="CSVインポート">
            <input type="hidden" name="dnames">
        </form>
        </div>
        <div class="sort">
            @if(in_array(2, $array))
            <input type="hidden" id="list-ids" name="list-ids">
            <input type="hidden" id="listsortnum" value={{ $listsortnum }}>
            <input type="button" id="sortnum" style="background-color:rgb(216, 252, 216)"; value="並び順更新"><br>
            <font size="2" color="rgb(216, 252, 216)">※1ページに全件表示後、ドラッグドロップで入れ替え、クリック</font>
            @endif
        </div>
        <div class="page">
            <form action="{{ url('/list2') }}" method="get">
            @csrf
            <p>表示件数：<input type="number" name="dispnum" id="dispnum" value={{ $dispnum }} min="1" pattern="^[1-9]+$">
                        <input type="hidden" name="sorton" value={{ $sort }}>
                        <input type="hidden" name="category" value={{ $category }}>
                        <input type="submit" name="submit" value="変更">
            </p>
            </form>
        </div>
    </div>
    </x-slot>

<form action="{{ url('/list2') }}" method="get">
@csrf
<table>
    <thead>
    <tr><th>部署コード
        <input type="submit" name="sortdeptno" value="▲">
        <input type="submit" name="sortdeptno" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>部署名
        <input type="submit" name="sortdname" value="▲">
        <input type="submit" name="sortdname" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>場所
        <input type="submit" name="sortloc" value="▲">
        <input type="submit" name="sortloc" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>並び順
        <input type="submit" name="sortnum" value="▲">
        <input type="submit" name="sortnum" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        @if(in_array(4, $array))
        <th>編集</th>
        <th>削除</th>
        @endif
    </tr>
    </thead>
</form>
    <tbody id="list2" class="sortable">
    @foreach ($depte as $depts) {{--Controllerから渡された$dataのDEPT(DBのデータが入っている)をasを使いDEPTSに変えた--}}
    <tr id="{{ $depts->deptno }}">
        <td>{{ $depts->deptno }}</td>
        <td>{{ $depts->dname }}</td>
        <td>{{ $depts->loc }}</td>
        <td>{{ $depts->sort }}</td>
        @if(in_array(4, $array))
        <td><button type="button" class="edit2" value="{{ $depts->deptno }}, {{ $depts->dname }}, {{ $depts->loc }}, {{ $depts->sort }}" onclick="edit2func(this.value)">編集</button></td>
        <td><button type="button" class="delete2" value="{{ $depts->deptno }}">削除</button></td>
        @endif
    </tr>
    @endforeach
    </tbody>
</table>
<div class="pager">
{{ $depte->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>


{{-- 追加ダイアログ --}}
<div id="insertlist2">
    <p>新しく部署を追加できます。下記項目に入力後、追加ボタンを押してください。</p>
    <form>
    <table>
    <tr>
        @if(in_array(4, $array))
        <td><input type="text" id="insdeptno" name="deptno" value="70" pattern="^[1-9][0-9]$" required></td>
        <td><input type="text" id="insdname" name="dname" value="工事部"  required></td>
        <td><input type="text" id="insloc" name="loc" value="北海道" required></td>
        <td><input type="text" id="inssort" name="sort" value="100" pattern="^[1-9][0-9]+$" required></td>
        @endif
    </tr>
    </table><br>
    <ul style="text-align:right"><input type="reset" value="リセット"></ul>
    <button type="button" id="insert2btn" class="originalhidden">追加</button>
    </form>
</div>

{{-- 編集ダイアログ --}}

<div id="editlist2">
    <p>変更前を確認し、変更後に入力後、更新ボタンを押してください。</p>
    <table>
    <tr>
        <th>変更前</th>
        <td><input id="d1" style="text-align:center" disabled></td>
        <td><input id="d2" style="text-align:center" disabled></td>
        <td><input id="d3" style="text-align:center" disabled></td>
        <td><input id="d4" style="text-align:center" disabled></td>
    </tr>
    <tr>
        <th>変更後</th>
        <td><input type="text" style="text-align:center" id="dd1" value="80" pattern="^[1-9][0-9]$" required></td>
        <td><input type="text" style="text-align:center" id="dd2" value="工事部" required></td>
        <td><input type="text" style="text-align:center" id="dd3" value="大阪" required></td>
        <td><input type="text" style="text-align:center" id="dd4" value="100" pattern="^[1-9][0-9]+$" required></td>
    </tr>
    </table><br>
    <button type="button" id="edit2btn" class="originalhidden">更新</button>
</div>

{{-- 検索ダイアログ --}}
<div id="searchlist2">
    <p>部署名で絞り込みができます。</p>
    <p>検索したい文字を入力後、検索ボタンを押してください。</p>
    <form>
    <table>
    <tr>
        <th>部署名</th>
        <td><input type="search" placeholder="営業" name="dsearch" id="dsearch"></td>
        <td><input type="reset" value="リセット"></td>
    </tr>
    </table>
    <button type="button" id="dsearchbtn" class="originalhidden">検索</button>
    </form>
</div>

{{-- CSVインポートダイアログ --}}
<div id="app">
    <p>インポートしたいCSVファイルを選択し、</p>
    <p>インポートするボタンを押してください。</p>
    <form method="POST" id="my_form">
    @csrf
    <input type="file" id="csv_file" name="csv_file" class="form-control">
    <br>
    <br>
    <button type="button" id="import2" class="originalhidden">インポートする</button>
    <br>
    <div id="error"></div>
    </form>
</div>

<script type="text/javascript">
    $(function() {
        $("#insert2").click(function() {

        $("#insertlist2").dialog("open");
        return false;
        });

        $("#insertlist2").dialog({
        autoOpen: false,
        modal: true,
        title:"部署追加",
        width: 1000,
        height: 300,
        buttons: {
        "追加": function() {
            $('#insert2btn').click();
            $(this).dialog("close");
        },

        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    function edit2func(list) {
        var editArray = list.split(",");

        $('#d1').val(editArray[0]);
        $('#d2').val(editArray[1]);
        $('#d3').val(editArray[2]);
        $('#d4').val(editArray[3]);

        $("#editlist2").dialog("open");
        return false;
    }

    $(function() {
        $("#editlist2").dialog({
        autoOpen: false,
        modal: true,
        title:"編集",
        width: 1100,
        height: 300,
        buttons: {
        "更新": function() {
            $('#edit2btn').click();
            $(this).dialog("close");
        },
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    $(function() {
        $("#search2").click(function() {

        $('#dsearch').val("");

        $("#searchlist2").dialog("open");
        return false;
        });

        $("#searchlist2").dialog({
        autoOpen: false,
        modal: true,
        title:"検索",
        width: 550,
        height: 300,
        buttons: {
        "検索": function() {
            $('#dsearchbtn').click();
            $(this).dialog("close");
        },
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
        width: 400,
        buttons: {
        "インポートする": function() {
            $('#import2').click();
        },
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    $('.sortable').sortable({
        update: function( event, ui ) {
            var updateRows = $(this).sortable( 'toArray' );
            $("#list-ids").val(updateRows);
        }
    });
</script>
</x-app-layout>
