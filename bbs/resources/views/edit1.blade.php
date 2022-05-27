@extends('layouts.app2')

@section('content')

<h1>{{ $title }}</h1>

<p>データを変更後、更新ボタンをクリックしてください。</p><br>

<form action="{{ url('/edit1_2') }}" method="post">
<table border="1">
    @csrf
    <thead>
    <tr><th></th><th>ユーザＩＤ</th><th>社員コード</th><th>社員名</th><th>職種</th><th>上司コード</th><th>入社日</th><th>給与</th><th>comm</th><th>部署コード</th></tr>
    </thead>
    <tbody>
    @foreach ($members as $member)
    <tr>
        <td>編集前</td>
        <td>{{ $member->id }}</td>
        <td>{{ $member->empno }}</td>
        <td>{{ $member->ename }}</td>
        <td>{{ $member->job }}</td>
        <td>{{ $member->mgr }}</td>
        <td>{{ $member->hiredate }}</td>
        <td>{{ $member->sal }}</td>
        <td>{{ $member->comm }}</td>
        <td>{{ $member->deptno }}</td>
        <br />
        <input type="hidden" name="empno2" value={{ $member->empno }}>
    </tr>
    <tr>
        <td>編集後</td>
        <td><input type="text" name="user_id" value="6001" pattern="^[a-zA-Z0-9!-\/:-@¥[-`{_~?]+$" required></td>
        <td><input type="text" name="empno" value="5555" pattern="^([1-9][0-9]{3})" required></td>
        <td><input type="text" name="ename" value="伊藤太郎"  required></td>
        <td><input type="text" name="job" value="工事" required></td>
        <td><input type="text" name="mgr" value="8888" pattern="^([1-9][0-9]{3})"></td>
        <td><input type="datetime" name="hiredate" value="2000-10-10" pattern="\d{4}-\d{2}-\d{2}" required></td>
        <td><input type="text" name="sal" value="800" pattern="^[1-9][0-9]*"></td>
        <td><input type="text" name="comm" value="200" pattern="^[1-9][0-9]*"></td>
        <td><input type="text" name="deptno" value="50" pattern="^[1-9][0-9]$" required></td>
    </tr>
    @endforeach
    </tbody>
</table>
<br>
<input type="submit" name="submit" value="更新">
</form>

@endsection
