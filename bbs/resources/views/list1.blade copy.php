<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('社員一覧') }}
        </h2>
    </x-slot>

<form action="{{ url('/list1') }}" method="get">
<table class="list1">
    @csrf
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
        @if($roles_name === '管理者')
        <th>役割</th>
        @endif
    </tr>
    </thead>
    </form>
    <tbody>
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
            <div class="listimgArea">
            <div class="list">
                @if (!is_null($member->img1))
                {{-- data:image/png;base64,をつけてあげることによって、base64でエンコードされた画像を表示するという記法になる --}}
                <img class="listmyimg" src="data:image/png;base64,{{ $member->img1 }}">
            @else
                <img class="listmyimg" src="{{ \Storage::url('img/no_image.jpg') }}">
            @endif
            @if(in_array(2, $array))
            <form method="post" enctype="multipart/form-data" id="img1_form">
                <div id="drop-zone1" class="drop-zone1list">
                    <font size="2">画像をドラッグ＆ドロップ<br>もしくは</font><br>
                    <label class="original2">
                    ファイルを選択
                    <input type="hidden" id="dialog_empno" value="{{ Auth::user()->empno }}">
                    <input type="file" name="simg1" id="simg1" style="display:none">
                    </label>
                </div>
            </div>
            <div class="list">
                <div id="preview1" class="preview1list"></div>
                <button type="button" id="inimg1" style="display:none">変更</button>
                <div id="img1error"></div>
            </div>
            </div>
            </form>
            @endif
        </td>
        <td>
            <div class="listimgArea">
            <div class="list">
            @if (!is_null($member->img2))
                <img class="listmyimg" src="{{ \Storage::url('img/'.$member->img2) }}">
            @else
                <img class="listmyimg" src="{{ \Storage::url('img/no_image.jpg') }}">
            @endif
            @if(in_array(2, $array))
            <form method="post" enctype="multipart/form-data" id="img2_form">
                <div id="drop-zone2" class="drop-zone2list">
                    <font size="2">画像をドラッグ＆ドロップ<br>もしくは</font><br>
                    <label class="original2">
                    ファイルを選択
                    <input type="hidden" id="dialog_empno" value="{{ Auth::user()->empno }}">
                    <input type="file" name="simg2" id="simg2" style="display:none">
                    </label>
                </div>
            </div>
            <div class="list">
                <div id="preview2" class="preview2list"></div>
                <button type="button" id="inimg2" style="display:none">変更</button>
                <div id="img2error"></div>
            </div>
            </div>
            </form>
            @endif
        </td>
        @if(in_array(2, $array))
        <td><button type="button" class="edit1" value="{{ $member->id }}, {{ $member->empno }}, {{ $member->ename }}, {{ $member->job }}, {{ $member->mgr }}, {{ $member->hiredate }}, {{ $member->sal }}, {{ $member->comm }}, {{ $member->deptno }}">編集</button></td>
        <td><button type="button" class="delete1" value="{{ $member->empno }}">削除</button></td>
        @endif
        @if($roles_name === '管理者')
        <td>{{ $member->name }}<br>
            <button type="button"  class="role1" onclick="roleselect({{ $member->empno }})">変更</button>
        </td>
        @endif
    </tr>
    @endforeach
    <form action="{{ url('/list1') }}" method="post">
    @csrf
    <tr>
        @if(in_array(2, $array))
        <td><input type="text" class="resize" id="insid" name="user_id" value="6001tanaka" pattern="^[a-zA-Z0-9!-\/:-@¥[-`{_~?]+$" required></td>
        <td><input type="text" class="resize" id="insempno" name="empno" value="5555" pattern="^([1-9][0-9]{3})" required></td>
        <td><input type="text" class="resize" id="insename" name="ename" value="田中太郎"  required></td>
        <td><input type="text" class="resize" id="insjob" name="job" value="工事" required></td>
        <td><input type="text" class="resize" id="insmgr" name="mgr" value="8888" pattern="^([1-9][0-9]{3})"></td>
        <td><input type="text" class="resize" id="inshiredate" name="hiredate" value="2000-10-10" pattern="\d{4}-\d{2}-\d{2}" required></td>
        <td><input type="text" class="resize" id="inssal" name="sal" value="800" pattern="^[1-9][0-9]*"></td>
        <td><input type="text" class="resize" id="inscomm" name="comm" value="200" pattern="^[1-9][0-9]*"></td>
        <td><select id="insdeptno">
            @foreach ($droplist as $list)
                <option value="{{ $list->deptno }}">{{ $list->deptno }}</option>
            @endforeach
        </select></td>
        <td colspan="2"><input type="submit" id="insert1btn" value="社員追加"></td>
        <td colspan="2"><input type="reset" value="リセット"></td>
        @endif
    </tr>
    </tbody>
</table>
</form>
<br>
@if(in_array(2, $array))
<h1>編集</h1>
<table>
<tr>
    <th>変更前</th>
    <td id="e1"></td>
    <td id="e2"></td>
    <td id="e3"></td>
    <td id="e4"></td>
    <td id="e5"></td>
    <td id="e6"></td>
    <td id="e7"></td>
    <td id="e8"></td>
    <td id="e9"></td>
    <td></td>
</tr>
<tr>
    <th>変更後</th>
    <td><input type="text" class="resize" id="ee1" value="8080itou" pattern="^[a-zA-Z0-9!-\/:-@¥[-`{_~?]+$" required></td>
    <td><input type="text" class="resize" id="ee2" value="8080" pattern="^([1-9][0-9]{3})" required></td>
    <td><input type="text" id="ee3" value="伊藤次郎"  required></td>
    <td><input type="text" class="resize" id="ee4" value="工事" required></td>
    <td><input type="text" class="resize" id="ee5" value="8888" pattern="^([1-9][0-9]{3})"></td>
    <td><input type="text" id="ee6" value="2005-10-10" pattern="\d{4}-\d{1,2}-\d{1,2}" required></td>
    <td><input type="text" class="resize" id="ee7" value="1200" pattern="^[1-9][0-9]*"></td>
    <td><input type="text" class="resize" id="ee8" value="200" pattern="^[1-9][0-9]*"></td>
    <td><select id="ee9">
        @foreach ($droplist as $list)
            <option value="{{ $list->deptno }}">{{ $list->deptno }}</option>
        @endforeach
    </select></td>
    <td><input type="submit" id="edit1btn" value="更新"></td>
</tr>
</table>
@endif
<form action="{{ url('/list1') }}" method="get">
@csrf
<p>表示件数：<input type="number" name="dispnum" value="5" id="dispnum">
            <input type="hidden" name="sorton" value={{ $sort }}>
            <input type="hidden" name="category" value={{ $category }}>
            <input type="submit" name="submit" value="変更">
</p>
</form>
{{ $members->appends(request()->query())->links('pagination::bootstrap-4') }}
<form action="{{ url('/empcsvd') }}" method="post">
    @csrf
        <input type="submit" id="em"  value="CSVエクスポート"><input type="button" id="btn2" value="CSVインポート">

    <h1>検索</h1>
    <table>
        <thead></thead>
        <tbody>
        <tr>
            <th>社員名</th>
            <td colspan="2"><input type="search" placeholder="山田" name="enamesearch" id="esearch"></td>
            <td><button type="button" id="esearchbtn">検索</button></td>
            <td rowspan="2"><input type="reset" value="リセット"></td>
        </tr>
        <tr>
            <th>給与</th>
            <td>最小<input type="number" class="num" name="minsearch" id="minnum"></td>
            <td>最大<input type="number" class="num" name="maxsearch" id="maxnum"></td>
            <td><button type="button" id="salsearchbtn">検索</button></td>
        </tr>
    </tbody>
</table>
</form>

<h4>検索結果</h4>
<table width="1200" id="tbl">
</table>

<div id="app2">
    <form method="POST" id="my_form2">
    @csrf
    <input type="file" id="csv_file" name="csv_file" class="form-control">
    <br><br>
    <button type="button" id="import1">インポートする</button>
    <br>
    <div id="error"></div>
    </form>
</div>

<div id="select_img1">
    <form method="POST" enctype="multipart/form-data"  id="img1_form">
    @csrf
    <input type="hidden" id="dialog_empno">
    <input type="file" accept="image/*" id="simg1" name="simg1" class="form-control">
    <br><br>
    <button type="button" id="inimg1">アップロード</button>
    <br>
    <div id="img1error"></div>
    </form>
</div>

<div id="select_img2">
    <form method="POST" enctype="multipart/form-data"  id="img2_form">
    @csrf
    <input type="hidden" id="dialog_empno">
    <input type="file" accept="image/*" id="simg2" name="simg2" class="form-control">
    <br><br>
    <button type="button" id="inimg2">アップロード</button>
    <br>
    <div id="img2error"></div>
    </form>
</div>

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
    <button type="button" id="role_change">変更</button>
    <br>
    <div id="roleerror"></div>
    </form>
</div>
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
        buttons: {
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
        buttons: {
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
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    var dropZone1 = document.getElementById('drop-zone1');
    var preview1 = document.getElementById('preview1');
    var fileInput1 = document.getElementById('simg1');

    dropZone1.addEventListener('dragover', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffff00';
    }, false);

    dropZone1.addEventListener('dragleave', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffe0';
    }, false);

    fileInput1.addEventListener('change', function () {
        previewFile1(this.files[0]);
    });

    dropZone1.addEventListener('drop', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffe0'; //背景色を白に戻す
        var files = e.dataTransfer.files; //ドロップしたファイルを取得
        if (files.length > 1) return alert('アップロードできるファイルは1つだけです。');
        fileInput1.files = files; //inputのvalueをドラッグしたファイルに置き換える。

        var simg1 = document.getElementById('simg1').value;
        // ファイル名の末尾のカンマの位置を取得
        var position1 = simg1.lastIndexOf('.');
        // // indexから一つ目の配列要素を切り取り拡張子を取得
        var extension1 = simg1.slice(position1 + 1);
        // チェックの処理に拡張子を渡す
        check_extension(extension1);

        function check_extension(extensionName1) {
        // 許可する拡張子を指定
        var extensionArray1 = ['jpg', 'png', 'gif'];
        // 拡張子文字列を小文字に変換
        var extension1 = extensionName1.toLowerCase();
        // 許可配列から一致する値を検索
        if(extensionArray1.indexOf(extension1) !== -1) {
            $('#img1error').html("");
            document.getElementById('inimg1').style.display = 'inline';
            previewFile1(files[0]);
        } else {
            $('#preview1').html("");
            $('#img1error').html("");
            document.getElementById('inimg1').style.display = 'none';
            $("#img1error").append('ファイル形式が不適切です。');
        }
        }
    }, false);

    function previewFile1(file) {
        //FileReaderで読み込み、プレビュー画像を表示
        var fr = new FileReader();

        //ファイル読み込み完了時のイベントリスナ
        fr.addEventListener("load", function(e) {
                var img = new Image();

            //画像としての読み込みを待機
            img.addEventListener("load", function() {
                if (img.width > 300 || img.height > 300) {
                    $('#preview1').html("");
                    $('#img1error').html("");
                    document.getElementById('inimg1').style.display = 'none';
                    $("#img1error").append('画像サイズは300x300までです。');
                }
            });

            //DataURLをsrcにセットする
            img.src = e.target.result;

        }, false);

        fr.readAsDataURL(file);

        fr.onload = function() {
            var img = document.createElement('img');
            img.setAttribute('src', fr.result);
            preview1.innerHTML = '';
            preview1.appendChild(img);
        };
    }

    var dropZone2 = document.getElementById('drop-zone2');
    var preview2 = document.getElementById('preview2');
    var fileInput2 = document.getElementById('simg2');

    dropZone2.addEventListener('dragover', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffff00';
    }, false);

    dropZone2.addEventListener('dragleave', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffe0';
    }, false);

    fileInput2.addEventListener('change', function () {
        previewFile2(this.files[0]);
    });

    dropZone2.addEventListener('drop', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffe0'; //背景色を白に戻す
        var files = e.dataTransfer.files; //ドロップしたファイルを取得
        if (files.length > 1) return alert('アップロードできるファイルは1つだけです。');
        fileInput2.files = files; //inputのvalueをドラッグしたファイルに置き換える。

        var simg2 = document.getElementById('simg2').value;
        // ファイル名の末尾のカンマの位置を取得
        var position2 = simg2.lastIndexOf('.');
        // // indexから一つ目の配列要素を切り取り拡張子を取得
        var extension2 = simg2.slice(position2 + 1);
        // チェックの処理に拡張子を渡す
        check_extension(extension2);

        function check_extension(extensionName2) {
        // 許可する拡張子を指定
        var extensionArray2 = ['jpg', 'png', 'gif'];
        // 拡張子文字列を小文字に変換
        var extension2 = extensionName2.toLowerCase();
        // 許可配列から一致する値を検索
        if(extensionArray2.indexOf(extension2) !== -1) {
            $('#img2error').html("");
            document.getElementById('inimg2').style.display = 'inline';
            previewFile2(files[0]);
        } else {
            $('#preview2').html("");
            $('#img2error').html("");
            document.getElementById('inimg2').style.display = 'none';
            $("#img2error").append('ファイル形式が不適切です。');
        }
        }
    }, false);

    function previewFile2(file) {
        //FileReaderで読み込み、プレビュー画像を表示
        var fr = new FileReader();

        //ファイル読み込み完了時のイベントリスナ
        fr.addEventListener("load", function(e) {
                var img = new Image();

            //画像としての読み込みを待機
            img.addEventListener("load", function() {
                if (img.width > 300 || img.height > 300) {
                    $('#preview2').html("");
                    $('#img2error').html("");
                    document.getElementById('inimg2').style.display = 'none';
                    $("#img2error").append('画像サイズは300x300までです。');
                }
            });

            //DataURLをsrcにセットする
            img.src = e.target.result;

        }, false);

        fr.readAsDataURL(file);

        fr.onload = function() {
            var img = document.createElement('img');
            img.setAttribute('src', fr.result);
            preview2.innerHTML = '';
            preview2.appendChild(img);
        };
    }

</script>
</x-app-layout>
