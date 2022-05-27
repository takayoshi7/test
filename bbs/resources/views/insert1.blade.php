@extends('layouts.app2')

@section('content')

<h1>{{ $title }}</h1>

<p>このデータでよければ、追加ボタンをクリックしてください。</p>

<form action="{{ url('/insert1_2')}}" method="post">
<table>
@csrf
    <thead>
    <tr><th>ユーザＩＤ</th><th>社員コード</th><th>社員名</th><th>職種</th><th>上司コード</th><th>入社日</th><th>給与</th><th>comm</th><th>部署コード</th></tr>
    </thead>
    <tbody>
    <tr>
        <td width="100">{{ $members[0] }}</td>
        <td width="100">{{ $members[1] }}</td>
        <td width="100">{{ $members[2] }}</td>
        <td width="100">{{ $members[3] }}</td>
        <td width="100">{{ $members[4] }}</td>
        <td width="100">{{ $members[5] }}</td>
        <td width="100">{{ $members[6] }}</td>
        <td width="100">{{ $members[7] }}</td>
        <td width="100">{{ $members[8] }}</td>
    </tr>
    </tbody>
    <br />
        <input type="hidden" name="user_id" value={{ $members[0] }}>
        <input type="hidden" name="empno" value={{ $members[1] }}>
        <input type="hidden" name="ename" value={{ $members[2] }}>
        <input type="hidden" name="job" value={{ $members[3] }}>
        <input type="hidden" name="mgr" value={{ $members[4] }}>
        <input type="hidden" name="hiredate" value={{ $members[5] }}>
        <input type="hidden" name="sal" value={{ $members[6] }}>
        <input type="hidden" name="comm" value={{ $members[7] }}>
        <input type="hidden" name="deptno" value={{ $members[8] }}>
    <br>
</table>
<br>
<input type="submit" name="submit" value=" 追加">
</form>

@endsection
