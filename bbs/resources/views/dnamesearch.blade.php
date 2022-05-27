@extends('layouts.app2')

@section('content')

<h1>{{ $title }}</h1>

<table>
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
<br>
<button type="button" onclick=location.href="/list2">一覧に戻る</button>

@endsection
