<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('マイページ') }}
        </h2>
    </x-slot>
    <diV class="greeting">
    <font size="5"><strong>
        @if(!is_null(Auth::user()->ename))
        {{ Auth::user()->ename }}さんようこそ
        @else
        {{ Auth::user()->id }}さんようこそ
        @endif
    </strong></font>
    </div>
    <div class="abc">
    <div class="nameclass">
        <font size="2">【変更時は下のボタンから変更してください】</font><br>
        <button type="button" id="editename">名前変更</button>
    </div>

    <div class="imgclass">
        <div class="imgArea">
        @if (!is_null(Auth::user()->img1))
        <img class="myimg" src="data:image/png;base64,{{ Auth::user()->img1 }}" width="50%">
        @else
        <img class="myimg" src="{{ \Storage::url('img/no_image.jpg') }}" width="50%">
        @endif
        <button type="button" class="imgdelete1" value="{{ Auth::user()->empno }}">画像削除</button>
        <form method="post" enctype="multipart/form-data" id="img1_form">
            <div id="drop-zone1" class="drop-zone1">
                <p size="2">画像をドラッグ＆ドロップ<br>もしくは</p>
                <label class="original">
                ファイルを選択
                <input type="hidden" id="dialog_empno" value="{{ Auth::user()->empno }}">
                <input type="file" name="simg1" id="simg1" style="display:none">
                </label>
            </div>
            <div id="preview1" class="preview1"></div>
            <button type="button" id="inimg1" style="margin-top: 5px; display:none;">変更</button>
            <div id="img1error"></div>
        </form>
        </div>
        <div class="imgArea">
        @if (!is_null(Auth::user()->img2))
        <img class="myimg" src="{{ \Storage::url('img/'.Auth::user()->img2) }}" width="50%">
        @else
        <img class="myimg" src="{{ \Storage::url('img/no_image.jpg') }}" width="50%">
        @endif
        <button type="button" class="imgdelete2" value="{{ Auth::user()->empno }}">画像削除</button>
        <form method="post" enctype="multipart/form-data" id="img2_form">
            <div id="drop-zone2" class="drop-zone2">
                <p>画像をドラッグ＆ドロップ<br>もしくは</p>
                <label class="original">
                ファイルを選択
                <input type="hidden" id="dialog_empno" value="{{ Auth::user()->empno }}">
                <input type="file" name="simg2" id="simg2" style="display:none">
                </label>
            </div>
            <div id="preview2" class="preview2"></div>
            <button type="button" id="inimg2" style="margin-top: 5px; display:none;">変更</button>
            <div id="img2error"></div>
        </form>
        </div>
    </div>

    <div class="emailclass">
        @if(!is_null(Auth::user()->email))
        <b>メールアドレス：<br>{{ Auth::user()->email }}</b><br>
        @else
        <p>未登録</p><br>
        @endif
        <button type="button" id="editemail">変更</button>
    </div>

    <div class="addressclass">
    <b>住所：<br>〒{{ Auth::user()->post_code }}<br>{{ Auth::user()->address1 }}{{ Auth::user()->address2 }}</b>
    <br><br>
    <font size="2">【変更時は下記入力後、変更ボタンを押してください】</font>
    <p>*郵便番号で検索：<input type="text" id="zip" size="7"><font size="2">※ハイフンなし</font></p>
    <div class="err_zip" id="err_zip"></div>
    <p><button type="button" id="address">住所を自動入力</button></p>
    <p>住所1：<select id="getaddress"></select>
    <p>住所2：<input type="text" id="address2" size="20"></p>
    </div>
    <div id="addressbutton">
    <button type="button" id="editaddress">変更</button>
    </div>

    <div class="telclass">
    <b>電話番号：{{ Auth::user()->phone_number }}</b>
    <br><br>
    <font size="2">【変更時は下記入力後、変更ボタンを押してください】</font>
    <p>*電話番号：<input type="text" id="tel" size="11"><font size="2">※ハイフンなし</font></p>
    <div class="err_tel" id="err_tel"></div>
    <button type="button" id="editphone">変更</button>
    </div>
    </div>


    <div id="enamechange">
        <form method="POST">
        @csrf
        <input type="text" id="enameset" name="enameset">
        <br>
        <button type="button" id="ename" class="originalhidden">更新</button>
        <br>
        <div id="enameerror"></div>
        </form>
    </div>

    <div id="emailchange">
        <form method="POST">
        @csrf
        <input type="text" class="resize3" id="emailset" name="emailset">
        <br>
        <button type="button" id="email2" class="originalhidden">更新</button>
        <br>
        <div id="emailerror"></div>
        </form>
    </div>

<script type="text/javascript">
    $(function() {
        $("#editemail").click(function() {

        $('#emailset').val("");
        $('#emailerror').html("");

        $("#emailchange").dialog("open");
        return false;
        });

        $("#emailchange").dialog({
        autoOpen: false,
        modal: true,
        title:"メールアドレス変更",
        width: 400,
        buttons: {
        "更新": function() {
            $('#email2').click();
        },
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    $(function() {
        $("#editename").click(function() {

        $('#enameset').val("");
        $('#error').html("");

        $("#enamechange").dialog("open");
        return false;
        });

        $("#enamechange").dialog({
        autoOpen: false,
        modal: true,
        title:"名前変更",
        buttons: {
        "更新": function() {
            $('#ename').click();
        },
        "キャンセル": function() {
            $(this).dialog("close");
        },
        }
        });
    });

    $(function(){
        $("#zip").bind("blur", function() {
            var _ziptextbox = $(this).val();
            zipcheck_textbox(_ziptextbox);
            $("#getaddress").val("");
        });
    });

    function zipcheck_textbox(str){
        $("#err_zip p").remove();
        var _result = true;
        var _ziptextbox = $.trim(str);

        if(_ziptextbox.match(/^[ 　\r\n\t]*$/)){ //空白やタブや改行
            $("#err_zip").append("<p><i class=\"fa fa-exclamation-triangle\"></i>郵便番号を入力してください。</p>");
            $("#zip").addClass('focus');
            $("#getaddress").val("");
            _result = false;
        }else if(_ziptextbox.match(/\D/)){ //全ての数字以外の文字
            $("#err_zip").append("<p><i class=\"fa fa-exclamation-triangle\"></i>郵便番号は数字になります。</p>");
            $("#zip").addClass('focus');
            $("#getaddress").val("");
            _result = false;
        }else if(_ziptextbox.length > 7){
            $("#err_zip").append("<p><i class=\"fa fa-exclamation-triangle\"></i>郵便番号は最大7文字です。</p>");
            $("#zip").addClass('focus');
            _result = false;
        } else {
            $("#zip").removeClass('focus');
        }
        return _result;
    }

    $(function(){
        $("#tel").bind("blur", function() {
            var _teltextbox = $(this).val();
            telcheck_textbox(_teltextbox);
        });
    });

    function telcheck_textbox(str){
        $("#err_tel p").remove();
        var _result = true;
        var _teltextbox = $.trim(str);

        if(_teltextbox.match(/^[ 　\r\n\t]*$/)){ //空白やタブや改行
            $("#err_tel").append("<p><i class=\"fa fa-exclamation-triangle\"></i>電話番号を入力してください。</p>");
            $("#tel").addClass('focus');
            _result = false;
        }else if(_teltextbox.match(/\D/)){ //全ての数字以外の文字
            $("#err_tel").append("<p><i class=\"fa fa-exclamation-triangle\"></i>電話番号は数字になります。</p>");
            $("#tel").addClass('focus');
            _result = false;
        }else if(_teltextbox.length < 10 || _teltextbox.length > 11){
            $("#err_tel").append("<p><i class=\"fa fa-exclamation-triangle\"></i>電話番号は10桁か11桁です。</p>");
            $("#tel").addClass('focus');
            _result = false;
        } else {
            $("#tel").removeClass('focus');
        }
        return _result;
    }

    var dropZone1 = document.getElementById('drop-zone1');
    var preview1 = document.getElementById('preview1');
    var fileInput1 = document.getElementById('simg1');

    dropZone1.addEventListener('dragover', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffff00';
    }, false);

    dropZone1.addEventListener('dragleave', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffe0';
    }, false);

    fileInput1.addEventListener('change', function () {
        previewFile1(this.files[0]);
    });

    dropZone1.addEventListener('drop', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffe0'; //背景色を白に戻す
        var files = e.dataTransfer.files; //ドロップしたファイルを取得
        if (files.length > 1) return alert('アップロードできるファイルは1つだけです。');
        fileInput1.files = files; //inputのvalueをドラッグしたファイルに置き換える。

        var simg1 = document.getElementById('simg1').value;
        // ファイル名の末尾のカンマの位置を取得
        var position1 = simg1.lastIndexOf('.');
        // // indexから一つ目の配列要素を切り取り拡張子を取得
        var extension1 = simg1.slice(position1 + 1);
        // チェックの処理に拡張子を渡す
        check_extension(extension1);

        function check_extension(extensionName1) {
        // 許可する拡張子を指定
        var extensionArray1 = ['jpg', 'png', 'gif'];
        // 拡張子文字列を小文字に変換
        var extension1 = extensionName1.toLowerCase();
        // 許可配列から一致する値を検索
        if(extensionArray1.indexOf(extension1) !== -1) {
            $('#img1error').html("");
            document.getElementById('inimg1').style.display = 'inline';
            previewFile1(files[0]);
        } else {
            $('#preview1').html("");
            $('#img1error').html("");
            document.getElementById('inimg1').style.display = 'none';
            $("#img1error").append('ファイルが画像ではありません。<br>対応拡張子(.jpg　.gif　.png)');
        }
        }
    }, false);

    function previewFile1(file) {
        //FileReaderで読み込み、プレビュー画像を表示
        var fr = new FileReader();

        //ファイル読み込み完了時のイベントリスナ
        fr.addEventListener("load", function(e) {
                var img = new Image();

            //画像としての読み込みを待機
            img.addEventListener("load", function() {
                if (img.width > 300 || img.height > 300) {
                    $('#preview1').html("");
                    $('#img1error').html("");
                    document.getElementById('inimg1').style.display = 'none';
                    $("#img1error").append('画像サイズは300x300までです。');
                } else {
                    $('#img1error').html("");
                    document.getElementById('inimg1').style.display = 'inline';
                }
            });

            //DataURLをsrcにセットする
            img.src = e.target.result;

        }, false);

        fr.readAsDataURL(file);

        fr.onload = function() {
            var img = document.createElement('img');
            img.setAttribute('src', fr.result);
            preview1.innerHTML = '';
            preview1.appendChild(img);
        };
    }

    var dropZone2 = document.getElementById('drop-zone2');
    var preview2 = document.getElementById('preview2');
    var fileInput2 = document.getElementById('simg2');

    dropZone2.addEventListener('dragover', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffff00';
    }, false);

    dropZone2.addEventListener('dragleave', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffe0';
    }, false);

    fileInput2.addEventListener('change', function () {
        previewFile2(this.files[0]);
    });

    dropZone2.addEventListener('drop', function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.style.background = '#ffffe0'; //背景色を白に戻す
        var files = e.dataTransfer.files; //ドロップしたファイルを取得
        if (files.length > 1) return alert('アップロードできるファイルは1つだけです。');
        fileInput2.files = files; //inputのvalueをドラッグしたファイルに置き換える。

        var simg2 = document.getElementById('simg2').value;
        // ファイル名の末尾のカンマの位置を取得
        var position2 = simg2.lastIndexOf('.');
        // // indexから一つ目の配列要素を切り取り拡張子を取得
        var extension2 = simg2.slice(position2 + 1);
        // チェックの処理に拡張子を渡す
        check_extension(extension2);

        function check_extension(extensionName2) {
        // 許可する拡張子を指定
        var extensionArray2 = ['jpg', 'png', 'gif'];
        // 拡張子文字列を小文字に変換
        var extension2 = extensionName2.toLowerCase();
        // 許可配列から一致する値を検索
        if(extensionArray2.indexOf(extension2) !== -1) {
            $('#img2error').html("");
            document.getElementById('inimg2').style.display = 'inline';
            previewFile2(files[0]);
        } else {
            $('#preview2').html("");
            $('#img2error').html("");
            document.getElementById('inimg2').style.display = 'none';
            $("#img2error").append('ファイルが画像ではありません。<br>対応拡張子(.jpg　.gif　.png)');
        }
        }
    }, false);

    function previewFile2(file) {
        //FileReaderで読み込み、プレビュー画像を表示
        var fr = new FileReader();

        //ファイル読み込み完了時のイベントリスナ
        fr.addEventListener("load", function(e) {
                var img = new Image();

            //画像としての読み込みを待機
            img.addEventListener("load", function() {
                if (img.width > 300 || img.height > 300) {
                    $('#preview2').html("");
                    $('#img2error').html("");
                    document.getElementById('inimg2').style.display = 'none';
                    $("#img2error").append('画像サイズは300x300までです。');
                } else {
                    $('#img2error').html("");
                    document.getElementById('inimg2').style.display = 'inline';
                }
            });

            //DataURLをsrcにセットする
            img.src = e.target.result;

        }, false);

        fr.readAsDataURL(file);

        fr.onload = function() {
            var img = document.createElement('img');
            img.setAttribute('src', fr.result);
            preview2.innerHTML = '';
            preview2.appendChild(img);
        };
    }

</script>
</x-app-layout>
