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
        </form>
        </div>
        <div class="sort">
        </div>
        <div class="page">
            <form action="{{ url('/logsort') }}" method="get">
            @csrf
            <p>表示件数：<input type="number" name="dispnum3" id="dispnum" value="10" min="1" pattern="^[1-9]+$">
                        <input type="submit" name="submit" value="変更">
            </p>
            </form>
        </div>
    </div>
    </x-slot>

<form action="{{ url('/logsort') }}" method="get">
@csrf
<table class="log">
    <thead>
    <tr><th>アクセスタイム<br>
        <input type="submit" name="sortaccess_time" value="▲">
        <input type="submit" name="sortaccess_time" value="▼">
        </th>
        <th>ログインＩＤ<br>
        <input type="submit" name="sortid" value="▲">
        <input type="submit" name="sortid" value="▼">
        </th>
        <th>IPアドレス<br>
        <input type="submit" name="sortip" value="▲">
        <input type="submit" name="sortip" value="▼">
        </th>
        <th>ユーザーエージェント<br>
        <input type="submit" name="sortagent" value="▲">
        <input type="submit" name="sortagent" value="▼">
        </th>
        <th>セッションID<br>
        <input type="submit" name="sortsession" value="▲">
        <input type="submit" name="sortsession" value="▼">
        </th>
        <th>アクセスURL<br>
        <input type="submit" name="sorturl" value="▲">
        <input type="submit" name="sorturl" value="▼">
        </th>
        <th>実行操作<br>
        <input type="submit" name="sortoperation" value="▲">
        <input type="submit" name="sortoperation" value="▼">
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
        <td>{{ Str::limit($log->user_agent, 50, '...') }}
            <button type="button" value="{{ $log->user_agent }}" onclick="fullfunc(this.value)">全表示</button></td>
        <td>{{ $log->session_id }}</td>
        <td>{{ $log->access_url }}</td>
        <td>{{ $log->operation }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
<br>

<ul class="pagination" id="pager">
    <li class="getPageClass">
    @for ($i = 0; $i <= $logger->lastPage(); $i++)
    @if ($i == 0)
    <a class="page-link current{{ $i }}" id="prev" style="display: none;" onclick="pagefunc3({{ $i }})">◁</a>
    @endif
    @if ($i >= 1)
    @if ($i == $logger->currentPage())
    <a class="page-link current{{ $i }} active" onclick="pagefunc3({{ $i }})">{{ $i }}</a>
    @else
    <a class="page-link current{{ $i }}" onclick="pagefunc3({{ $i }})">{{ $i }}</a>
    @endif
    @endif
    @endfor
    <a class="page-link" id="next" style="display: inline;" onclick="pagefunc3({{ $i }})">▷</a>
    </li>
</ul>


{{-- 絞り込み検索ダイアログ --}}
<div id="log_get">
    <p>各項目ごとにワードや条件で絞り込みができます。</p><br>
    <dl class="cf">
        <dt class="select">項目選択</dt>
        <dd class="data ">
        <select id="log_list" class="log_list" name="log_list" onchange="entryChange();">
            @foreach (Config::get('log_list.list') as $key => $val)
                <option id="listvalue" value="{{ $key }}">{{ $val }}</option>
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
    <button type="button" id="log_display" class="originalhidden">適用</button>
    <div id="logsearcherror2"></div>
</div>

{{-- 全表示ポップアップ --}}
<div class="popup">
    <div class="content">
        <p id="full"></p><br>
        <button type="button" style="text-align:center" id="close">閉じる</button>
    </div>
</div>

<script type="text/javascript">
    function fullfunc(agent) {
        $('#full').html(agent);
        $('.popup').addClass('show').fadeIn();
    }

    $('#close').on('click',function(){
        $('.popup').fadeOut();
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
        $('#logsearcherror2').html("");
        $("#log_get").dialog("open");
        return false;
        });

        // 入力ダイアログを定義
        $("#log_get").dialog({
        autoOpen: false,
        modal: true,
        title:"絞り込み検索",
        width: 450,
        height: 500,
        buttons: {
        "適用": function() {
            $('#log_display').click();
        },
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    function pagefunc3(i) {
        $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: '/log2',
      type: 'get',
      datatype: 'json',
      data: {
        'i': i
      }
    }).done(function (results) {
        // console.log(results);
        var rows = "";

        if (results['searchlog'].length !== 0) {
              for (var i = 0; i < results['searchlog'].length; i++) {
                rows += `<tr><td>${ results['searchlog'][i].access_time }</td>`;
            rows += `<td>${ results['searchlog'][i].user_id }</td>`;
            rows += `<td>${ results['searchlog'][i].ip_address }</td>`;
            rows += `<td>${ results['searchlog'][i].user_agent.substr(0, 50) + '...'}`;
            rows += `<button type="button" value="${ results['searchlog'][i].user_agent }" onclick="fullfunc(this.value)">全表示</button></td>`;
            rows += `<td>"${ results['searchlog'][i].session_id }</td>`;
            rows += `<td>${ results['searchlog'][i].access_url }</td>`;
            rows += `<td>${ results['searchlog'][i].operation }</td></tr>`;
                $("#loglist").html(rows);
              }
        } else {
            $("#loglist").html('<p>データがありません</p>');
        }

        var num = document.getElementsByClassName("page-link");
        for (var i = 0; i < num.length; i++) {
            if (num[i].innerText != results['pagenum']) {
                $('.' + 'current' + i).removeClass('active');
            } else {
                $('.' + 'current' + i).addClass('active');
            }
        }

        if (results['pagenum'] != 1) {
            $('#prev').show();
        } else {
            $('#prev').hide();
        }

        var last = num.length - 2;
        if (last == results['pagenum']) {
            $('#next').hide();
        } else {
            $('#next').show();
        }

    }).fail(function () {
      alert("エラーが発生しました");
    });
  };
</script>
</x-app-layout>
