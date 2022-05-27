@extends('layouts.app2')

@section('content')

<h1>{{ $title }}</h1>

<table>
    @csrf
    <thead>
    <tr><th>ユーザＩＤ</th><th>社員コード</th><th>社員名</th><th>職種</th><th>上司コード</th><th>入社日</th><th>給与</th><th>comm</th><th>部署コード</th>
    </tr>
    </thead>
    </form>
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
</table>
<br>
<button type="button" onclick=location.href="/list1">一覧に戻る</button>

@endsection
