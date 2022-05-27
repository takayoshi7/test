@extends('layouts.app2')

@section('content')

<h1>{{ $title }}</h1>

<p>このデータでよければ、削除ボタンをクリックしてください。</p>

<form action="{{ url('/delete1_2') }}" method="post">
<table border="1">
    @csrf
    <thead>
    <tr><th>ユーザＩＤ</th><th>社員コード</th><th>社員名</th><th>職種</th><th>上司コード</th><th>入社日</th><th>給与</th><th>comm</th><th>部署コード</th></tr>
    </thead>
    <tbody>
    @foreach ($members as $member)
    <tr>
        <td width="100">{{ $member->id }}</td>
        <td width="100">{{ $member->empno }}</td>
        <td width="100">{{ $member->ename }}</td>
        <td width="100">{{ $member->job }}</td>
        <td width="100">{{ $member->mgr }}</td>
        <td width="100">{{ $member->hiredate }}</td>
        <td width="100">{{ $member->sal }}</td>
        <td width="100">{{ $member->comm }}</td>
        <td width="100">{{ $member->deptno }}</td>
    </tr>
    @endforeach
    </tbody>
    <br />
        <input type="hidden" name="user_id" value={{ $member->id }}>
        <input type="hidden" name="empno" value={{ $member->empno }}>
        <input type="hidden" name="ename" value={{ $member->ename }}>
        <input type="hidden" name="job" value={{ $member->job }}>
        <input type="hidden" name="mgr" value={{ $member->mgr }}>
        <input type="hidden" name="hiredate" value={{ $member->hiredate }}>
        <input type="hidden" name="sal" value={{ $member->sal }}>
        <input type="hidden" name="comm" value={{ $member->comm }}>
        <input type="hidden" name="deptno" value={{ $member->deptno }}>
    <br>
</table>
<br>
<input type="submit" name="submit" value="削除">
</form>

@endsection
