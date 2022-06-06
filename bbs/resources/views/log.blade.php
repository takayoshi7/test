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
        <td id="ex_out">{{ Str::limit($log->user_agent, 50, '...') }}
        <button type="button" class="pop">表示</button>
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
<p id="pagenate">{{ $logger->appends(request()->query())->links('pagination::bootstrap-4') }}</p>
<form action="{{ url('/logcsvd') }}" method="post">
    @csrf
    <input type="submit" id="logserch"  value="絞り込み">　　

    <input type="submit" value="CSVエクスポート">

<table id="logtbl">
</table>
</form>

<div id="rog_get">
<dl class="cf">
    <dt class="title">選択</dt>
    <dd class="data ">
    <select id="rog_list" class="rog_list" name="rog_list" onchange="entryChange();">
        @foreach (Config::get('log_list.list') as $key => $val)
            <option value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>
    </dd>
</dl><br>
<dl id="timeID" class="cf">
    <dt class="title">検索ワード</dt>
    <input id="word" type="text" name="word">
</dl>
<dl id="timeID2" class="cf">
    <dt class="title">月日</dt>
    <input id="firstday" type="date" name="firstday">～<input id="finalday" type="date" name="finalday"><br>
    <dt class="title">時間</dt>
    <input id="firsttime" type="time" name="firsttime">～<input id="finaltime" type="time" name="finaltime">
</dl>
<button type="button" id="rog_display" class="originalhidden" onclick="return formCheck();">適用</button>
</div>

<div class="popup">
    <div class="content">
        <p>{{ $log->user_id }}{{ $log->user_agent }}</p>
        <button id="close">閉じる</button>
    </div>
</div>

<script type="text/javascript">
    $('.pop').on('click',function(){
        $('.popup').addClass('show').fadeIn();
    });

    $('#close').on('click',function(){
        $('.popup').fadeOut();
    });


    function entryChange(){
    if(document.getElementById('rog_list')){
    id = document.getElementById('rog_list').value;

    if(id == 'access_time'){
    document.getElementById('timeID').style.display = "none";
    document.getElementById('timeID2').style.display = "";
    }else if(id != 'access_time'){
    document.getElementById('timeID').style.display = "";
    document.getElementById('timeID2').style.display = "none";
    }
    }
    }
    window.onload = entryChange;


    function formCheck(){
    id = document.getElementById('rog_list').value;
    id2 = document.getElementById('word').value;
    id3 = document.getElementById('firstday').value;
    id4 = document.getElementById('finalday').value;
    id5 = document.getElementById('firsttime').value;
    id6 = document.getElementById('finaltime').value;
    if(id == ""){
        var flag = 0;
    }else if (id2 == "" && id3 == "" && id4 == "") {
        var flag = 0;
    }

    if( flag == '0' ){
    alert( '入力内容に不備があります。' );
    return false; // 送信中止
    }else{
    return true; // 送信実行
    }
    }

    $(function() {
        // 入力ダイアログを表示
        $("#logserch").click(function() {

        $('#rog_list').val("");
        $('#word').val("");
        $('#firstday').val("");
        $('#finalday').val("");
        $('#firsttime').val("");
        $('#finaltime').val("");

        $("#rog_get").dialog("open");
        return false;
        });

        // 入力ダイアログを定義
        $("#rog_get").dialog({
        autoOpen: false,
        modal: true,
        title:"絞り込み検索",
        height: 400,
        width: 400,
        buttons: {
        "キャンセル": function() {
            $(this).dialog("close");
        },
        "適用": function() {
            $('#rog_display').click();
            $(this).dialog("close");
        },
        }
        });
    });
</script>
</x-app-layout>
