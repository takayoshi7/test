@extends('layouts.app2')

@section('content')

<h1>{{ $title }}</h1>

<p>データを変更後、更新ボタンをクリックしてください。</p><br>

<form action="{{ url('/edit2_2') }}" method="post">
<table border="1">
    @csrf
    <thead>
    <tr><th></th><th>部署コード</th><th>部署名</th><th>場所</th></tr>
    </thead>
    <tbody>
    @foreach ($DEPT as $member)
    <tr>
        <td>編集前</td>
        <td>{{ $member->deptno }}</td>
        <td>{{ $member->dname }}</td>
        <td>{{ $member->loc }}</td>
        <br />
        <input type="hidden" name="deptno2" value={{ $member->deptno }}>
    </tr>
    <tr>
        <td>編集後</td>
        <td><input type="text" name="deptno" value="70" pattern="^[1-9][0-9]$" required></td>
        <td><input type="text" name="dname" value="工事部"  required></td>
        <td><input type="text" name="loc" value="北海道" required></td>
    </tr>
    @endforeach
    </tbody>
</table>
<br>
<input type="submit" name="submit" value="更新">
</form>

@endsection
