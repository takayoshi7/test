@extends('layouts.app2')

@section('content')

<h1>{{ $title }}</h1>

<p>このデータでよければ、追加ボタンをクリックしてください。</p>

<form action="{{ url('/insert2_2')}}" method="post">
<table>
@csrf
    <thead>
    <tr><th>部署コード</th><th>部署名</th><th>場所</th></tr>
    </thead>
    <tbody>
    <tr>
        <td width="100">{{ $DEPT[0] }}</td>
        <td width="100">{{ $DEPT[1] }}</td>
        <td width="100">{{ $DEPT[2] }}</td>
    </tr>
    </tbody>
    <br />
        <input type="hidden" name="deptno" value={{ $DEPT[0] }}>
        <input type="hidden" name="dname" value={{ $DEPT[1] }}>
        <input type="hidden" name="loc" value={{ $DEPT[2] }}>
    <br>
</table>
<br>
<input type="submit" name="submit" value=" 追加">
</form>

@endsection
