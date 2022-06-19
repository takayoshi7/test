<x-app-layout>
    <x-slot name="header">
    <div class="wrap">
        <div class="title">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ログ一覧') }}
        </h2>
        </div>
        <div class="insert">
        </div>
        <div class="category">
        <form action="{{ url('/logcsvd') }}" method="post">
        @csrf
            <input type="submit" id="logserch"  value="絞り込み">
            <input type="submit" value="CSVエクスポート">
            <input type="hidden" name="log_list">
            <input type="hidden" name="word">
            <input type="hidden" name="day1">
            <input type="hidden" name="day2">
        </form>
        </div>
        <div class="sort">
        </div>
        <div class="page">
            <form action="{{ url('/log') }}" method="get">
            @csrf
            <p>表示件数：<input type="number" name="dispnum" id="dispnum" value={{ $dispnum }} min="1" pattern="^[1-9]+$">
                        <input type="hidden" name="sorton" value={{ $sort }}>
                        <input type="hidden" name="category" value={{ $category }}>
                        <input type="submit" name="submit" value="変更">
            </p>
            </form>
        </div>
    </div>
    </x-slot>

<form action="{{ url('/log') }}" method="get">
@csrf
<table class="log">
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
        <button type="button" class="pop">全表示切替</button>
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
</form>
    <tbody id="loglist">
    @foreach ($logger as $log)
    <tr>
        <td>{{ $log->access_time }}</td>
        <td>{{ $log->user_id }}</td>
        <td>{{ $log->ip_address }}</td>
        <td class="part">{{ Str::limit($log->user_agent, 50, '...') }}</td>
        <td class="full" style="display:none" nowrap>{{ $log->user_agent }}</td>
        <td>{{ $log->session_id }}</td>
        <td>{{ $log->access_url }}</td>
        <td>{{ $log->operation }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
<div class="pager">
<ul class="pagination" id="pagination">{{ $logger->appends(request()->query())->links('pagination::bootstrap-4') }}</ul>
</div>


{{-- 絞り込み検索ダイアログ --}}
<div id="log_get">
    <p>各項目ごとにワードや条件で絞り込みができます。</p><br>
    <dl class="cf">
        <dt class="select">項目選択</dt>
        <dd class="data ">
        <select id="log_list" class="log_list" name="log_list" onchange="entryChange();">
            @foreach (Config::get('log_list.list') as $key => $val)
                <option value="{{ $key }}">{{ $val }}</option>
            @endforeach
        </select>
        </dd>
    </dl>
    <div id="logsearcherror"></div>
    <br>
    <dl id="timeID" class="cf">
        <dt class="select">検索ワード</dt>
        <input id="word" type="text" name="word">
    </dl>
    <dl id="timeID2" class="cf">
        <dt class="select">月日(必須入力)</dt>
        <input id="firstday" type="date" name="firstday">～<input id="finalday" type="date" name="finalday"><br>
        <dt class="select">時間(任意入力)</dt>
        <input id="firsttime" type="time" name="firsttime">～<input id="finaltime" type="time" name="finaltime">
    </dl>
    <button type="button" id="log_display" class="originalhidden" onclick="return formCheck();">適用</button>
    <div id="logsearcherror2"></div>
</div>

{{-- 全表示ポップアップ
<div class="popup">
    <div class="content">
        <p>{{ $log->user_id }}{{ $log->user_agent }}</p>
        <button id="close">閉じる</button>
    </div>
</div> --}}

<script type="text/javascript">
    // $('.pop').on('click',function(){
    //     $('.popup').addClass('show').fadeIn();
    // });

    // $('#close').on('click',function(){
    //     $('.popup').fadeOut();
    // });


    $('.pop').on('click',function(){
        $('.full').toggle();
        $('.part').toggle();
    });


    function entryChange(){
    if(document.getElementById('log_list')){
    id = document.getElementById('log_list').value;

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
    id = document.getElementById('log_list').value;
    id2 = document.getElementById('word').value;
    id3 = document.getElementById('firstday').value;
    id4 = document.getElementById('finalday').value;

    if(id === ""){
        $("#logsearcherror").html('入力内容に不備があります。');
        return false; // 送信中止
    } else if (id !== "アクセスタイム") {
        if (id2 === "") {
            $("#logsearcherror").html('');
            $("#logsearcherror2").html('入力内容に不備があります。');
            $("#word").addClass('focus');
            return false; // 送信中止
        } else {
            $("#word").removeClass('focus');
            $("#logsearcherror2").html('');
            return true; // 送信実行
        }
    } else if (id === "アクセスタイム") {
        if  (id3 === "" && id4 === "") {
            $("#logsearcherror").html('');
            $("#logsearcherror2").html('入力内容に不備があります。');
        } else if (id3 === "") {
            $("#logsearcherror").html('');
            $("#logsearcherror2").html('入力内容に不備があります。');
            // $("#firstday").addClass('focus');
            return false; // 送信中止
        } else if (id4 === "") {
            $("#logsearcherror").html('');
            $("#logsearcherror2").html('入力内容に不備があります。');
            // $("#finalday").addClass('focus');
            // $("#firstday").removeClass('focus');
            return false; // 送信中止
        } else {
            // $("#finalday").removeClass('focus');
            $("#logsearcherror2").html('');
            return true; // 送信実行
        }
    }
    }



    // }else if (id2 == "" && id3 == "" && id4 == "") {
    //     $("#logsearcherror").html('');
    //     $("#logsearcherror2").html('入力内容に不備があります。');
    //     $("#word").addClass('focus');
    //     $("#firstday").addClass('focus');
    //     $("#finalday").addClass('focus');
    //     return false; // 送信中止
    // }else{
    //     return true; // 送信実行
    // }
    // }


    // function logsearchformcheck(str){
    //     $("#logsearcherror p").remove();
    //     var _result = true;
    //     var _logsearchtextbox = $.trim(str);

    //     if(_logsearchtextbox.match(/^[ 　\r\n\t]*$/)){ //空白やタブや改行
    //         $("#logsearcherror").append("<p><i class=\"fa fa-exclamation-triangle\"></i>入力内容に不備があります。</p>");
    //         $("#word").addClass('focus');
    //         _result = false;
    //     } else {
    //         $("#word").removeClass('focus');
    //     }
    //     return _result;
    // }







    $(function() {
        // 入力ダイアログを表示
        $("#logserch").click(function() {

        $('#log_list').val("");
        $('#word').val("");
        $('#firstday').val("");
        $('#finalday').val("");
        $('#firsttime').val("");
        $('#finaltime').val("");
        $('#logsearcherror').html("");

        $("#log_get").dialog("open");
        return false;
        });

        // 入力ダイアログを定義
        $("#log_get").dialog({
        autoOpen: false,
        modal: true,
        title:"絞り込み検索",
        height: 450,
        width: 450,
        buttons: {
        "キャンセル": function() {
            $(this).dialog("close");
        },
        "適用": function() {
            $('#log_display').click();
            // $(this).dialog("close");
        },
        }
        });
    });
</script>
</x-app-layout>
