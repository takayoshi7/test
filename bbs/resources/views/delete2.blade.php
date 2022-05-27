@extends('layouts.app2')

@section('content')

<h1>{{ $title }}</h1>

<p>このデータでよければ、削除ボタンをクリックしてください。</p>

<form action="{{ url('/delete2_2') }}" method="post">
<table border="1">
    @csrf
    <thead>
    <tr><th>部署コード</th><th>部署名</th><th>場所</th></tr>
    </thead>
    <tbody>
    @foreach ($DEPT as $member)
    <tr>
        <td width="100">{{ $member->deptno }}</td>
        <td width="100">{{ $member->dname }}</td>
        <td width="100">{{ $member->loc }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
<br />
    <input type="hidden" name="deptno" value={{ $member->deptno }}>
    <input type="hidden" name="dname" value={{ $member->dname }}>
    <input type="hidden" name="loc" value={{ $member->loc }}>
<br>
<input type="submit" name="submit" value="削除">
</form>

@endsection
