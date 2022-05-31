<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ログ一覧') }}
        </h2>
    </x-slot>

<form action="{{ url('/log') }}" method="get">
<table class="log">
    @csrf
    <thead>
    <tr><th>アクセスタイム<br>
        <input type="submit" name="sortaccess_time" value="▲">
        <input type="submit" name="sortaccess_time" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>ログインＩＤ<br>
        <input type="submit" name="sortid" value="▲">
        <input type="submit" name="sortid" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>IPアドレス<br>
        <input type="submit" name="sortip" value="▲">
        <input type="submit" name="sortip" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>ユーザーエージェント<br>
        <input type="submit" name="sortagent" value="▲">
        <input type="submit" name="sortagent" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>セッションID<br>
        <input type="submit" name="sortsession" value="▲">
        <input type="submit" name="sortsession" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>アクセスURL<br>
        <input type="submit" name="sorturl" value="▲">
        <input type="submit" name="sorturl" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
        <th>実行操作<br>
        <input type="submit" name="sortoperation" value="▲">
        <input type="submit" name="sortoperation" value="▼">
        <input type="hidden" name="dispnum" value={{ $dispnum }}>
        </th>
    </tr>
    </thead>
    <tbody id="loglist">
    @foreach ($logger as $log)
    <tr>
        <td>{{ $log->access_time }}</td>
        <td>{{ $log->user_id }}</td>
        <td>{{ $log->ip_address }}</td>
        <td id="hoge">{{ $log->user_agent }}
        <input id="btn" type="button" value="ボタン" />
        </td>
        <td>{{ $log->session_id }}</td>
        <td>{{ $log->access_url }}</td>
        <td>{{ $log->operation }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
</form>

<form action="{{ url('/log') }}" method="get">
@csrf
<p>表示件数：<input type="number" name="dispnum" value="10" id="dispnum">
            <input type="hidden" name="sorton" value={{ $sort }}>
            <input type="hidden" name="category" value={{ $category }}>
            <input type="submit" name="submit" value="変更">
</p>
</form>
{{ $logger->appends(request()->query())->links('pagination::bootstrap-4') }}
<form action="{{ url('/logcsvd') }}" method="post">
    @csrf
    <input type="submit" id="logserch"  value="絞り込み">　　

    <input type="submit" value="CSVエクスポート">

<table id="logtbl">
</table>

<div id="rog_get">
    <p>選択</p>
    @csrf
    <select class="rog_list" id="rog_list" name="rog_list">
        @foreach (Config::get('log_list.list') as $key => $val)
            <option value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>
    <p>検索ワード</p>
    <input type="text" id="word" name="word" required>
    <button type="button" id="rog_display" class="originalhidden">適用</button>
</div>
</form>


</x-app-layout>
