<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('設定') }}
        </h2>
    </x-slot>

<diV class="greeting">
    <font size="5">ログ削除スケジュール</font>
</div>
<br>
<table>
<th colspan="3">実行間隔</th>
<tr>
<td width="150">
    <P>現在の設定</p><br>
    @if ($num != 0)
    <p>1日：<strong>{{ $num }}回</strong></p><br>
    @endif
    @if ($interval != "")
    <p>実行時間：</p><br><p><strong>{{ $interval }}時</strong></p><br>
    @endif
    @if ($interval1 != "")
    <p>実行時間：</p><br><strong>{{ $interval1 }}時</strong></p><p>＆</p><p><strong>{{ $interval2 }}時</strong></p><br>
    @endif
    {{-- @if ($intervalday != "")
    <p>実行期間：</p><br>{{ $intervalday }}日ごと</p><br>
    @endif --}}
    @if ($intervalhour != "")
    <p>実行期間：</p><br><strong>{{ $intervalhour }}分ごと</strong></p><br>
    @endif
    {{-- @if ($conditions != "")
    <p>{{ $conditions }}</p>
    @endif --}}
</td>
<td width="300" valign="top">
    <P>１日の回数と時間で選択</p><br>
    <div>
    <dl>
    <dt class="numtime">回数(1回or2回)</dt>
    <dd>
    <select id="number1or2" onchange="entryChange2();">
        @foreach (Config::get('number.list') as $key => $val)
            <option value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>
    </dd>
    </dl><br>
    <dl id="timeID3">
        <dt class="hour">時間</dt>
        <select id="firsttime1">
            @foreach (Config::get('hours.list') as $key => $val)
                <option value="{{ $key }}">{{ $val }}</option>
            @endforeach
        </select>
    </dl>
    <dl id="timeID4">
        <dt class="hour">時間</dt>
        <select id="firsttime2">
            @foreach (Config::get('hours.list') as $key => $val)
                <option value="{{ $key }}">{{ $val }}</option>
            @endforeach
        </select>　＆　
        <select id="finaltime2">
            @foreach (Config::get('hours.list') as $key => $val)
                <option value="{{ $key }}">{{ $val }}</option>
            @endforeach
        </select>
    </dl><br>
    <input type="button" id="setting1" value="設定">
    </div>
</td>

<td width="300" valign="top">
    <P>期間で選択</p><br>
    <div>
    {{-- <dl>
    <dt class="title">期間</dt>
    <dd>
    <select id="selectinterval" onchange="entryChange2();">
        @foreach (Config::get('selectinterval.list') as $key => $val)
            <option value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>
    </dd>
    </dl><br>
    <dl id="timeID5">
        <dt class="title">日数</dt>
        <select id="intervalday">
            @foreach (Config::get('days.list') as $key => $val)
                <option value="{{ $key }}">{{ $val }}</option>
            @endforeach
        </select>日ごと
    </dl> --}}
    <dl id="timeID6">
        <dt class="period">期間</dt>
        <select id="intervalhour">
            @foreach (Config::get('time.list') as $key => $val)
                <option value="{{ $key }}">{{ $val }}</option>
            @endforeach
        </select>ごと
        {{-- <input id="intervalhour" type="text" class="resize2" value="10">分ごと --}}
    </dl><br>
    <input type="button" id="setting2" value="設定">
    </div>
</td>
</tr>
</table>
<br><br>
<table>
<th colspan="2">保存日数</th>
<tr>
<td width="150">
    <P>現在の設定</p><br>
    <p>作成から<br><strong>{{ $conditions }}日</strong><br>過ぎたら削除</p>
</td>
<td width="300">
    <select id="conditions">
        @foreach (Config::get('days.list') as $key => $val)
            <option value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>日<br><br>
    <input type="button" id="setting3" value="設定"><br>
</td>
</tr>
</table>


<script type="text/javascript">

function entryChange2(){
    if (document.getElementById('number1or2')) {
    id = document.getElementById('number1or2').value;

    if (id == 2) {
    document.getElementById('timeID3').style.display = "none";
    document.getElementById('timeID4').style.display = "";
    } else {
    document.getElementById('timeID3').style.display = "";
    document.getElementById('timeID4').style.display = "none";
    }
    }

    // if (document.getElementById('selectinterval')) {
    // id = document.getElementById('selectinterval').value;

    // if (id == '時間') {
    // document.getElementById('timeID5').style.display = "none";
    // document.getElementById('timeID6').style.display = "";
    // } else {
    // document.getElementById('timeID5').style.display = "";
    // document.getElementById('timeID6').style.display = "none";
    // }
    // }
}
window.onload = entryChange2;
</script>


</x-app-layout>
