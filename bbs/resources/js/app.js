import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$(function () {
    $("#insert1btn").on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var insid = $('#insid').val();
      var insempno = $('#insempno').val();
      var insename = $('#insename').val();
      var insjob = $('#insjob').val();
      var insmgr = $('#insmgr').val();
      var inshiredate = $('#inshiredate').val();
      var inssal = $('#inssal').val();
      var inscomm = $('#inscomm').val();
      var str = $('#insdeptno').val();
      var arr = str.split(':');
      var insdeptno = arr[0];
      $.ajax({
        url: '/insert1',
        type: 'POST',
        datatype: 'json',
        data: {
          'insid': insid,
          'insempno': insempno,
          'insename': insename,
          'insjob': insjob,
          'insmgr': insmgr,
          'inshiredate': inshiredate,
          'inssal': inssal,
          'inscomm': inscomm,
          'insdeptno': insdeptno
        }
      }).done(function (data) {
        if (!data.alert_message) {
          alert("追加しました");
          $("#insertlist1").dialog("close");
          window.location.reload();
        } else {
          alert(data.alert_message);
        }
      }).fail(function (error) {
        console.log(error.statusText);
      });
    });

    $("#edit1btn").on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var ed1 = $('#ee1').val();
      var ed2 = $('#ee2').val();
      var ed3 = $('#ee3').val();
      var ed4 = $('#ee4').val();
      var ed5 = $('#ee5').val();
      var ed6 = $('#ee6').val();
      var ed7 = $('#ee7').val();
      var ed8 = $('#ee8').val();
      var str = $('#ee9').val();
      var arr = str.split(':');
      var ed9 = arr[0];
      var edid = $('#e1').val();
      $.ajax({
        url: '/edit1',
        type: 'POST',
        datatype: 'json',
        data: {
          'ed1': ed1,
          'ed2': ed2,
          'ed3': ed3,
          'ed4': ed4,
          'ed5': ed5,
          'ed6': ed6,
          'ed7': ed7,
          'ed8': ed8,
          'ed9': ed9,
          'edid': edid
        }
      }).done(function (data) {
        if (!data.alert_message) {
          alert("更新しました");
          $("#editlist1").dialog("close");
          window.location.reload();
        } else {
          alert(data.alert_message);
        }
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $('#delete1btn').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var empno = $('#delete_empno').val();

      $.ajax({
      url: '/delete1',
      type: 'POST',
      datatype: 'json',
      data: {
          'empno': empno
      }
      }).done(function (data) {
      if (!data.alert_message) {
          alert("削除しました");
          window.location.reload();
      } else {
          alert(data.alert_message);
      }
      }).fail(function () {
      alert("エラーが発生しました");
      });
    });

    $("#search1btn").on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var ename = $('#esearch').val();

      if ($('#minnum').val()) {
        var minnum = $('#minnum').val();
      } else {
        var minnum = 0;
      }

      if ($('#maxnum').val()) {
        var maxnum = $('#maxnum').val();
      } else {
        var maxnum = 99999;
      }

      $.ajax({
        url: '/list1/' + ename + minnum + maxnum,
        type: 'get',
        datatype: 'json',
        data: {
          "ename": ename,
          "minnum": minnum,
          "maxnum": maxnum
        }
      }).done(function (results) {
        alert("検索しました");
  //       console.log(results['searchdata']);
        var rows = "";

        for (var i = 0; i < results['searchdata']['data'].length; i++) {
          rows += "<tr><td>".concat(results['searchdata']['data'][i].id, "</td>");
          rows += "<td>".concat(results['searchdata']['data'][i].empno, "</td>");
          rows += "<td>".concat(results['searchdata']['data'][i].ename, "</td>");
          rows += "<td>".concat(results['searchdata']['data'][i].job, "</td>");
          rows += "<td>".concat(results['searchdata']['data'][i].mgr, "</td>");
          rows += "<td>".concat(results['searchdata']['data'][i].hiredate, "</td>");
          rows += "<td>".concat(results['searchdata']['data'][i].sal, "</td>");
          rows += "<td>".concat(results['searchdata']['data'][i].comm, "</td>");
          rows += "<td>".concat(results['searchdata']['data'][i].deptno, "</td>");

          if (results['searchdata']['data'][i].img1) {
            rows += "<td><img class=\"listmyimg\" src=\"data:image/png;base64,".concat(results['searchdata']['data'][i].img1, "\" width=\"30px\">");
          } else {
            rows += "<td><img class=\"listmyimg\" src=\"/storage/img/no_image.jpg\" width=\"30px\">";
          }

          if (results['array'].includes(2)) {
            rows += "<button type=\"button\" class=\"img1\" onclick=\"img1func(".concat(results['searchdata']['data'][i].empno, ")\">\u5909\u66F4</button></td>");
          } else {
            rows += "</td>";
          }

          if (results['searchdata']['data'][i].img2) {
            rows += "<td><img class=\"listmyimg\" src=\"/storage/img/".concat(results['searchdata']['data'][i].img2, "\" width=\"30px\">");
          } else {
            rows += "<td><img class=\"listmyimg\" src=\"/storage/img/no_image.jpg\" width=\"30px\">";
          }

          if (results['array'].includes(2)) {
            rows += "<button type=\"button\" class=\"img2\" onclick=\"img2func(".concat(results['searchdata']['data'][i].empno, ")\">\u5909\u66F4</button></td>");
          } else {
            rows += "</td>";
          }

          if (results['array'].includes(2)) {
            rows += "<td><button type=\"button\" class=\"edit1\" value=\"".concat(results['searchdata']['data'][i].id, ", ").concat(results['searchdata']['data'][i].empno, ", ").concat(results['searchdata']['data'][i].ename, ", ").concat(results['searchdata']['data'][i].job, ", ").concat(results['searchdata']['data'][i].mgr, ", ").concat(results['searchdata']['data'][i].hiredate, ", ").concat(results['searchdata']['data'][i].sal, ", ").concat(results['searchdata']['data'][i].comm, ", ").concat(results['searchdata']['data'][i].deptno, "\" onclick=\"edit1func(this.value)\">\u7DE8\u96C6</button></td>");
            rows += "<td><button type=\"button\" class=\"delete1\" value=\"".concat(results['searchdata']['data'][i].empno, ", ").concat(results['searchdata']['data'][i].ename, "\" onclick=\"delete1func(this.value)\">\u524A\u9664</button></td>");
          }

          rows += "<td>".concat(results['searchdata']['data'][i].name, "<br>");

          if (results['roles_name'] === '管理者') {
            rows += "<button type=\"button\"  class=\"role1\" onclick=\"roleselect(".concat(results['searchdata']['data'][i].empno, ")\">\u5909\u66F4</button></td></tr>");
          } else {
            rows += "</td></tr>";
          }
        }

        var page = "";
          page += `<li class="getPageClass">`;
          for (var i = 0; i <= results['searchdata']['last_page']; i++) {
              if (i == 0) {
                  page += `<a class="page-link current${ i }" id="prev" onclick="pagefunc(${ i })" style="display: none;">&lt;&lt;</a>`;
              }
              if (i >= 1) {
                  if (i == results['searchdata']['current_page']) {
                      page += `<a class="page-link current${ i } active" onclick="pagefunc(${ i })">${ i }</a>`;
                  } else {
                      page += `<a class="page-link current${ i }" onclick="pagefunc(${ i })">${ i }</a>`;
                  }
              }
          }
          if (results['searchdata']['current_page'] != results['searchdata']['last_page']) {
              page += `<a class="page-link current${ i }" id="next" onclick="pagefunc(${ i })" style="display: inline;">&gt;&gt;</a>`;
          }
          page += `</li>`;

        $("#list1").html(rows);
        $("#pager").html(page);
        $("#searchlist1").dialog("close");
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $("#insert2btn").on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var insdeptno = $('#insdeptno').val();
      var insdname = $('#insdname').val();
      var insloc = $('#insloc').val();
      var inssort = $('#inssort').val();
      $.ajax({
        url: '/insert2',
        type: 'POST',
        datatype: 'json',
        data: {
          'insdeptno': insdeptno,
          'insdname': insdname,
          'insloc': insloc,
          'inssort': inssort
        }
      }).done(function (data) {
        if (!data.alert_message) {
          alert("追加しました");
          $("#insertlist2").dialog("close");
          window.location.reload();
        } else {
          alert(data.alert_message);
        }
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $("#edit2btn").on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var ed1 = $('#dd1').val();
      var ed2 = $('#dd2').val();
      var ed3 = $('#dd3').val();
      var ed4 = $('#dd4').val();
      var edid = $('#d1').val();
      $.ajax({
        url: '/edit2',
        type: 'POST',
        datatype: 'json',
        data: {
          'ed1': ed1,
          'ed2': ed2,
          'ed3': ed3,
          'ed4': ed4,
          'edid': edid
        }
      }).done(function (data) {
        if (!data.alert_message) {
          alert("更新しました");
          $("#editlist2").dialog("close");
          window.location.reload();
        } else {
          alert(data.alert_message);
        }
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $('#delete2btn').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var deptid = $('#delete_deptno').val();

      $.ajax({
      url: '/delete2',
      type: 'POST',
      datatype: 'json',
      data: {
          'deptid': deptid
      }
      }).done(function (data) {
      if (!data.alert_message) {
          alert("削除しました");
          window.location.reload();
      } else {
          alert(data.alert_message);
      }
      }).fail(function () {
      alert("エラーが発生しました");
      });
    });

    $("#dsearchbtn").on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        } //Headersを書き忘れるとエラーになる

      });
      var dname = $('#dsearch').val();
      $.ajax({
        url: '/dnamesearch',
        type: 'get',
        datatype: 'json',
        data: {
          "dname": dname
        }
      }).done(function (results) {
        alert("検索しました");
        var rows = "";

        for (var i = 0; i < results['searchdata']['data'].length; i++) {
          rows += "<tr><td>".concat(results['searchdata']['data'][i].deptno, "</td>");
          rows += "<td>".concat(results['searchdata']['data'][i].dname, "</td>");
          rows += "<td>".concat(results['searchdata']['data'][i].loc, "</td>");
          rows += "<td>".concat(results['searchdata']['data'][i].sort, "</td>");

          if (results['array'].includes(4)) {
            rows += "<td><button type=\"button\" class=\"edit2\" value=\"".concat(results['searchdata']['data'][i].deptno, ", ").concat(results['searchdata']['data'][i].dname, ", ").concat(results['searchdata']['data'][i].loc, ", ").concat(results['searchdata']['data'][i].sort, "\" onclick=\"edit2func(this.value)\">\u7DE8\u96C6</button></td>");
            rows += "<td><button type=\"button\" class=\"delete2\" value=\"".concat(results['searchdata']['data'][i].deptno, ", ").concat(results['searchdata']['data'][i].dname, "\" onclick=\"delete2func(this.value)\">\u524A\u9664</button></td></tr>");
          } else {
            rows += "</tr>";
          }
        }

        var page = "";
          page += `<li class="getPageClass">`;
          for (var i = 0; i <= results['searchdata']['last_page']; i++) {
              if (i == 0) {
                  page += `<a class="page-link current${ i }" id="prev" onclick="pagefunc2(${ i })" style="display: none;">&lt;&lt;</a>`;
              }
              if (i >= 1) {
                  if (i == results['searchdata']['current_page']) {
                      page += `<a class="page-link current${ i } active" onclick="pagefunc2(${ i })">${ i }</a>`;
                  } else {
                      page += `<a class="page-link current${ i }" onclick="pagefunc2(${ i })">${ i }</a>`;
                  }
              }
          }
          if (results['searchdata']['current_page'] != results['searchdata']['last_page']) {
              page += `<a class="page-link current${ i }" id="next" onclick="pagefunc2(${ i })" style="display: inline;">&gt;&gt;</a>`;
          }
          page += `</li>`;

        $("#list2").html(rows); //上書き
        $("#listsortnum").val(results['listsortnum']);
        $("#pager").html(page);
        $("#searchlist2").dialog("close");
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $("#import1").on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        } //Headersを書き忘れるとエラーになる

      });
      var form = $('#my_form2').get()[0];
      var formdata = new FormData(form); // console.log(formdata);
      // POSTでアップロード
      // dataにFormDataを指定する場合 processData,contentTypeをfalseにしてjQueryがdataを処理しないようにする

      $.ajax({
        url: '/empcsvin',
        type: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json'
      }).done(function (results) {
        if (results === true) {
          alert("インポートしました"); //CSVデータに問題なければインポート成功
          $("#app2").dialog("close");
        } else {
          for (i = 0; i < Object.keys(results.valA).length; i++) {
            //CSVデータに問題があればエラー内容表示
            $("#error").append(results['valB'][i] + '行目の' + results['valA'][i] + 'は正しくありません<br>');
          }
        }
      }).fail(function () {
        //通信エラー
        document.getElementById('error').innerHTML = "エラーが発生しました"; // this.csvErrors = error.response.data.errors.csv_file;
      });
    });

    $("#import2").on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        } //Headersを書き忘れるとエラーになる

      });
      var form = $('#my_form').get()[0];
      var formdata = new FormData(form); // console.log(formdata);
      // POSTでアップロード
      // dataにFormDataを指定する場合 processData,contentTypeをfalseにしてjQueryがdataを処理しないようにする

      $.ajax({
        url: '/deptcsvin',
        type: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json'
      }).done(function (results) {
        if (results === true) {
          alert('インポートしました'); //CSVデータに問題なければインポート成功
          $("#app").dialog("close");
          window.location.reload();
        } else {
          for (i = 0; i < Object.keys(results.valA).length; i++) {
            //CSVデータに問題があればエラー内容表示
            $("#error").append(results['valB'][i] + '行目の' + results['valA'][i] + 'は正しくありません<br>');
          }
        }
      }).fail(function () {
        //通信エラー
        document.getElementById('error').innerHTML = "エラーが発生しました";
      });
    });

    $("#inimg1").on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        } //Headersを書き忘れるとエラーになる

      });
      var form = $('#img1_form').get()[0];
      var formdata = new FormData(form);
      formdata.append("empno", $('#dialog_empno').val());

      // POSTでアップロード
      // dataにFormDataを指定する場合 processData,contentTypeをfalseにしてjQueryがdataを処理しないようにする
      $.ajax({
        url: '/tuikaimg1',
        type: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json'
      }).done(function (data) {
        if (data === true) {
          alert("更新しました"); //成功
          $("#select_img1").dialog("close");
          window.location.reload();
        } else {
          $("#img1error").html(data);
        }
      }).fail(function () {
        //通信エラー
        document.getElementById('error').innerHTML = "エラーが発生しました";
      });
    });

    $("#inimg2").on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        } //Headersを書き忘れるとエラーになる

      });
      var form = $('#img2_form').get()[0];
      var formdata = new FormData(form);
      formdata.append("empno", $('#dialog_empno').val());
      ;
      // POSTでアップロード
      // dataにFormDataを指定する場合 processData,contentTypeをfalseにしてjQueryがdataを処理しないようにする
      $.ajax({
        url: '/tuikaimg2',
        type: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json'
      }).done(function (data) {
        if (data === true) {
          alert("更新しました"); //成功
          $("#select_img2").dialog("close");
          window.location.reload();
        } else {
          $("#img2error").html(data);
        }
      }).fail(function () {
        //通信エラー
        document.getElementById('error').innerHTML = "エラーが発生しました";
      });
    });

    $('.imgdelete1').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var empno = $(this).attr('value'); // console.log(deptid);

      var deleteConfirm = confirm('画像を削除してよろしいでしょうか？');

      if (deleteConfirm == true) {
        $.ajax({
          url: '/imgdelete1',
          type: 'POST',
          datatype: 'json',
          data: {
            'empno': empno
          }
        }).done(function (data) {
          alert("削除しました");
          window.location.reload();
        }).fail(function () {
          alert("エラーが発生しました");
        });
      } else {
        return false;
      }
    });

    $('.imgdelete2').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var empno = $(this).attr('value'); // console.log(deptid);

      var deleteConfirm = confirm('画像を削除してよろしいでしょうか？');

      if (deleteConfirm == true) {
        $.ajax({
          url: '/imgdelete2',
          type: 'POST',
          datatype: 'json',
          data: {
            'empno': empno
          }
        }).done(function (data) {
          alert("削除しました");
          window.location.reload();
        }).fail(function () {
          alert("エラーが発生しました");
        });
      } else {
        return false;
      }
    });

    $('#role_change').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var empno = $('#dialog_empno').val();
      var val = document.getElementsByClassName("tag-id")[0].value;
      $.ajax({
        url: '/role_change',
        type: 'POST',
        datatype: 'json',
        data: {
          'empno': empno,
          'val': val
        }
      }).done(function (data) {
        if (!data.alert_message) {
          alert("変更しました");
          $("#role_edit").dialog("close");
          window.location.reload();
        } else {
          alert(data.alert_message);
        }
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $('#log_display').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var log_list = document.getElementsByClassName("log_list")[0].value;
      var word = $('#word').val();
      var firstday = $('#firstday').val();
      var finalday = $('#finalday').val();
      var firsttime = $('#firsttime').val();
      var finaltime = $('#finaltime').val();

      if(log_list === ""){
          var flag = 0;
      } else if (log_list !== "access_time") {
          if (word === "") {
              $("#word").addClass('focus');
              var flag = 1;
          } else {
              $("#word").removeClass('focus');
              $("#logsearcherror2").html('');
              var flag = 2;
          }
      } else if (log_list === "access_time") {
          if  (firstday === "" && finalday === "") {
              var flag = 1;
          } else if (firstday === "") {
              var flag = 1;
          } else if (finalday === "") {
              var flag = 1;
          } else {
              $("#logsearcherror2").html('');
              var flag = 2;
          }
      }

      if (flag == 0) {
          $("#logsearcherror").html('入力内容に不備があります。');
      } else if (flag == 1) {
          $("#logsearcherror").html('');
          $("#logsearcherror2").html('入力内容に不備があります。');
      } else if (flag == 2) {
          if (firsttime == '') {
              var firsttime = '00:00';
          }

          if (finaltime == '') {
              var finaltime = '23:59';
          }

          var day1 = firstday + ' ' + firsttime + ':00';
          var day2 = finalday + ' ' + finaltime + ':00';
          $.ajax({
          url: '/logserch',
          type: 'get',
          datatype: 'json',
          data: {
              'log_list': log_list,
              'word': word,
              'day1': day1,
              'day2': day2
          }
          }).done(function (results) {
          // console.log(results);
          var rows = "";

          if (results['searchlog']['data'].length !== 0) {
              for (var i = 0; i < results['searchlog']['data'].length; i++) {
              rows += `<tr><td>${ results['searchlog']['data'][i].access_time }</td>`;
              rows += `<td>${ results['searchlog']['data'][i].user_id }</td>`;
              rows += `<td>${ results['searchlog']['data'][i].ip_address }</td>`;
              rows += `<td>${ results['searchlog']['data'][i].user_agent.substr(0, 50) + '...'}`;
              rows += `<button type="button" value="${ results['searchlog']['data'][i].user_agent }" onclick="fullfunc(this.value)">全表示</button></td>`;
              rows += `<td>"${ results['searchlog']['data'][i].session_id }</td>`;
              rows += `<td>${ results['searchlog']['data'][i].access_url }</td>`;
              rows += `<td>${ results['searchlog']['data'][i].operation }</td></tr>`;
              $("#loglist").html(rows);
              }
          } else {
              $("#loglist").html('<p>データがありません</p>');
          }

          var page = "";
          page += `<li class="getPageClass">`;
          for (var i = 0; i <= results['searchlog']['last_page']; i++) {
              if (i == 0) {
                  page += `<a class="page-link current${ i }" id="prev" onclick="pagefunc3(${ i })" style="display: none;">&lt;&lt;</a>`;
              }
              if (i >= 1) {
                  if (i == results['searchlog']['current_page']) {
                      page += `<a class="page-link current${ i } active" onclick="pagefunc3(${ i })">${ i }</a>`;
                  } else {
                      page += `<a class="page-link current${ i }" onclick="pagefunc3(${ i })">${ i }</a>`;
                  }
              }
          }
          if (results['searchlog']['current_page'] != results['searchlog']['last_page']) {
              page += `<a class="page-link current${ i }" id="next" onclick="pagefunc3(${ i })" style="display: inline;">&gt;&gt;</a>`;
          }
          page += `</li>`;

          $("#pager").html(page);
          $("#log_get").dialog("close");
          }).fail(function () {
          alert("エラーが発生しました");
          });
      }
    });

    $('.detail').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var empno = $(this).attr('value');
      var deleteConfirm = confirm('画像を削除してよろしいでしょうか？');

      if (deleteConfirm == true) {
        $.ajax({
          url: '/imgdelete2',
          type: 'POST',
          datatype: 'json',
          data: {
            'empno': empno
          }
        }).done(function (data) {
          alert("削除しました");
          window.location.reload();
        }).fail(function () {
          alert("エラーが発生しました");
        });
      } else {
        return false;
      }
    });

    $('#setting1').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var number1or2 = $('#number1or2').val();
      var firsttime1 = $('#firsttime1').val();
      var firsttime2 = $('#firsttime2').val();
      var finaltime2 = $('#finaltime2').val();

      if (number1or2 == 1) {
        var time1 = firsttime1;
        var time2 = "";
        var time3 = "";
        var setting1Confirm = confirm('1日：' + number1or2 + '回、\n' + firsttime1 + '時に設定しますか？');

        if (setting1Confirm == true) {} else {
          return false;
        }

        ;
      } else {
        var time1 = "";
        var time2 = firsttime2;
        var time3 = finaltime2;
        var setting11Confirm = confirm('1日：' + number1or2 + '回、\n' + firsttime2 + '時と' + finaltime2 + '時に設定しますか？');

        if (setting11Confirm == true) {} else {
          return false;
        }

        ;
      }

      $.ajax({
        url: '/setting1',
        type: 'POST',
        datatype: 'json',
        data: {
          'number1or2': number1or2,
          'time1': time1,
          'time2': time2,
          'time3': time3
        }
      }).done(function (data) {
        if (!data.alert_message) {
          alert("設定しました");
          window.location.reload();
        } else {
          alert(data.alert_message);
        }
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $('#setting2').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var selectinterval = $('#selectinterval').val(); // var intervalday = $('#intervalday').val();

      var intervalhour = $('#intervalhour').val(); // console.log(selectinterval);
      // console.log(intervalday);
      // console.log(intervalhour);
      // if (selectinterval == "日数") {
      //     var day = intervalday;
      //     var hour = "";
      //     var setting2Confirm = confirm(intervalday + '日ごとに設定しますか？');
      //     if(setting2Confirm == true) {
      //     } else {
      //         return false;
      //     };
      // } else if (selectinterval == "時間") {

      var day = "";
      var hour = intervalhour;
      var setting22Confirm = confirm(intervalhour + '分ごとに設定しますか？');

      if (setting22Confirm == true) {} else {
        return false;
      }

      ; // }

      $.ajax({
        url: '/setting2',
        type: 'POST',
        datatype: 'json',
        data: {
          'selectinterval': selectinterval,
          'day': day,
          'hour': hour
        }
      }).done(function (data) {
        if (!data.alert_message) {
          alert("設定しました");
          window.location.reload();
        } else {
          alert(data.alert_message);
        }
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $('#setting3').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var conditions = $('#conditions').val(); // console.log(conditions);

      var setting3Confirm = confirm('保存日数を' + conditions + '日に設定しますか？');

      if (setting3Confirm == true) {} else {
        return false;
      }

      ;
      $.ajax({
        url: '/setting3',
        type: 'POST',
        datatype: 'json',
        data: {
          'conditions': conditions
        }
      }).done(function (data) {
        if (!data.alert_message) {
          alert("設定しました");
          window.location.reload();
        } else {
          alert(data.alert_message);
        }
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $('#ename').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var ename = $('#enameset').val();
      var enameConfirm = confirm('名前を' + ename + 'に変更しますか？');

      if (enameConfirm == true) {} else {
        return false;
      }

      ;
      $.ajax({
        url: '/enamechange',
        type: 'POST',
        datatype: 'json',
        data: {
          'ename': ename
        }
      }).done(function (data) {
        alert("更新しました");
        $("#enamechange").dialog("close");
        window.location.reload();
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $('#email2').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var email = $('#emailset').val();
      var emailConfirm = confirm('メールアドレスを\n' + email + 'に変更しますか？');

      if (emailConfirm == true) {} else {
        return false;
      }

      ;
      $.ajax({
        url: '/emailchange',
        type: 'POST',
        datatype: 'json',
        data: {
          'email': email
        }
      }).done(function (data) {
        if (!data.message) {
          alert("更新しました");
          $("#emailchange").dialog("close");
          window.location.reload();
        } else {
          $("#emailerror").append(data.message);
        }
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $('#address').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); //郵便番号を入力するテキストフィールドから値を取得

      var zip = $('#zip').val();
      $.ajax({
        url: '/address/{zip}',
        type: 'POST',
        datatype: 'json',
        data: {
          'zip': zip
        }
      }).done(function (data) {
        if (!data.message) {
          var addresslist = new Array();

          for (var _i = 0; _i < data.length; _i++) {
            addresslist += "<option value='" + data[_i].zip + "：" + data[_i].pref + data[_i].city + data[_i].town;
            addresslist += "'>" + data[_i].zip + "：" + data[_i].pref + data[_i].city + data[_i].town + "</option>";
            $('#getaddress').html(addresslist);
          }
        } else {
          alert(data.message);
        }
      }).fail(function () {
        alert("エラーが発生しました");
      });
    });

    $('#sortnum').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var numlist = $("#list-ids").val();
      var listsortnum = $("#listsortnum").val(); // console.log(listsortnum);

      if (listsortnum === "true") {
        $.ajax({
          url: '/numsortchange',
          type: 'POST',
          datatype: 'json',
          data: {
            'numlist': numlist
          }
        }).done(function (data) {
          alert("更新しました");
          window.location.reload();
        }).fail(function () {
          alert("エラーが発生しました");
        });
      } else {
        alert("全件表示をしてください。");
      }
    });

    $('#editaddress').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }); // var zip = $('#zip').val();

      var address = $('#getaddress').val();
      var zip = address.substr(0, address.indexOf('：'));
      var address1 = address.substr(address.indexOf('：') + 1);
      var address2 = $('#address2').val(); // console.log(address);
      // console.log(zip);
      // console.log(address1);

      if (zip) {
        $.ajax({
          url: '/addresschange',
          type: 'POST',
          datatype: 'json',
          data: {
            'zip': zip,
            'address1': address1,
            'address2': address2
          }
        }).done(function (data) {
          alert("更新しました");
          window.location.reload();
        }).fail(function () {
          alert("エラーが発生しました");
        });
      } else {
        $("#err_zip").append("<p><i class=\"fa fa-exclamation-triangle\"></i>郵便番号を入力してください。</p>");
      }
    });

    $('#editphone').on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var phone = $('#tel').val();

      if (phone) {
        $.ajax({
          url: '/phonechange',
          type: 'POST',
          datatype: 'json',
          data: {
            'phone': phone
          }
        }).done(function (data) {
          alert("更新しました");
          window.location.reload();
        }).fail(function () {
          alert("エラーが発生しました");
        });
      } else {
        $("#err_tel").append("<p><i class=\"fa fa-exclamation-triangle\"></i>電話番号を入力してください。</p>");
      }
    });

  });
