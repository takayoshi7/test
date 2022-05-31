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
            @if (!is_null($member->img1))
                {{-- data:image/png;base64,をつけてあげることによって、base64でエンコードされた画像を表示するという記法になる --}}
                <img src="data:image/png;base64,{{ $member->img1 }}" width="30px">
                @if(in_array(2, $array))
                <button type="button" class="img1" onclick="img1func({{ $member->empno }})">変更</button>
                @endif
            @else
                <img src="{{ \Storage::url('img/no_image.jpg') }}" width="30px">
                @if(in_array(2, $array))
                <button type="button" class="img1" onclick="img1func({{ $member->empno }})">変更</button>
                @endif
            @endif
        </td>
        <td>
            @if (!is_null($member->img2))
                <img src="{{ \Storage::url('img/'.$member->img2) }}" width="30px">
                @if(in_array(2, $array))
                <button type="button" class="img2" onclick="img2func({{ $member->empno }})">変更</button>
                @endif
            @else
                <img src="{{ \Storage::url('img/no_image.jpg') }}" width="30px">
                @if(in_array(2, $array))
                <button type="button" class="img2" onclick="img2func({{ $member->empno }})">変更</button>
                @endif
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
        <td><input type="text" class="resize" id="insid" name="user_id" value="6001itou" pattern="^[a-zA-Z0-9!-\/:-@¥[-`{_~?]+$" required></td>
        <td><input type="text" class="resize" id="insempno" name="empno" value="5555" pattern="^([1-9][0-9]{3})" required></td>
        <td><input type="text" id="insename" name="ename" value="伊藤太郎"  required></td>
        <td><input type="text" class="resize" id="insjob" name="job" value="工事" required></td>
        <td><input type="text" class="resize" id="insmgr" name="mgr" value="8888" pattern="^([1-9][0-9]{3})"></td>
        <td><input type="text" id="inshiredate" name="hiredate" value="2000-10-10" pattern="\d{4}-\d{2}-\d{2}" required></td>
        <td><input type="text" class="resize" id="inssal" name="sal" value="800" pattern="^[1-9][0-9]*"></td>
        <td><input type="text" class="resize" id="inscomm" name="comm" value="200" pattern="^[1-9][0-9]*"></td>
        <td><input type="text" class="resize" id="insdeptno" name="deptno" value="50" pattern="^[1-9][0-9]$" required></td>
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
    <td><input type="text" class="resize" id="ee9" value="50" pattern="^[1-9][0-9]$" required></td>
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

<h2>検索結果</h2>

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

</x-app-layout>
