<x-app-layout>
    <x-slot name="header">
    <div class="wrap">
        <div class="title">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('社員一覧') }}
        </h2>
        </div>
        <div class="insert">
        @if(in_array(2, $array))
            <input type="button" id="insert1"   value="社員追加">
        @endif
        </div>
        <div class="category">
        <form action="{{ url('/empcsvd') }}" method="post">
        @csrf
            <input type="button" id="search1"  value="検索">
            <input type="submit" id="em"  value="CSVエクスポート">
            <input type="button" id="btn2" value="CSVインポート">
            <input type="hidden" name="enames">
            <input type="hidden" name="mins">
            <input type="hidden" name="maxs">
        </form>
        </div>
        <div class="sort">
        </div>
        <div class="page">
            <form action="{{ url('/list1') }}" method="get">
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

<form action="{{ url('/list1') }}" method="get">
@csrf
<table>
    <thead>
    <tr><th>ユーザＩＤ
        <input type="submit" name="sortid" value="▲">
        <input type="submit" name="sortid" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>社員コード
        <input type="submit" name="sortempno" value="▲">
        <input type="submit" name="sortempno" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>社員名
        <input type="submit" name="sortename" value="▲">
        <input type="submit" name="sortename" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>職種
        <input type="submit" name="sortjob" value="▲">
        <input type="submit" name="sortjob" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>上司コード
        <input type="submit" name="sortmgr" value="▲">
        <input type="submit" name="sortmgr" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>入社日
        <input type="submit" name="sorthiredate" value="▲">
        <input type="submit" name="sorthiredate" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>給与
        <input type="submit" name="sortsal" value="▲">
        <input type="submit" name="sortsal" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>comm
        <input type="submit" name="sortcomm" value="▲">
        <input type="submit" name="sortcomm" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>部署コード
        <input type="submit" name="sortdeptno" value="▲">
        <input type="submit" name="sortdeptno" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th width="100">画像1
        </th>
        <th width="100">画像2
        </th>
        @if(in_array(2, $array))
        <th>編集</th>
        <th>削除</th>
        @endif
        <th>役割</th>
    </tr>
    </thead>
</form>
    <tbody id="list1">
    @foreach ($members as $member)
    <tr>
        <td>{{ $member->id }}</td>
        <td>{{ $member->empno }}</td>
        <td>{{ $member->ename }}</td>
        <td>{{ $member->job }}</td>
        <td>{{ $member->mgr }}</td>
        <td>{{ $member->hiredate }}</td>
        <td>{{ $member->sal }}</td>
        <td>{{ $member->comm }}</td>
        <td>{{ $member->deptno }}</td>
        <td>
            @if (!is_null($member->img1))
                {{-- data:image/png;base64,をつけてあげることによって、base64でエンコードされた画像を表示するという記法になる --}}
                <img class="listmyimg" src="data:image/png;base64,{{ $member->img1 }}" width="30px">
            @else
                <img class="listmyimg" src="{{ \Storage::url('img/no_image.jpg') }}" width="30px">
            @endif
            @if(in_array(2, $array))
                <button type="button" class="img1" onclick="img1func({{ $member->empno }})">変更</button>
            @endif
        </td>
        <td>
            @if (!is_null($member->img2))
                <img class="listmyimg" src="{{ \Storage::url('img/'.$member->img2) }}" width="30px">
            @else
                <img class="listmyimg" src="{{ \Storage::url('img/no_image.jpg') }}" width="30px">
            @endif
            @if(in_array(2, $array))
                <button type="button" class="img2" onclick="img2func({{ $member->empno }})">変更</button>
            @endif
        </td>
        @if(in_array(2, $array))
        <td><button type="button" class="edit1" value="{{ $member->id }}, {{ $member->empno }}, {{ $member->ename }}, {{ $member->job }}, {{ $member->mgr }}, {{ $member->hiredate }}, {{ $member->sal }}, {{ $member->comm }}, {{ $member->deptno }}" onclick="edit1func(this.value)">編集</button></td>
        <td><button type="button" class="delete1" value="{{ $member->empno }}">削除</button></td>
        @endif
        <td>{{ $member->name }}
        @if($roles_name === '管理者')
            <br>
            <button type="button"  class="role1" onclick="roleselect({{ $member->empno }})">変更</button>
        @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
<br>
<div id="pager">
{{ $members->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>

{{-- 追加ダイアログ --}}
<div id="insertlist1">
    <p>新しく社員を追加できます。下記項目に入力後、追加ボタンを押してください。</p>
    <font size="2">例.</font>
    <table>
        <tr>
            <td><input style="text-align:center" class="resize" value="6001tanaka" disabled></td>
            <td><input style="text-align:center" class="resize" value="5555" disabled></td>
            <td><input style="text-align:center" class="resize" value="田中太郎" disabled></td>
            <td><input style="text-align:center" class="resize" value="工事" disabled></td>
            <td><input style="text-align:center" class="resize" value="8888" disabled></td>
            <td><input style="text-align:center" class="resize" value="2000-10-10" disabled></td>
            <td><input style="text-align:center" class="resize" value="800" disabled></td>
            <td><input style="text-align:center" class="resize" value="200" disabled></td>
            <td><input style="text-align:center" class="resize" value="30" disabled></td>
        </tr>
    </table><br>
    <form>
    <table>
    <tr>
        <td><input type="text" style="text-align:center" class="resize" id="insid" name="user_id" value="6001tanaka" pattern="^[a-zA-Z0-9!-\/:-@¥[-`{_~?]+$" required></td>
        <td><input type="text" style="text-align:center" class="resize" id="insempno" name="empno" value="5555" pattern="^([1-9][0-9]{3})" required></td>
        <td><input type="text" style="text-align:center" class="resize" id="insename" name="ename" value="田中太郎"  required></td>
        <td><input type="text" style="text-align:center" class="resize" id="insjob" name="job" value="工事" required></td>
        <td><input type="text" style="text-align:center" class="resize" id="insmgr" name="mgr" value="8888" pattern="^([1-9][0-9]{3})"></td>
        <td><input type="text" style="text-align:center" class="resize" id="inshiredate" name="hiredate" value="2000-10-10" pattern="\d{4}-\d{2}-\d{2}" required></td>
        <td><input type="text" style="text-align:center" class="resize" id="inssal" name="sal" value="800" pattern="^[1-9][0-9]*"></td>
        <td><input type="text" style="text-align:center" class="resize" id="inscomm" name="comm" value="200" pattern="^[1-9][0-9]*"></td>
        <td><select id="insdeptno">
            @foreach ($droplist as $list)
                <option>{{ $list->deptno }}:{{ $list->dname }}</option>
            @endforeach
        </select></td>
    </tr>
    </table><br>
    <div class="err_ins1" id="err_ins1"></div>
    <ul style="text-align:right"><input type="reset" value="入力リセット"></ul>
    <button type="button" id="insert1btn" class="originalhidden">追加</button>
    </form>
</div>

{{-- 編集ダイアログ --}}
<div id="editlist1">
    <p>変更前を確認し、変更後に入力後、更新ボタンを押してください。</p>
    <table>
    <tr>
        <th>変更前</th>
        <td><input id="e1" style="text-align:center" class="resize" disabled></td>
        <td><input id="e2" style="text-align:center" class="resize" disabled></td>
        <td><input id="e3" style="text-align:center" class="resize" disabled></td>
        <td><input id="e4" style="text-align:center" class="resize" disabled></td>
        <td><input id="e5" style="text-align:center" class="resize" disabled></td>
        <td><input id="e6" style="text-align:center" class="resize" disabled></td>
        <td><input id="e7" style="text-align:center" class="resize" disabled></td>
        <td><input id="e8" style="text-align:center" class="resize" disabled></td>
        <td><input id="e9" style="text-align:center" class="resize" disabled></td>
    </tr>
    <tr>
        <th>変更後</th>
        <td><input type="text" style="text-align:center" class="resize" id="ee1" value="8080itou" pattern="^[a-zA-Z0-9!-\/:-@¥[-`{_~?]+$" required></td>
        <td><input type="text" style="text-align:center" class="resize" id="ee2" value="8080" pattern="^([1-9][0-9]{3}$)" required></td>
        <td><input type="text" style="text-align:center" class="resize" id="ee3" value="伊藤次郎"  required></td>
        <td><input type="text" style="text-align:center" class="resize" id="ee4" value="工事" required></td>
        <td><input type="text" style="text-align:center" class="resize" id="ee5" value="8888" pattern="^([1-9][0-9]{3}$)"></td>
        <td><input type="text" style="text-align:center" class="resize" id="ee6" value="2005-10-10" pattern="\d{4}-\d{1,2}-\d{1,2}$" required></td>
        <td><input type="text" style="text-align:center" class="resize" id="ee7" value="1200" pattern="^[1-9][0-9]*$"></td>
        <td><input type="text" style="text-align:center" class="resize" id="ee8" value="200" pattern="^[1-9][0-9]*$"></td>
        <td>
        <select id="ee9">
            @foreach ($droplist as $list)
                <option>{{ $list->deptno }}:{{ $list->dname }}</option>
            @endforeach
        </select>
        </td>
    </tr>
    </table><br>
    <button type="button" id="edit1btn" class="originalhidden">更新</button>
</div>

{{-- 検索ダイアログ --}}
<div id="searchlist1">
    <p>社員名で絞り込みができます。</p>
    <p>検索したい文字を入力後、検索ボタンを押してください。</p>
    <form>
    <table>
    <tr>
        <th>社員名</th>
        <td colspan="2"><input type="search" placeholder="山田" name="enamesearch" id="esearch"></td>
        <td><input type="reset" value="リセット"></td>
    </tr>
    </table>
    </form><br>
    <form>
    <table>
    <p>給与を最小、最大を指定し絞り込みができます。
    <p>入力後、検索ボタンを押してください。</p>
    <tr>
        <th>給与</th>
        <td>最小<input type="number" class="num" name="minsearch" id="minnum"></td>
        <td>最大<input type="number" class="num" name="maxsearch" id="maxnum"></td>
        <td><input type="reset" value="リセット"></td>
    </tr>
    </table>
    <button type="button" id="search1btn" class="originalhidden">検索</button>
    </form><br>
    <p>※社員名、給与、併せて検索もできます。
</div>

{{-- CSVインポートダイアログ --}}
<div id="app2">
    <p>インポートしたいCSVファイルを選択し、</p>
    <p>インポートするボタンを押してください。</p>
    <form method="POST" id="my_form2">
    @csrf
    <input type="file" id="csv_file" name="csv_file" class="form-control">
    <br><br>
    <button type="button" id="import1" class="originalhidden">インポートする</button>
    <br>
    <div id="error"></div>
    </form>
</div>

{{-- 画像1追加ダイアログ --}}
<div id="select_img1">
    <p>変更したい画像ファイルを選択し、</p>
    <p>アップロードボタンを押してください。</p><br>
    <P>対応拡張子(.jpg　.gif　.png)</p>
    <form method="POST" enctype="multipart/form-data"  id="img1_form">
    @csrf
    <input type="hidden" id="dialog_empno">
    <input type="file" accept="image/*" id="simg1" name="simg1" class="form-control">
    <br><br>
    <button type="button" id="inimg1" class="originalhidden">アップロード</button>
    <br>
    <div id="img1error"></div>
    </form>
</div>

{{-- 画像2追加ダイアログ --}}
<div id="select_img2">
    <p>変更したい画像ファイルを選択し、</p>
    <p>アップロードボタンを押してください。</p><br>
    <P>対応拡張子(.jpg　.gif　.png)</p>
    <form method="POST" enctype="multipart/form-data"  id="img2_form">
    @csrf
    <input type="hidden" id="dialog_empno">
    <input type="file" accept="image/*" id="simg2" name="simg2" class="form-control">
    <br><br>
    <button type="button" id="inimg2" class="originalhidden">アップロード</button>
    <br>
    <div id="img2error"></div>
    </form>
</div>

{{-- 役割変更ダイアログ --}}
<div id="role_edit">
    <form method="POST" id="roles">
    @csrf
    <input type="hidden" id="dialog_empno">
    <select class="tag-id" id="tag-id" name="tag_id">
        @foreach (Config::get('role_list.role') as $key => $val)
            <option value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>
    <br><br>
    <button type="button" id="role_change" class="originalhidden">変更</button>
    <br>
    <div id="roleerror"></div>
    </form>
</div>

<script type="text/javascript">
    $(function() {
        $("#insert1").click(function() {

            // $('#insid').val("");
            // $('#insempno').val("");
            // $('#insename').val("");
            // $('#insjob').val("");
            // $('#insmgr').val("");
            // $('#inshiredate').val("");
            // $('#inssal').val("");
            // $('#inscomm').val("");
            // $('#insdeptno').val("");

        $("#insertlist1").dialog("open");
        return false;
        });

        $("#insertlist1").dialog({
        autoOpen: false,
        modal: true,
        title:"社員追加",
        width: 1500,
        height: 420,
        buttons: {
        "追加": function() {
            $('#insert1btn').click();
            $(this).dialog("close");
        },

        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    function edit1func(list) {
        var editArray = list.split(",");
        $('#e1').val(editArray[0]);
        $('#e2').val(editArray[1]);
        $('#e3').val(editArray[2]);
        $('#e4').val(editArray[3]);
        $('#e5').val(editArray[4]);
        $('#e6').val(editArray[5]);
        $('#e7').val(editArray[6]);
        $('#e8').val(editArray[7]);
        $('#e9').val(editArray[8]);

        $("#editlist1").dialog("open");
        return false;
    }

    $(function() {
        $("#editlist1").dialog({
        autoOpen: false,
        modal: true,
        title:"編集",
        width: 1500,
        height: 300,
        buttons: {
        "更新": function() {
            $('#edit1btn').click();
            $(this).dialog("close");
        },
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    $(function() {
        $("#search1").click(function() {

            $('#esearch').val("");
            $('#minnum').val("");
            $('#maxnum').val("");

            $("#searchlist1").dialog("open");
        return false;
        });

        $("#searchlist1").dialog({
        autoOpen: false,
        modal: true,
        title:"検索",
        width: 550,
        height: 450,
        buttons: {
        "検索": function() {
            $('#search1btn').click();
            // $(this).dialog("close");
        },
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

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
        width: 400,
        buttons: {
        "インポートする": function() {
            $('#import1').click();
        },
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    function img1func(empno) {
        $('#simg1').val("");
        $('#img1error').html("");
        $('#dialog_empno').val(empno);

        $("#select_img1").dialog("open");
    }

    $(function() {
        $("#select_img1").dialog({
        autoOpen: false,
        modal: true,
        title:"画像選択",
        width: 400,
        buttons: {
        "アップロード": function() {
            $('#inimg1').click();
        },
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    function img2func(empno) {
        $('#simg2').val("");
        $('#img2error').html("");
        $('#dialog_empno').val(empno);

        $("#select_img2").dialog("open");
    }

    $(function() {
        $("#select_img2").dialog({
        autoOpen: false,
        modal: true,
        title:"画像選択",
        width: 400,
        buttons: {
        "アップロード": function() {
            $('#inimg2').click();
        },
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    function roleselect(empno) {
        $('#tag-id').val("");
        $('#roleerror').html("");
        $('#dialog_empno').val(empno);

        $("#role_edit").dialog("open");
    }

    $(function() {
        $("#role_edit").dialog({
        autoOpen: false,
        modal: true,
        title:"役割選択",
        buttons: {
        "変更": function() {
            $('#role_change').click();
            $(this).dialog("close");
        },
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });


</script>
</x-app-layout>
