<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 追加分
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class TestController extends Controller
{

    public function mypage(Request $req)
    {
        //postされて来なかったとき　×
        if (count($_POST) === 0) {
            echo "ログインしてください";
            echo '<br><a href="/login">戻る</a>';
            exit;
        }


        $user_id = $req->user_id;
        $password = $req->password;

        if (!$user_id) {
            echo 'ユーザＩＤが入力されていません';
            exit;
          } else if (preg_match("/^[a-zA-Z0-9!-\/:-@¥[-`{_~?]+$/", $user_id)) {
          } else {
            print 'ユーザＩＤは半角英数記号のみ。';
            exit;
          }

          if (!$password) {
            echo 'パスワードが入力されていません';
            exit;
          } else if (preg_match("/^([a-zA-Z0-9!-\/:-@¥[-`{_~?]{8,})$/", $password)) {
          } else {
            print 'パスワードは半角英数記号８文字以上';
            exit;
          }

        $members = DB::table('emp')->where('id', $user_id)->get();
        foreach ($members as $member) {
        }

        //入力されたIDがDBのidに存在するか確認
        if (!isset($member->id)) {
            echo 'ユーザーＩＤもしくはパスワードが間違っています';
            echo '<br>';
            echo '<a href="/login">戻る</a>';
            exit;
        }

        // 入力されたパスワードとDBのパスワードを照合
        if (password_verify($password, $member->password)) {
            // echo 'OK';
        } else {
            echo 'ユーザーＩＤもしくはパスワードが間違っています';
            echo '<br>';
            echo '<a href="/login">戻る</a>';
            exit;
        }

        session(['user' => 'use_id']);

        $data = ['member' => $member];
        // print_r($data);
        return view('mypage', $data);
    }

    public function list1(Request $req)
    {
        //ログインユーザーのid取得
        $user = Auth::user()->id;
        //ログインユーザーの役割と権限を取得
        $role_data = DB::table('emp')
            ->select('authority_id', 'roles.name')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();
        //多次元配列になったstdClassをArrayにキャスト
        $encode = json_decode(json_encode($role_data), true);
        //多次元配列を一次元配列に変換
        $array = Arr::flatten($encode);
        //ログインユーザーの役割のみ取得
        $roles_name = $encode[0]['name'];
        //一次元配列の中に特定の値(1:顧客閲覧)があるか判定
        if (in_array(1, $array)) {
            $dispnum = 5;
            $sort = 'asc';

            if (!$req->category) {
                $category = 'id';
            } else {
                $category = $req->category;
            }


            if ($req->sortid) {
                $sort = $req->sortid;
                $category = 'id';
            }
            if ($req->sortempno) {
                $sort = $req->sortempno;
                $category = 'empno';
            }
            if ($req->sortename) {
                $sort = $req->sortename;
                $category = 'ename';
            }
            if ($req->sortjob) {
                $sort = $req->sortjob;
                $category = 'job';
            }
            if ($req->sortmgr) {
                $sort = $req->sortmgr;
                $category = 'mgr';
            }
            if ($req->sorthiredate) {
                $sort = $req->sorthiredate;
                $category = 'hiredate';
            }
            if ($req->sortsal) {
                $sort = $req->sortsal;
                $category = 'sal';
            }
            if ($req->sortcomm) {
                $sort = $req->sortcomm;
                $category = 'comm';
            }
            if ($req->sortdeptno) {
                $sort = $req->sortdeptno;
                $category = 'deptno';
            }


            if ($sort === '▼') {
                $sort = 'desc';
                if ($req->dispnum) {
                    $dispnum = $req->dispnum;
                }
            } else if($sort === '▲') {
                $sort = 'asc';
                if ($req->dispnum) {
                    $dispnum = $req->dispnum;
                }
            }

            if ($req->sorton) {
                $sort = $req->sorton;
            }

            // print_r($dispnum);
            // print_r($sort);
            // print_r($category);

            // $members = DB::table('emp')->orderby($category, $sort)->paginate($dispnum);

            $members = DB::table('emp')
            ->select('emp.id', 'empno', 'ename', 'job', 'mgr', 'hiredate', 'sal', 'comm', 'deptno', 'img1', 'img2', 'roles.name')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->orderby($category, $sort)->paginate($dispnum);

            $data = ['members' => $members, 'dispnum' => $dispnum, 'sort' => $sort, 'category' => $category, 'array' => $array, 'roles_name' => $roles_name];
            // // print_r($data);
            return view('list1', $data);

        } else {
            return view('dashboard');
        }
    }

    public function edit1(Request $req)
    {
        $user = Auth::user()->id;

        $role_data = DB::table('emp')
            ->select('authority_id')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();

        $encode = json_decode(json_encode($role_data), true);
        $array = Arr::flatten($encode);

        if (in_array(2, $array)) {
            $editdata = DB::table('emp')->where('id', $req->edid)->update([
                'id' => $req->ed1,
                'empno' => $req->ed2,
                'ename' => $req->ed3,
                'job' => $req->ed4,
                'mgr' => $req->ed5,
                'hiredate' => $req->ed6,
                'sal' => $req->ed7,
                'comm' => $req->ed8,
                'deptno' => $req->ed9
            ]);
            // $data = ['title' => '編集', 'members' => $members];
            // print_r($data);
            return response()->json($editdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function editcheck1(Request $req)
    {
        $user = Auth::user()->id;

        $role_data = DB::table('emp')
            ->select('authority_id')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();

        $encode = json_decode(json_encode($role_data), true);
        $array = Arr::flatten($encode);

        if (in_array(2, $array)) {
            $editlist = array($req->editid, $req->editempno, $req->editename, $req->editjob, $req->editmgr, $req->edithiredate, $req->editsal, $req->editcomm, $req->editdeptno);

            $editcheckdata = $editlist;
            return response()->json($editcheckdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function edit1_2(Request $req)
    {
        $empno2 = $req->empno2;
        $user_id = $req->user_id;
        $empno = $req->empno;
        $ename = $req->ename;
        $job = $req->job;
        $mgr = $req->mgr;
        $hiredate = $req->hiredate;
        $sal = $req->sal;
        $comm = $req->comm;
        $deptno = $req->deptno;

        DB::table('emp')->where('empno', $empno2)->update([
            'id' => $user_id,
            'empno' => $empno,
            'ename' => $ename,
            'job' => $job,
            'mgr' => $mgr,
            'hiredate' => $hiredate,
            'sal' => $sal,
            'comm' => $comm,
            'deptno' => $deptno
        ]);

        return view('edit1_2',);
    }

    public function insert1(Request $req)
    {
        $user = Auth::user()->id;

        $role_data = DB::table('emp')
            ->select('authority_id')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();

        $encode = json_decode(json_encode($role_data), true);
        $array = Arr::flatten($encode);

        if (in_array(2, $array)) {
            $user_id = $req->insid;
            $empno = $req->insempno;
            $ename = $req->insename;
            $job = $req->insjob;
            $mgr = $req->insmgr;
            $hiredate = $req->inshiredate;
            $sal = $req->inssal;
            $comm = $req->inscomm;
            $deptno = $req->insdeptno;

            $insertdata = DB::table('emp')->insert([
                            'id' => $user_id,
                            'empno' => $empno,
                            'ename' => $ename,
                            'job' => $job,
                            'mgr' => $mgr,
                            'hiredate' => $hiredate,
                            'sal' => $sal,
                            'comm' => $comm,
                            'deptno' => $deptno,
                        ]);
            // $data = ['title' => '追加確認', 'members' => $members];
            // print_r($data);
            return response()->json($insertdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }


    public function insert1_2(Request $req)
    {
        $user_id = $req->user_id;
        $empno = $req->empno;
        $ename = $req->ename;
        $job = $req->job;
        $mgr = $req->mgr;
        $hiredate = $req->hiredate;
        $sal = $req->sal;
        $comm = $req->comm;
        $deptno = $req->deptno;

        DB::table('emp')->insert([
            'id' => $user_id,
            'empno' => $empno,
            'ename' => $ename,
            'job' => $job,
            'mgr' => $mgr,
            'hiredate' => $hiredate,
            'sal' => $sal,
            'comm' => $comm,
            'deptno' => $deptno
        ]);

        return view('insert1_2',);
    }

    public function delete1(Request $req)
    {
        $user = Auth::user()->id;

        $role_data = DB::table('emp')
            ->select('authority_id')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();

        $encode = json_decode(json_encode($role_data), true);
        $array = Arr::flatten($encode);

        if (in_array(2, $array)) {
            $deletedata = DB::table('emp')->where('empno', $req->empno)->delete();
            // $data = ['title' => '削除確認', 'members' => $members];
            // print_r($data);
            return response()->json($deletedata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function delete1_2(Request $req)
    {
        $empno = $req->empno;

        DB::table('emp')->where('empno', $empno)->delete();

        return view('delete1_2',);
    }

    public function list2(Request $req)
    {
        $user = Auth::user()->id;

        $role_data = DB::table('emp')
            ->select('authority_id')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();

        $encode = json_decode(json_encode($role_data), true);
        $array = Arr::flatten($encode);

        if (in_array(3, $array)) {
            $dispnum = 3;
            $sort = 'asc';


            if (!$req->category) {
                $category = 'deptno';
            } else {
                $category = $req->category;
            }


            if ($req->sortdeptno) {
                $sort = $req->sortdeptno;
                $category = 'deptno';
            }
            if ($req->sortdname) {
                $sort = $req->sortdname;
                $category = 'dname';
            }
            if ($req->sortloc) {
                $sort = $req->sortloc;
                $category = 'loc';
            }


            if ($sort === '▼') {
                $sort = 'desc';
                if ($req->dispnum) {
                    $dispnum = $req->dispnum;
                }
            } else {
                $sort = 'asc';
                if ($req->dispnum) {
                    $dispnum = $req->dispnum;
                }
            }

            if ($req->sorton) {
                $sort = $req->sorton;
            }

            // print_r($dispnum);
            // print_r($sort);
            // print_r($category);

            $members = DB::table('dept')->orderby($category, $sort)->paginate($dispnum);
            $data = ['depte' => $members, 'dispnum' => $dispnum, 'sort' => $sort, 'category' => $category, 'array' => $array];
            // print_r($data);
            return view('list2', $data);

        } else {
            return view('dashboard');
        }
    }

    public function edit2(Request $req)
    {
        $user = Auth::user()->id;

        $role_data = DB::table('emp')
            ->select('authority_id')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();

        $encode = json_decode(json_encode($role_data), true);
        $array = Arr::flatten($encode);

        if (in_array(4, $array)) {
            $editdata = DB::table('dept')->where('deptno', $req->edid)->update([
                        'deptno' => $req->ed1,
                        'dname' => $req->ed2,
                        'loc' => $req->ed3,
                    ]);
            // $data = ['title' => '編集', 'dept' => $members];
            return response()->json($editdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function editcheck2(Request $req)
    {
        $user = Auth::user()->id;

        $role_data = DB::table('emp')
            ->select('authority_id')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();

        $encode = json_decode(json_encode($role_data), true);
        $array = Arr::flatten($encode);

        if (in_array(4, $array)) {
            $editlist = array($req->editdeptno, $req->editdname, $req->editloc);

            $editcheckdata = $editlist;
            return response()->json($editcheckdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function edit2_2(Request $req)
    {
        $deptno2 = $req->deptno2;
        $deptno = $req->deptno;
        $dname = $req->dname;
        $loc = $req->loc;

        DB::table('dept')->where('deptno', $deptno2)->update([
            'deptno' => $deptno,
            'dname' => $dname,
            'loc' => $loc,
        ]);

        return view('edit2_2',);
    }

    public function insert2(Request $req)
    {
        $user = Auth::user()->id;

        $role_data = DB::table('emp')
            ->select('authority_id')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();

        $encode = json_decode(json_encode($role_data), true);
        $array = Arr::flatten($encode);

        if (in_array(4, $array)) {
            $deptno = $req->insdeptno;
            $dname = $req->insdname;
            $loc = $req->insloc;

            $insertdata = DB::table('dept')->insert([
                            'deptno' => $deptno,
                            'dname' => $dname,
                            'loc' => $loc,
                        ]);

            // $members = array($deptno, $dname, $loc);
            // $data = ['title' => '追加確認', 'dept' => $members];
            // print_r($data);
            return response()->json($insertdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }


    public function insert2_2(Request $req)
    {
        $deptno = $req->deptno;
        $dname = $req->dname;
        $loc = $req->loc;

        DB::table('dept')->insert([
            'deptno' => $deptno,
            'dname' => $dname,
            'loc' => $loc,
        ]);

        return view('insert2_2',);
    }

    public function delete2(Request $req)
    {
        $user = Auth::user()->id;

        $role_data = DB::table('emp')
            ->select('authority_id')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();

        $encode = json_decode(json_encode($role_data), true);
        $array = Arr::flatten($encode);

        if (in_array(4, $array)) {
            $deletedata = DB::table('dept')->where('deptno', $req->deptid)->delete();
            // $data = ['title' => '部署一覧', 'members' => $members];
            return response()->json($deletedata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function delete2_2(Request $req)
    {
        $deptno = $req->deptno;

        DB::table('dept')->where('deptno', $deptno)->delete();

        return view('delete2_2',);
    }

    public function enamesearch(Request $req)
    {
        $searchdata = DB::table('emp')->select('*')->where('ename', 'like', "%$req->ename%")->get();
        // $data = ['title' => '検索結果', 'members' => $members];
        // print_r($data);
        return response()->json($searchdata);
    }

    public function salsearch(Request $req)
    {
        $searchdata = DB::table('emp')->select('*')->where('sal', '>=', $req->minnum)->where('sal', '<=', $req->maxnum)->get();
        // $data = ['title' => '検索結果', 'members' => $members];
        // print_r($data);
        return response()->json($searchdata);
    }

    public function dnamesearch(Request $req)
    {
        $searchdata = DB::table('dept')->select('*')->where('dname', 'like', "%$req->dname%")->get();

        // $data = ['title' => '検索結果', 'dept' => $members];
        // print_r($data);
        return response()->json($searchdata);
    }

    public function empcsvd(Request $req) {
        $data = $req->enamesearch;
        $min = $req->minsearch;
        $max = $req->maxsearch;

        if($data) {
            return response()->streamDownload(
                function () use($data) {
                    // 出力バッファをopen
                    $stream = fopen('php://output', 'w');
                    // 文字コードをShift-JISに変換
                    stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');

                // ヘッダー
                fputcsv($stream, [
                    'id',
                    'empno',
                    'ename',
                    'job',
                    'mgr',
                    'hiredate',
                    'sal',
                    'comm',
                    'deptno',
                ]);
                // データ
                $csv =DB::table('emp')->select('*')->where('ename', 'like', '%'.$data.'%')->get();
                foreach ($csv as $emp) {
                    fputcsv($stream, [
                        $emp->id,
                        $emp->empno,
                        $emp->ename,
                        $emp->job,
                        $emp->mgr,
                        $emp->hiredate,
                        $emp->sal,
                        $emp->comm,
                        $emp->deptno,
                    ]);
                }
                fclose($stream);
                },
                'emp.csv',
                [
                    'Content-Type' => 'application/octet-stream',
                ]
            );
        } else if ($min && $max) {
            return response()->streamDownload(
                function () use($min, $max) {
                    // 出力バッファをopen
                    $stream = fopen('php://output', 'w');
                    // 文字コードをShift-JISに変換
                    stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');

                // ヘッダー
                fputcsv($stream, [
                    'id',
                    'empno',
                    'ename',
                    'job',
                    'mgr',
                    'hiredate',
                    'sal',
                    'comm',
                    'deptno',
                ]);
                // データ
                $csv =DB::table('emp')->select('*')->where('sal', '>=', $min)->where('sal', '<=', $max)->get();
                foreach ($csv as $emp) {
                    fputcsv($stream, [
                        $emp->id,
                        $emp->empno,
                        $emp->ename,
                        $emp->job,
                        $emp->mgr,
                        $emp->hiredate,
                        $emp->sal,
                        $emp->comm,
                        $emp->deptno,
                    ]);
                }
                fclose($stream);
                },
                'emp.csv',
                [
                    'Content-Type' => 'application/octet-stream',
                ]
            );
        } else if ($min && !$max) {
            return response()->streamDownload(
                function () use($min) {
                    // 出力バッファをopen
                    $stream = fopen('php://output', 'w');
                    // 文字コードをShift-JISに変換
                    stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');

                // ヘッダー
                fputcsv($stream, [
                    'id',
                    'empno',
                    'ename',
                    'job',
                    'mgr',
                    'hiredate',
                    'sal',
                    'comm',
                    'deptno',
                ]);
                // データ
                $csv =DB::table('emp')->select('*')->where('sal', '>=', $min)->get();
                foreach ($csv as $emp) {
                    fputcsv($stream, [
                        $emp->id,
                        $emp->empno,
                        $emp->ename,
                        $emp->job,
                        $emp->mgr,
                        $emp->hiredate,
                        $emp->sal,
                        $emp->comm,
                        $emp->deptno,
                    ]);
                }
                fclose($stream);
                },
                'emp.csv',
                [
                    'Content-Type' => 'application/octet-stream',
                ]
            );
        } else if (!$min && $max) {
            return response()->streamDownload(
                function () use($max) {
                    // 出力バッファをopen
                    $stream = fopen('php://output', 'w');
                    // 文字コードをShift-JISに変換
                    stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');

                // ヘッダー
                fputcsv($stream, [
                    'id',
                    'empno',
                    'ename',
                    'job',
                    'mgr',
                    'hiredate',
                    'sal',
                    'comm',
                    'deptno',
                ]);
                // データ
                $csv =DB::table('emp')->select('*')->where('sal', '<=', $max)->get();
                foreach ($csv as $emp) {
                    fputcsv($stream, [
                        $emp->id,
                        $emp->empno,
                        $emp->ename,
                        $emp->job,
                        $emp->mgr,
                        $emp->hiredate,
                        $emp->sal,
                        $emp->comm,
                        $emp->deptno,
                    ]);
                }
                fclose($stream);
                },
                'emp.csv',
                [
                    'Content-Type' => 'application/octet-stream',
                ]
            );
        } else {
            return response()->streamDownload(
                function () {
                    // 出力バッファをopen
                    $stream = fopen('php://output', 'w');
                    // 文字コードをShift-JISに変換
                    stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');

                    // ヘッダー
                    fputcsv($stream, [
                        'id',
                        'empno',
                        'ename',
                        'job',
                        'mgr',
                        'hiredate',
                        'sal',
                        'comm',
                        'deptno',
                    ]);
                    // データ
                    $csv =DB::table('emp')->get();
                    foreach ($csv as $emp) {
                        fputcsv($stream, [
                            $emp->id,
                            $emp->empno,
                            $emp->ename,
                            $emp->job,
                            $emp->mgr,
                            $emp->hiredate,
                            $emp->sal,
                            $emp->comm,
                            $emp->deptno,
                        ]);
                    }
                    fclose($stream);
                },
                'emp.csv',
                [
                    'Content-Type' => 'application/octet-stream',
                ]
            );
        }
    }

    public function empcsvin(Request $req) {
        // 一時アップロード先ファイルパス
        $file_tmp  = $_FILES["csv_file"]["tmp_name"];

        //SplFileObjectを生成
        $file = new \SplFileObject($file_tmp);

        //SplFileObject::READ_CSV が最速らしい
        $file->setFlags(\SplFileObject::READ_CSV); // 一行ずつ処理

        $row_count = 1;

        foreach($file as $row) {

            // 最終行の処理(最終行が空っぽの場合の対策
            if ($row === [null]) continue;
            // 1行目のヘッダーは取り込まない
            if ($row_count > 1)
            {
                // CSVの文字コードがSJISなのでUTF-8に変更
                $id = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
                $empno = mb_convert_encoding($row[1], 'UTF-8', 'SJIS');
                $ename = mb_convert_encoding($row[2], 'UTF-8', 'SJIS');
                $job = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');
                $mgr = mb_convert_encoding($row[4], 'UTF-8', 'SJIS');
                $hiredate = mb_convert_encoding($row[5], 'UTF-8', 'SJIS');
                $sal = mb_convert_encoding($row[6], 'UTF-8', 'SJIS');
                $comm = mb_convert_encoding($row[7], 'UTF-8', 'SJIS');
                $deptno = mb_convert_encoding($row[8], 'UTF-8', 'SJIS');

                if (isset($id) && preg_match("/^[a-zA-Z0-9!-\/:-@¥[-`{_~?]+$/", $id)) { //issetで値が空でないか、また、preg_matchで正規表現チェック
                } else {
                    if (empty($id)) { //emptyで値が空であればtrue
                        $eid = 'id:空白';
                    } else {
                        $eid = 'id:'.$id;
                    }
                    $valA[] = $eid;
                    $valB[] = $row_count;
                }

                if (isset($empno) && preg_match("/^([1-9][0-9]{3})/", $empno)) { //issetで値が空でないか、また、preg_matchで正規表現チェック
                } else {
                    if (empty($empno)) { //emptyで値が空であればtrue
                        $emp = 'empno:空白';
                    } else {
                        $emp = 'empno:'.$empno;
                    }
                    $valA[] = $emp;
                    $valB[] = $row_count;
                }

                if (is_string($ename)) {
                } else {
                    $en = 'ename:'.$ename;
                    $valA[] = $en;
                    $valB[] = $row_count;
                }

                if (is_string($job)) {
                } else {
                    $jo = 'job:'.$job;
                    $valA[] = $jo;
                    $valB[] = $row_count;
                }

                if (empty($mgr) || preg_match("/^([1-9][0-9]{3})/", $mgr)) {
                } else {
                    $mg = 'mgr:'.$mgr;
                    $valA[] = $mg;
                    $valB[] = $row_count;
                }

                if (preg_match("/\d{4}\/\d{1,2}\/\d{1,2}/", $hiredate)) {
                } else {
                    $hire = 'hiredate:'.$hiredate;
                    $valA[] = $hire;
                    $valB[] = $row_count;
                }

                if (empty($mgr) || preg_match("/^[1-9][0-9]*/", $sal)) {
                } else {
                    $sa = 'sal:'.$sal;
                    $valA[] = $sa;
                    $valB[] = $row_count;
                }

                if (empty($mgr) || preg_match("/^[1-9][0-9]*/", $comm)) {
                } else {
                    $com = 'comm:'.$comm;
                    $valA[] = $com;
                    $valB[] = $row_count;
                }

                if (isset($deptno) && preg_match("/^[1-9][0-9]$/", $deptno)) {
                } else {
                    if (empty($deptno)) {
                        $dep = 'deptno:空白';
                    } else {
                        $dep = 'deptno:'.$deptno;
                    }
                    $valA[] = $dep;
                    $valB[] = $row_count;
                }

            }
            $row_count++;
        }

        if (isset($valA)) { //$valAに値があれば(エラーがあれば)true
            $resp = array('valA'=>$valA, 'valB'=>$valB);
            return response()->json($resp); //エラー内容を返す
        } else {

        //比較用データ作成。昇順で取得
        $check = array();
        $list = DB::table('emp')->select('empno')->orderby('empno', 'asc')->get();
        foreach ($list as $key) {
        $value = $key->empno;
        array_push($check, $value);
        }

        $row_count = 1;

        //比較用データの要素数を代入
        $num = count($check);

        foreach($file as $row) {

            // 最終行の処理(最終行が空っぽの場合の対策
            if ($row === [null]) continue;
            // 1行目のヘッダーは取り込まない
            if ($row_count > 1)
            {
                // CSVの文字コードがSJISなのでUTF-8に変更
                $id = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
                $empno = mb_convert_encoding($row[1], 'UTF-8', 'SJIS');
                $ename = mb_convert_encoding($row[2], 'UTF-8', 'SJIS');
                $job = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');
                $mgr = mb_convert_encoding($row[4], 'UTF-8', 'SJIS');
                $hiredate = mb_convert_encoding($row[5], 'UTF-8', 'SJIS');
                $sal = mb_convert_encoding($row[6], 'UTF-8', 'SJIS');
                $comm = mb_convert_encoding($row[7], 'UTF-8', 'SJIS');
                $deptno = mb_convert_encoding($row[8], 'UTF-8', 'SJIS');


                for ($i = 0; $i < $num; $i++) {
                    if ($check[$i] == $empno) {
                        //同じempnoだった場合は更新。違う場合は何もしない
                        DB::table('emp')->where('empno', $empno)->update([
                            'id' => $id,
                            'empno' => $empno,
                            'ename' => $ename,
                            'job' => $job,
                            'mgr' => $mgr,
                            'hiredate' => $hiredate,
                            'sal' => $sal,
                            'comm' => $comm,
                            'deptno' => $deptno,
                        ]);
                        break;
                    } else if ($check[$i] > $empno) {
                        //CSVのデータ$empnoが$check[$i]より小さくなった場合は追加。違う場合は何もしない
                        DB::table('emp')->insert([
                            'id' => $id,
                            'empno' => $empno,
                            'ename' => $ename,
                            'job' => $job,
                            'mgr' => $mgr,
                            'hiredate' => $hiredate,
                            'sal' => $sal,
                            'comm' => $comm,
                            'deptno' => $deptno,
                        ]);
                        break;
                    } else if ($check[$num-1] < $empno) {
                        //CSVのデータ$empnoが登録されている一番大きいempnoより大きかった場合は追加
                        DB::table('emp')->insert([
                            'id' => $id,
                            'empno' => $empno,
                            'ename' => $ename,
                            'job' => $job,
                            'mgr' => $mgr,
                            'hiredate' => $hiredate,
                            'sal' => $sal,
                            'comm' => $comm,
                            'deptno' => $deptno,
                        ]);
                        break;
                    }
                }
            }
            $row_count++;
        }
            $true = true;
            return response()->json($true);
        }
    }

    public function deptcsvd(Request $req) {
            $data = $req->dnamesearch;
            // print_r($data);

    if($data) {
        return response()->streamDownload(
            function () use($data) {
                // 出力バッファをopen
                $stream = fopen('php://output', 'w');
                // 文字コードをShift-JISに変換
                stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');

                // ヘッダー
                fputcsv($stream, [
                    'deptno',
                    'dname',
                    'loc',
                ]);
                // データ
                $csv =DB::table('dept')->select('*')->where('dname', 'like', '%'.$data.'%')->get();
                foreach ($csv as $dept) {
                    fputcsv($stream, [
                        $dept->deptno,
                        $dept->dname,
                        $dept->loc,
                    ]);
                }
                fclose($stream);
            },
            'dept.csv',
            [
                'Content-Type' => 'application/octet-stream',
            ]
        );
    } else {
        return response()->streamDownload(
            function () {
                // 出力バッファをopen
                $stream = fopen('php://output', 'w');
                // 文字コードをShift-JISに変換
                stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');

                // ヘッダー
                fputcsv($stream, [
                    'deptno',
                    'dname',
                    'loc',
                ]);
                // データ
                $csv =DB::table('dept')->get();
                foreach ($csv as $dept) {
                    fputcsv($stream, [
                        $dept->deptno,
                        $dept->dname,
                        $dept->loc,
                    ]);
                }
                fclose($stream);
            },
            'dept.csv',
            [
                'Content-Type' => 'application/octet-stream',
            ]
        );
    }
    }

    public function deptcsvin(Request $req) {
        // 一時アップロード先ファイルパス
        $file_path  = $_FILES["csv_file"]["tmp_name"];

        //SplFileObjectを生成
        $file = new \SplFileObject($file_path);

        //SplFileObject::READ_CSV が最速らしい
        $file->setFlags(\SplFileObject::READ_CSV); // 一行ずつ処理

        $row_count = 1;

        foreach($file as $row) {

            // 最終行の処理(最終行が空っぽの場合の対策
            if ($row === [null]) continue;
            // 1行目のヘッダーは取り込まない
            if ($row_count > 1)
            {
                // CSVの文字コードがSJISなのでUTF-8に変更
                $deptno = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
                $dname = mb_convert_encoding($row[1], 'UTF-8', 'SJIS');
                $loc = mb_convert_encoding($row[2], 'UTF-8', 'SJIS');


                if (isset($deptno) && preg_match("/^[1-9][0-9]$/", $deptno)) { //issetで値が空でないか、また、preg_matchで正規表現チェック
                } else {
                    if (empty($deptno)) { //emptyで値が空であればtrue
                        $dep = 'deptno:空白';
                    } else {
                        $dep = 'deptno:'.$deptno;
                    }
                    $valA[] = $dep;
                    $valB[] = $row_count;
                }

                if (is_string($dname)) {
                } else {
                    $dn = 'dname:'.$dname;
                    $valA[] = $dn;
                    $valB[] = $row_count;
                }

                if (is_string($loc)) {
                } else {
                    $lo = 'loc:'.$loc;
                    $valA[] = $lo;
                    $valB[] = $row_count;
                }

            }
            $row_count++;
        }

        if (isset($valA)) { //$valAに値があれば(エラーがあれば)true
            $resp = array('valA'=>$valA, 'valB'=>$valB);
            return response()->json($resp); //エラー内容を返す
        } else {

        //比較用データ作成。昇順で取得
        $check = array();
        $list = DB::table('dept')->select('deptno')->orderby('deptno', 'asc')->get();
        foreach ($list as $key) {
        $value = $key->deptno;
        array_push($check, $value);
        }

        $row_count = 1;

        //比較用データの要素数を代入
        $num = count($check);

        foreach($file as $row) {

            // 最終行の処理(最終行が空っぽの場合の対策
            if ($row === [null]) continue;
            // 1行目のヘッダーは取り込まない
            if ($row_count > 1)
            {
                // CSVの文字コードがSJISなのでUTF-8に変更
                $deptno = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
                $dname = mb_convert_encoding($row[1], 'UTF-8', 'SJIS');
                $loc = mb_convert_encoding($row[2], 'UTF-8', 'SJIS');


                for ($i = 0; $i < $num; $i++) {
                    if ($check[$i] == $deptno) {
                        //同じdeptnoだった場合は更新。違う場合は何もしない
                        DB::table('dept')->where('deptno', $deptno)->update([
                            'deptno' => $deptno,
                            'dname' => $dname,
                            'loc' => $loc,
                        ]);
                        break;
                    } else if ($check[$i] > $deptno) {
                        //CSVのデータ$deptnoが$check[$i]より小さくなった場合は追加。違う場合は何もしない
                        DB::table('dept')->insert([
                            'deptno' => $deptno,
                            'dname' => $dname,
                            'loc' => $loc,
                        ]);
                        break;
                    } else if ($check[$num-1] < $deptno) {
                        //CSVのデータ$deptnoが登録されている一番大きいdeptnoより大きかった場合は追加
                        DB::table('dept')->insert([
                            'deptno' => $deptno,
                            'dname' => $dname,
                            'loc' => $loc,
                        ]);
                        break;
                    }
                }
            }
            $row_count++;
        }
            $true = true;
            return response()->json($true);
        }
    }

    public function tuikaimg1(Request $req)
    {
        //選択したファイルの拡張子だけを取得
        $ext = pathinfo($_FILES["simg1"]["name"], PATHINFO_EXTENSION);

        // 大文字を小文字にする
        $file_ext = strtolower($ext);

        // 拡張子を照合する
        if($file_ext != "jpg" && $file_ext != "gif" && $file_ext != "png"){
            $resp = 'エラー！<br>ファイルが画像ではありません。<br>対応拡張子(.jpg　.gif　.png)';
            return response()->json($resp); //エラー内容を返す
        }

        $size = getimagesize($_FILES["simg1"]["tmp_name"]);
        $width_size = $size[0]; //画像の横幅
        $height_size = $size[1]; //画像の高さ

        //画像サイズ制限
        if ($width_size > 300 || $height_size > 300) {
            $resp = 'エラー！<br>画像サイズは300×300までです。';
            return response()->json($resp); //エラー内容を返す
        }

        //画像データ取得
        $file = $req->file('simg1');

        // ファイルを文字列とする
        $img = file_get_contents($file);

        // ファイルをbase64でエンコード
        $image = base64_encode($img);

        // 上記処理にて保存した画像を、empテーブルのimg1カラムに格納
        DB::table('emp')->where('empno', $req->empno)->update(['img1' => $image]);

        $true = true;
        return response()->json($true);
    }

    public function tuikaimg2(Request $req)
    {
        //選択したファイルの拡張子だけを取得
        $ext = pathinfo($_FILES["simg2"]["name"], PATHINFO_EXTENSION);

        // 大文字を小文字にする
        $file_ext = strtolower($ext);

        // 拡張子を照合する
        if($file_ext != "jpg" && $file_ext != "gif" && $file_ext != "png"){
            $resp = 'エラー！<br>ファイルが画像ではありません。<br>対応拡張子(.jpg　.gif　.png)';
            return response()->json($resp); //エラー内容を返す
        }

        $size = getimagesize($_FILES["simg2"]["tmp_name"]);
        $width_size = $size[0]; //画像の横幅
        $height_size = $size[1]; //画像の高さ

        //画像サイズ制限
        if ($width_size > 300 || $height_size > 300) {
            $resp = 'エラー！<br>画像サイズは300×300までです。';
            return response()->json($resp); //エラー内容を返す
        }

        //name属性が'simg2'のinputタグをファイル形式に、画像をpublic/imgに保存
        $filePath = $req->file('simg2')->store('public/img/'); // storage > public > img配下に画像が保存される

        // 上記処理にて保存した画像を、empテーブルのimg2カラムに格納
        DB::table('emp')->where('empno', $req->empno)->update(['img2' => basename($filePath)]);

        $true = true;
        return response()->json($true);
    }

    public function imgdelete1(Request $req)
    {
        $deleteimg1 = DB::table('emp')->where('empno', $req->empno)->update(['img1' => NULL]);
        return response()->json($deleteimg1);
    }

    public function imgdelete2(Request $req)
    {
        $deleteimg2 = DB::table('emp')->where('empno', $req->empno)->update(['img2' => NULL]);
        return response()->json($deleteimg2);
    }

    public function role_change(Request $req)
    {
        $user = Auth::user()->id;

        $role_data = DB::table('emp')
            ->select('authority_id')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();

        $encode = json_decode(json_encode($role_data), true);
        $array = Arr::flatten($encode);

        if (in_array(2, $array)) {
            $change = DB::table('emp')->where('empno', $req->empno)->update(['role' => $req->val]);
            return response()->json($change);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function log(Request $req)
    {
        $dispnum = 10;
        $sort = 'desc';

        if (!$req->category) {
            $category = 'access_time';
        } else {
            $category = $req->category;
        }


        if ($req->sortaccess_time) {
            $sort = $req->sortaccess_time;
            $category = 'access_time';
        }
        if ($req->sortid) {
            $sort = $req->sortid;
            $category = 'user_id';
        }
        if ($req->sortip) {
            $sort = $req->sortip;
            $category = 'ip_address';
        }
        if ($req->sortagent) {
            $sort = $req->sortagent;
            $category = 'user_agent';
        }
        if ($req->sortsession) {
            $sort = $req->sortsession;
            $category = 'session_id';
        }
        if ($req->sorturl) {
            $sort = $req->sorturl;
            $category = 'access_url';
        }
        if ($req->sortoperation) {
            $sort = $req->sortoperation;
            $category = 'operation';
        }


        if ($sort === '▼') {
            $sort = 'desc';
            if ($req->dispnum) {
                $dispnum = $req->dispnum;
            }
        } else if ($sort === '▲') {
            $sort = 'asc';
            if ($req->dispnum) {
                $dispnum = $req->dispnum;
            }
        }

        if ($req->sorton) {
            $sort = $req->sorton;
        }

        $logger = DB::table('user_logs')
        ->select('user_id', 'ip_address', 'user_agent', 'session_id', 'access_url', 'operation', 'access_time')
        ->orderby($category, $sort)->paginate($dispnum);

        $data = ['logger' => $logger, 'dispnum' => $dispnum, 'sort' => $sort, 'category' => $category];
        // print_r($data);
        return view('log', $data);

    }

    public function logserch(Request $req)
    {
        $searchlog = DB::table('user_logs')->select(
            'user_id', 'ip_address', 'user_agent', 'session_id',
            'access_url', 'operation', 'access_time')
            ->where($req->val, 'like', "%$req->word%")->orderby('access_time', 'desc')->get();
        return response()->json($searchlog);
    }

    public function logcsvd(Request $req) {

        // if($word) {
        //     return response()->streamDownload(
        //         function () use($val, $word) {
        //             // 出力バッファをopen
        //             $stream = fopen('php://output', 'w');
        //             // 文字コードをShift-JISに変換
        //             stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');

        //         // ヘッダー
        //         fputcsv($stream, [
        //             'access_time',
        //             'user_id',
        //             'ip_address',
        //             'user_agent',
        //             'session_id',
        //             'access_url',
        //             'operation',
        //         ]);
        //         // データ
        //         $csv =DB::table('user_logs')->select('*')->where($val, 'like', '%'.$word.'%')->get();
        //         foreach ($csv as $log) {
        //             fputcsv($stream, [
        //                 $log->access_time,
        //                 $log->user_id,
        //                 $log->ip_address,
        //                 $log->user_agent,
        //                 $log->session_id,
        //                 $log->access_url,
        //                 $log->operation,
        //             ]);
        //         }
        //         fclose($stream);
        //         },
        //         'log.csv',
        //         [
        //             'Content-Type' => 'application/octet-stream',
        //         ]
        //     );
        // } else {
            return response()->streamDownload(
                function () {
                    // 出力バッファをopen
                    $stream = fopen('php://output', 'w');
                    // 文字コードをShift-JISに変換
                    stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');

                    // ヘッダー
                    fputcsv($stream, [
                        'access_time',
                        'user_id',
                        'ip_address',
                        'user_agent',
                        'session_id',
                        'access_url',
                        'operation',
                    ]);
                    // データ
                    $csv =DB::table('user_logs')->get();
                    foreach ($csv as $log) {
                        fputcsv($stream, [
                            $log->access_time,
                            $log->user_id,
                            $log->ip_address,
                            $log->user_agent,
                            $log->session_id,
                            $log->access_url,
                            $log->operation,
                        ]);
                    }
                    fclose($stream);
                },
                'log.csv',
                [
                    'Content-Type' => 'application/octet-stream',
                ]
            );
        // }
    }



    public function aaa(Request $req)
    {
        //passwordをhash化
        // $pass = DB::table('emp')
        //     ->select('password')
        //     ->where('empno', 2001)->get();

        //     foreach ($pass as $pas) {
        //     }
        // $rrr = $pas->password;

        // $hashpass = password_hash($rrr, PASSWORD_DEFAULT);

        // DB::table('emp')->where('empno', 2001)->update([
        //     'password' => $hashpass,
        // ]);


        $user = Auth::user()->id;

        $role_data = DB::table('emp')
            ->select('authority_id', 'roles.name')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->join('authority_role', 'roles.id', '=', 'role_id')
            ->where('empno', '=', $user)->get();

        $encode = json_decode(json_encode($role_data), true);
        $array = Arr::flatten($encode);
        // $ketu_role = $encode[0]['authority_id'];
        // $khen_role = $encode[1]['authority_id'];
        // $betu_role = $encode[2]['authority_id'];
        // $bhen_role = $encode[3]['authority_id'];
        // $role_name = $encode[0]['name'];

        // print_r($ketu_role."\n");
        // print_r($khen_role."\n");
        // print_r($betu_role."\n");
        // print_r($bhen_role."\n");
        // print_r($role_name);
         echo($array);
        // dd( $array );
        // dd( $ar );
    }
}
