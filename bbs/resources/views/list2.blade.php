<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('部署一覧') }}
        </h2>
    </x-slot>

<form action="{{ url('/list2') }}" method="get">
<table>
    @csrf
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
        @if(in_array(4, $array))
        <th>編集</th>
        <th>削除</th>
        @endif
    </tr>
    </thead>
</form>
    <tbody>
    @foreach ($depte as $depts) {{--Controllerから渡された$dataのDEPT(DBのデータが入っている)をasを使いDEPTSに変えた--}}
    <tr>
        <td>{{ $depts->deptno }}</td>
        <td>{{ $depts->dname }}</td>
        <td>{{ $depts->loc }}</td>
        @if(in_array(4, $array))
        <td><button type="button" class="edit2" value="{{ $depts->deptno }}, {{ $depts->dname }}, {{ $depts->loc }}">編集</button></td>
        <td><button type="button" class="delete2" value="{{ $depts->deptno }}">削除</button></td>
        @endif
    </tr>
    @endforeach
<form action="{{ url('/list2') }}" method="post">
    @csrf
    <tr>
        @if(in_array(4, $array))
        <td><input type="text" id="insdeptno" name="deptno" value="70" pattern="^[1-9][0-9]$" required></td>
        <td><input type="text" id="insdname" name="dname" value="工事部"  required></td>
        <td><input type="text" id="insloc" name="loc" value="北海道" required></td>
        <td><input type="submit" id="insert2btn" value="追加"></td>
        <td><input type="reset" value="リセット"></td>
        @endif
    </tr>
    </tbody>
</table>
</form>
@if(in_array(4, $array))
<h1>編集</h1>
<table>
<tr>
    <th>変更前</th>
    <td id="d1"></td>
    <td id="d2"></td>
    <td id="d3"></td>
    <td></td>
</tr>
<tr>
    <th>変更後</th>
    <td><input type="text" id="dd1" value="80" pattern="^[1-9][0-9]$" required></td>
    <td><input type="text" id="dd2" value="工事部" required></td>
    <td><input type="text" id="dd3" value="大阪" required></td>
    <td><input type="submit" id="edit2btn" value="更新"></td>
</tr>
</table>
@endif
<form action="{{ url('/list2') }}" method="get">
    @csrf
    <p>表示件数：<input type="number" name="dispnum" value="3" id="dispnum">
                <input type="hidden" name="sorton" value={{ $sort }}>
                <input type="hidden" name="category" value={{ $category }}>
                <input type="submit" name="submit" value="変更">
    </p>
</form>
{{ $depte->appends(request()->query())->links('pagination::bootstrap-4') }}
<form action="{{ url('/deptcsvd') }}" method="post">
    @csrf
        <input type="submit" id="dep"  value="CSVエクスポート"><input type="button" id="btn3" value="CSVインポート">

    <h1>検索</h1>
    <table>
        <thead></thead>
        <tbody>
        <tr>
            <th>部署名</th>
            <td><input type="search" placeholder="営業" name="dnamesearch" id="dsearch"></td>
            <td><button type="button" id="dsearchbtn">検索</button></td>
            <td><input type="reset" value="リセット"></td>
    </form>
        </tr>
        </tbody>
    </table>
<h2>検索結果</h2>

<table width="400" id="tbl">
</table>

<div id="app">
    <form method="POST" id="my_form">
    @csrf
    <input type="file" id="csv_file" name="csv_file" class="form-control">
    <br>
    <br>
    <button type="button" id="import2">インポートする</button>
    <br>
    <div id="error"></div>
    </form>
</div>

</x-app-layout>
