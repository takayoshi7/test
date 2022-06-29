<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 追加分
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Models\Emp;
use App\Models\Dept;
use App\Models\UserLog;

class TestController extends Controller
{

    public function list1(Request $req)
    {
        $array = $req->array;
        $roles_name = $req->roles_name;
        $ename = "";
        $min = 0;
        $max = 99999;
        $dispnum = 5;
        $sort = 'asc';
        $category = "id";
        $list1_page = 1;
        $req->session()->put(['ename' => $ename, 'min' => $min, 'max' => $max, 'dispnum' => $dispnum, 'sort' => $sort, 'category' => $category, 'list1_page' => $list1_page]);

        //一次元配列の中に特定の値(1:顧客閲覧)があるか判定
        if (in_array(1, $array)) {
            $members = Emp::
            select('emp.id', 'empno', 'ename', 'job', 'mgr', 'hiredate', 'sal', 'comm', 'deptno', 'img1', 'img2', 'roles.name')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->orderby('id', 'asc')->paginate(5);

            $droplist = DB::table('dept')->select('deptno', 'dname', 'sort')->orderby('sort', 'asc')->get();

            $data = ['members' => $members, 'droplist' => $droplist, 'array' => $array, 'roles_name' => $roles_name];
            return view('list1', $data);
        } else {
            return view('dashboard');
        }
    }

    public function edit1(Request $req)
    {
        $array = $req->array;

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
            return response()->json($editdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function insert1(Request $req)
    {
        $array = $req->array;

        if (in_array(2, $array)) {
            $deptno = $req->insdeptno;

            $insertdata = DB::table('emp')->insert([
                            'id' => $req->insid,
                            'empno' => $req->insempno,
                            'ename' => $req->insename,
                            'job' => $req->insjob,
                            'mgr' => $req->insmgr,
                            'hiredate' => $req->inshiredate,
                            'sal' => $req->inssal,
                            'comm' => $req->inscomm,
                            'deptno' => $deptno,
                        ]);
            return response()->json($insertdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function delete1(Request $req)
    {
        $array = $req->array;

        if (in_array(2, $array)) {
            $deletedata = DB::table('emp')->where('empno', $req->empno)->delete();
            return response()->json($deletedata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function list2(Request $req)
    {
        $array = $req->array;
        $dname = "";
        $dispnum2 = 3;
        $sort2 = 'asc';
        $category2 = "deptno";
        $list2_page = 1;

        $req->session()->put(['dname'=> $dname, 'dispnum2'=> $dispnum2, 'sort2'=> $sort2, 'category2'=> $category2, 'list2_page' => $list2_page]);

        if (in_array(3, $array)) {
            $depte = Dept::orderby($category2, $sort2)->paginate($dispnum2);

            $num = $depte->total();
            if ($num <= $dispnum2) {
                $listsortnum = "true";
            } else {
                $listsortnum = "false";
            }

            $numcount = $num + 1;
            $req->session()->put('numcount', $numcount);

            $data = ['depte' => $depte, 'array' => $array, 'listsortnum' => $listsortnum, 'numcount' => $numcount];
            return view('list2', $data);

        } else {
            return view('dashboard');
        }
    }

    public function edit2(Request $req)
    {
        $array = $req->array;

        if (in_array(4, $array)) {
            $editdata = DB::table('dept')->where('deptno', $req->edid)->update([
                        'deptno' => $req->ed1,
                        'dname' => $req->ed2,
                        'loc' => $req->ed3,
                        'sort' => $req->ed4,
                    ]);
            return response()->json($editdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function insert2(Request $req)
    {
        $array = $req->array;

        if (in_array(4, $array)) {
            $deptno = $req->insdeptno;
            $dname = $req->insdname;
            $loc = $req->insloc;
            $sort = $req->inssort;

            $insertdata = DB::table('dept')->insert([
                            'deptno' => $deptno,
                            'dname' => $dname,
                            'loc' => $loc,
                            'sort' => $sort,
                        ]);

            return response()->json($insertdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function delete2(Request $req)
    {
        $array = $req->array;

        if (in_array(4, $array)) {
            $deletedata = DB::table('dept')->where('deptno', $req->deptid)->delete();

            $numcount = $req->session()->get('numcount') - 1;
            $req->session()->put('numcount', $numcount);

            return response()->json($deletedata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function search1(Request $req)
    {
        $array = $req->array;
        $roles_name = $req->roles_name;
        $ename = $req->ename;
        $minnum = $req->minnum;
        $maxnum = $req->maxnum;
        $dispnum = $req->session()->get('dispnum');
        $category = $req->session()->get('category');
        $sort = $req->session()->get('sort');
        $list1_page = 1;

        $req->session()->put(['ename' => $ename, 'min' => $minnum, 'max' => $maxnum, '$list1_page' => $list1_page]);

        $searchdata = Emp::
            select('emp.id', 'empno', 'ename', 'job', 'mgr', 'hiredate', 'sal', 'comm', 'deptno', 'img1', 'img2', 'roles.name')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->where('ename', 'like', "%$ename%")
            ->where('sal', '>=', $minnum)
            ->where('sal', '<=', $maxnum)->orderby($category, $sort)->paginate($dispnum);

        $dataArray = ['searchdata' => $searchdata, 'array' => $array, 'roles_name' => $roles_name];
        return response()->json($dataArray);
    }

    public function dnamesearch(Request $req)
    {
        $array = $req->array;
        $dname = $req->dname;
        $dispnum2 = $req->session()->get('dispnum2');
        $category2 = $req->session()->get('category2');
        $sort2 = $req->session()->get('sort2');
        $list2_page = 1;

        $req->session()->put(['dname' => $dname, 'list2_page' => $list2_page]);

        $searchdata = Dept::select('*')->where('dname', 'like', "%$dname%")->orderby($category2, $sort2)->paginate($dispnum2);

        $num = $searchdata->total();
        if ($num <= $dispnum2) {
            $listsortnum = "true";
        } else {
            $listsortnum = "false";
        }

        $dataArray = ['searchdata' => $searchdata, 'array' => $array, 'listsortnum' => $listsortnum];

        return response()->json($dataArray);
    }

    public function empcsvd(Request $req) {
        $data = $req->session()->get('ename');
        $min = $req->session()->get('min');
        $max = $req->session()->get('max');
        $category = $req->session()->get('category');
        $sort = $req->session()->get('sort');


        if($data) {
            return response()->streamDownload(
                function () use($data, $min, $max, $category, $sort) {
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
                    'role',
                ]);
                // データ
                $csv =DB::table('emp')->select('*')->where('ename', 'like', '%'.$data.'%')
                                                   ->where('sal', '>=', $min)
                                                   ->where('sal', '<=', $max)->orderby($category, $sort)->get();
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
                        $emp->role,
                    ]);
                }
                fclose($stream);
                },
                'emp.csv',
                [
                    'Content-Type' => 'application/octet-stream',
                ]
            );
        } else if ($min){
            return response()->streamDownload(
                function () use($min, $max, $category, $sort) {
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
                    'role',
                ]);
                // データ
                $csv =DB::table('emp')->select('*')->where('sal', '>=', $min)->where('sal', '<=', $max)->orderby($category, $sort)->get();
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
                        $emp->role,
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
                function () use($category, $sort) {
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
                        'role',
                    ]);
                    // データ
                    $csv =DB::table('emp')->orderby($category, $sort)->get();
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
                            $emp->role,
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
                $role = mb_convert_encoding($row[9], 'UTF-8', 'SJIS');

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
                $role = mb_convert_encoding($row[9], 'UTF-8', 'SJIS');

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
                            'role' => $role,
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
                            'role' => $role,
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
                            'role' => $role,
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
        $data = $req->session()->get('dname');
        $category2 = $req->session()->get('category2');
        $sort2 = $req->session()->get('sort2');

    if($data) {
        return response()->streamDownload(
            function () use($data, $category2, $sort2) {
                // 出力バッファをopen
                $stream = fopen('php://output', 'w');
                // 文字コードをShift-JISに変換
                stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');

                // ヘッダー
                fputcsv($stream, [
                    'deptno',
                    'dname',
                    'loc',
                    'sort',
                ]);
                // データ
                $csv =DB::table('dept')->select('*')->where('dname', 'like', '%'.$data.'%')->orderby($category2, $sort2)->get();
                foreach ($csv as $dept) {
                    fputcsv($stream, [
                        $dept->deptno,
                        $dept->dname,
                        $dept->loc,
                        $dept->sort,
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
            function () use($category2, $sort2) {
                // 出力バッファをopen
                $stream = fopen('php://output', 'w');
                // 文字コードをShift-JISに変換
                stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');

                // ヘッダー
                fputcsv($stream, [
                    'deptno',
                    'dname',
                    'loc',
                    'sort',
                ]);
                // データ
                $csv =DB::table('dept')->orderby($category2, $sort2)->get();
                foreach ($csv as $dept) {
                    fputcsv($stream, [
                        $dept->deptno,
                        $dept->dname,
                        $dept->loc,
                        $dept->sort,
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
                $sort = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');


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

                if (is_string($sort)) {
                } else {
                    $so = 'sort:'.$sort;
                    $valA[] = $so;
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
                $sort = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');


                for ($i = 0; $i < $num; $i++) {
                    if ($check[$i] == $deptno) {
                        //同じdeptnoだった場合は更新。違う場合は何もしない
                        DB::table('dept')->where('deptno', $deptno)->update([
                            'deptno' => $deptno,
                            'dname' => $dname,
                            'loc' => $loc,
                            'sort' => $sort,
                        ]);
                        break;
                    } else if ($check[$i] > $deptno) {
                        //CSVのデータ$deptnoが$check[$i]より小さくなった場合は追加。違う場合は何もしない
                        DB::table('dept')->insert([
                            'deptno' => $deptno,
                            'dname' => $dname,
                            'loc' => $loc,
                            'sort' => $sort,
                        ]);
                        break;
                    } else if ($check[$num-1] < $deptno) {
                        //CSVのデータ$deptnoが登録されている一番大きいdeptnoより大きかった場合は追加
                        DB::table('dept')->insert([
                            'deptno' => $deptno,
                            'dname' => $dname,
                            'loc' => $loc,
                            'sort' => $sort,
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
            $resp = 'ファイルが画像ではありません。<br>対応拡張子(.jpg　.gif　.png)';
            return response()->json($resp); //エラー内容を返す
        }

        $size = getimagesize($_FILES["simg1"]["tmp_name"]);
        $width_size = $size[0]; //画像の横幅
        $height_size = $size[1]; //画像の高さ

        //画像サイズ制限
        if ($width_size > 300 || $height_size > 300) {
            $resp = '画像サイズは300x300までです。';
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
            $resp = 'ファイルが画像ではありません。<br>対応拡張子(.jpg　.gif　.png)';
            return response()->json($resp); //エラー内容を返す
        }

        $size = getimagesize($_FILES["simg2"]["tmp_name"]);
        $width_size = $size[0]; //画像の横幅
        $height_size = $size[1]; //画像の高さ

        //画像サイズ制限
        if ($width_size > 300 || $height_size > 300) {
            $resp = '画像サイズは300x300までです。';
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
        $array = $req->array;

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
        $log_list = "";
        $word = "";
        $day1 = "";
        $day2 = "";
        $dispnum3 = 10;
        $sort3 = 'desc';
        $category3 = "access_time";
        $list3_page = 1;

        $req->session()->put(['log_list'=> $log_list, 'word'=> $word, 'day1'=> $day1, 'day2'=> $day2, 'dispnum3'=> $dispnum3, 'sort3'=> $sort3, 'category3'=> $category3, 'list3_page'=> $list3_page]);

        $logger = UserLog::select('*')
                            ->orderby($category3, $sort3)->paginate($dispnum3);

        $data = ['logger' => $logger];
        return view('log', $data);
    }

    public function logserch(Request $req)
    {
        $log_list = $req->log_list;
        $word = $req->word;
        $day1 = $req->day1;
        $day2 = $req->day2;
        $dispnum3 = $req->session()->get('dispnum3');
        $sort3 = $req->session()->get('sort3');
        $category3 = $req->session()->get('category3');
        $list3_page = 1;
        $req->session()->put('list3_page', $list3_page);

        if (!empty($word)) {
            $req->session()->put('log_list', $log_list);
            $req->session()->put('word', $word);
            $req->session()->forget('day1');
            $req->session()->forget('day2');

            $searchlog = UserLog::select('*')
                            ->where($log_list, 'like', "%$word%")->orderby($category3, $sort3)->paginate($dispnum3);

            $dataArray = ['searchlog' => $searchlog];

            return response()->json($dataArray);
        } else {
            $req->session()->put('log_list', $log_list);
            $req->session()->put('day1', $day1);
            $req->session()->put('day2', $day2);
            $req->session()->forget('word');

            $searchlog = UserLog::select('*')
                            ->where('access_time', '>=', $day1)
                            ->where('access_time', '<=', $day2)->orderby($category3, $sort3)->paginate($dispnum3);

                $dataArray = ['searchlog' => $searchlog];

            return response()->json($dataArray);
        }
    }

    public function logcsvd(Request $req) {
        $log_list = $req->session()->get('log_list');
        $word = $req->session()->get('word');
        $day1 = $req->session()->get('day1');
        $day2 = $req->session()->get('day2');
        $sort3 = $req->session()->get('sort3');
        $category3 = $req->session()->get('category3');

        if($log_list === 'access_time') {
        return response()->streamDownload(
            function () use($day1, $day2, $sort3, $category3) {
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
                $csv =DB::table('user_logs')->select('*')->where('access_time', '>=', $day1)
                                                         ->where('access_time', '<=', $day2)
                                                         ->orderby($category3, $sort3)->get();
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
        } else {
            if (empty($log_list)) {
                $log_list = "user_id";
                $word = "";
            }

        return response()->streamDownload(
            function () use($log_list, $word, $sort3, $category3) {
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
                $csv =DB::table('user_logs')->select('*')->where($log_list, 'like', '%'.$word.'%')
                                                         ->orderby($category3, $sort3)->get();
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
        }
    }

    public static function logdeletion()
    {
        $conditions = DB::table('schedulers')->select('conditions')->where('name', 'log_delete')->get();
        $encode = json_decode(json_encode($conditions), true);
        $array = Arr::flatten($encode);
        $condition = $array[0];

        $limitday = Carbon::today()->subDay($condition);
        DB::table('user_logs')->whereDate('created_at', '<=', $limitday)->delete();
    }

    public function schedule(Request $req)
    {
        $array = $req->array;

        if (in_array(5, $array)) {
            $scheduler = DB::table('schedulers')->get();
            $encode2 = json_decode(json_encode($scheduler), true);
            $array2 = Arr::flatten($encode2);

            $num = $array2[2];
            $interval = $array2[3];
            $interval1 = $array2[4];
            $interval2 = $array2[5];
            $intervalday = $array2[6];
            $intervalhour = $array2[7];
            $conditions = $array2[8];

            $data = ['num' => $num, 'interval' => $interval, 'interval1' => $interval1, 'interval2' => $interval2, 'intervalday' => $intervalday, 'intervalhour' => $intervalhour, 'conditions' => $conditions,];

            return view('schedule', $data);
        } else {
            return redirect(route('dashboard'));
        }
    }

    public function setting1(Request $req)
    {
        $array = $req->array;

        if (in_array(5, $array)) {
            $number1or2 = $req->number1or2;
            $time1 = $req->time1;
            $time2 = $req->time2;
            $time3 = $req->time3;

            $settingdata = DB::table('schedulers')->where('name', 'log_delete')->update([
                            'num' => $number1or2,
                            'interval' => $time1,
                            'interval1' => $time2,
                            'interval2' => $time3,
                            'intervalday' => "",
                            'intervalhour' => "",
                            ]);

            return response()->json($settingdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function setting2(Request $req)
    {
        $array = $req->array;

        if (in_array(5, $array)) {
            $day = $req->day;
            $hour = $req->hour;

            $settingdata = DB::table('schedulers')->where('name', 'log_delete')->update([
                            'num' => "",
                            'interval' => "",
                            'interval1' => "",
                            'interval2' => "",
                            'intervalday' => $day,
                            'intervalhour' => $hour,
                        ]);

            return response()->json($settingdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function setting3(Request $req)
    {
        $array = $req->array;

        if (in_array(5, $array)) {
            $settingdata = DB::table('schedulers')->where('name', 'log_delete')->update([
                            'conditions' => $req->conditions,
                        ]);

            return response()->json($settingdata);
        } else {
            $data = ['alert_message' => '不正な通信です'];
            return response()->json($data);
        }
    }

    public function enamechange(Request $req)
    {
        $enamechange = DB::table('emp')->where('empno', Auth::user()->empno)->update([
                    'ename' => $req->ename,
                ]);
        return response()->json($enamechange);
    }

    public function emailchange(Request $req)
    {
        $mail =  DB::table('emp')->select('email')->get();
        $encode = json_decode(json_encode($mail), true);
        $array = Arr::flatten($encode);

        if (in_array($req->email, $array)) {
            $data = ['message' => 'このメールアドレスは既に使用されています'];
            return response()->json($data);
        } else {
            DB::table('emp')->where('empno', Auth::user()->empno)->update([
                'email' => $req->email,
            ]);
            $data = true;
            return response()->json($data);
        }
    }

    public function address(Request $req)
    {
        $searchaddress = DB::table('addresses')->select('*')->where('zip', 'like', "$req->zip%")->get();
        $encode = json_decode(json_encode($searchaddress), true);

        if(empty($encode)) {
            $searchaddress = ['message' => '存在しない郵便番号です'];
        }
        return response()->json($searchaddress);
    }

    public function numsortchange(Request $req)
    {
        $numlist = $req->numlist;
        $list = explode(',', $numlist);
        $sort = 1;
        for($i= 0; $i < count($list); $i++) {
            DB::table('dept')->where('deptno', $list[$i])->update([
                'sort' => $sort,
            ]);
            $sort++;
        }
        $data = true;
        return response()->json($data);
    }

    public function addresschange(Request $req)
    {
        $data = DB::table('emp')->where('empno', Auth::user()->empno)->update([
                    'post_code' => $req->zip,
                    'address1' => $req->address1,
                    'address2' => $req->address2,
                ]);

        return response()->json($data);
    }

    public function phonechange(Request $req)
    {
        $data = DB::table('emp')->where('empno', Auth::user()->empno)->update([
                    'phone_number' => $req->phone,
                ]);

        return response()->json($data);
    }

    public function list11(Request $req)
    {
        $array = $req->array;
        $roles_name = $req->roles_name;
        $pagenum = $req->i;
        $dispnum = $req->session()->get('dispnum');
        $sort = $req->session()->get('sort');
        $category = $req->session()->get('category');
        $ename = $req->session()->get('ename');
        $min = $req->session()->get('min');
        $max = $req->session()->get('max');
        $list1_page = $req->session()->get('list1_page');

        $count = Emp::
        select('emp.id', 'empno', 'ename', 'job', 'mgr', 'hiredate', 'sal', 'comm', 'deptno', 'img1', 'img2', 'roles.name')
        ->join('roles', 'emp.role', '=', 'roles.id')
        ->where('ename', 'like', "%$ename%")
        ->where('sal', '>=', $min)
        ->where('sal', '<=', $max)
        ->orderby($category, $sort)->count();

        $lastpage = ceil($count / $dispnum);
        $check2 = $lastpage + 1;


        if ($pagenum == 0) {
            $check = $list1_page - 2;
            $pagenum = $list1_page -1;
            $req->session()->put('list1_page', $pagenum);
        } else if($pagenum == $check2) {
            $check = $list1_page;
            $pagenum = $list1_page + 1;
            $req->session()->put('list1_page', $pagenum);
        } else {
            $check = $pagenum - 1;
            $req->session()->put('list1_page', $pagenum);
        }

        $skip = $dispnum * $check;

        $members = Emp::
            select('emp.id', 'empno', 'ename', 'job', 'mgr', 'hiredate', 'sal', 'comm', 'deptno', 'img1', 'img2', 'roles.name')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->where('ename', 'like', "%$ename%")
            ->where('sal', '>=', $min)
            ->where('sal', '<=', $max)
            ->orderby($category, $sort)->offset($skip)->limit($dispnum)->get();

        $dataArray = ['members' => $members, 'array' => $array, 'roles_name' => $roles_name, 'pagenum' => $pagenum];

        return response()->json($dataArray);
    }

    public function list100(Request $req)
    {
        $array = $req->array;
        $roles_name = $req->roles_name;
        $ename = $req->session()->get('ename');
        $min = $req->session()->get('min');
        $max = $req->session()->get('max');
        $category = $req->session()->get('category');
        $sort = $req->session()->get('sort');
        $list1_page = 1;

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
            } else {
                $dispnum = $req->session()->get('dispnum');
            }
        } else if ($sort === '▲') {
            $sort = 'asc';
            if ($req->dispnum) {
                $dispnum = $req->dispnum;
            } else {
                $dispnum = $req->session()->get('dispnum');
            }
        } else {
            if ($req->dispnum) {
                $dispnum = $req->dispnum;
            } else {
                $dispnum = $req->session()->get('dispnum');
            }
        }

            $members = Emp::
            select('emp.id', 'empno', 'ename', 'job', 'mgr', 'hiredate', 'sal', 'comm', 'deptno', 'img1', 'img2', 'roles.name')
            ->join('roles', 'emp.role', '=', 'roles.id')
            ->where('ename', 'like', "%$ename%")
            ->where('sal', '>=', $min)
            ->where('sal', '<=', $max)->orderby($category, $sort)->paginate($dispnum);

        $req->session()->put(['dispnum'=> $dispnum, 'sort' => $sort, 'category' => $category, 'list1_page' => $list1_page]);

        $droplist = DB::table('dept')->select('deptno', 'dname', 'sort')->orderby('sort', 'asc')->get();

        $data = ['members' => $members, 'droplist' => $droplist, 'array' => $array, 'roles_name' => $roles_name];
        return view('list1', $data);
    }

    public function list22(Request $req)
    {
        $array = $req->array;
        $pagenum = $req->i;
        $dispnum2 = $req->session()->get('dispnum2');
        $sort2 = $req->session()->get('sort2');
        $category2 = $req->session()->get('category2');
        $dname = $req->session()->get('dname');
        $list2_page = $req->session()->get('list2_page');

        $count = Dept::select('*')->where('dname', 'like', "%$dname%")
                                    ->orderby($category2, $sort2)->count();

        $lastpage = ceil($count / $dispnum2);
        $check2 = $lastpage + 1;

        if ($pagenum == 0) {
            $check = $list2_page - 2;
            $pagenum = $list2_page -1;
            $req->session()->put('list2_page', $pagenum);
        } else if($pagenum == $check2) {
            $check = $list2_page;
            $pagenum = $list2_page + 1;
            $req->session()->put('list2_page', $pagenum);
        } else {
            $check = $pagenum - 1;
            $req->session()->put('list2_page', $pagenum);
        }

        $skip = $dispnum2 * $check;

        $depte = Dept::select('*')->where('dname', 'like', "%$dname%")
                                    ->orderby($category2, $sort2)->offset($skip)->limit($dispnum2)->get();

        $dataArray = ['depte' => $depte, 'array' => $array, 'pagenum' => $pagenum];

        return response()->json($dataArray);
    }

    public function list200(Request $req)
    {
        $array = $req->array;
        $dname = $req->session()->get('dname');
        $category2 = $req->session()->get('category2');
        $sort2 = $req->session()->get('sort2');
        $numcount = $req->session()->get('numcount');
        $list2_page = 1;

        if ($req->sortdeptno) {
            $sort2 = $req->sortdeptno;
            $category2 = 'deptno';
        }
        if ($req->sortdname) {
            $sort2 = $req->sortdname;
            $category2 = 'dname';
        }
        if ($req->sortloc) {
            $sort2 = $req->sortloc;
            $category2 = 'loc';
        }
        if ($req->sortnum) {
            $sort2 = $req->sortnum;
            $category2 = 'sort';
        }


        if ($sort2 === '▼') {
            $sort2 = 'desc';
            if ($req->dispnum2) {
                $dispnum2 = $req->dispnum2;
            } else {
                $dispnum2 = $req->session()->get('dispnum2');
            }
        } else if ($sort2 === '▲') {
            $sort2 = 'asc';
            if ($req->dispnum2) {
                $dispnum2 = $req->dispnum2;
            } else {
                $dispnum2 = $req->session()->get('dispnum2');
            }
        } else {
            if ($req->dispnum2) {
                $dispnum2 = $req->dispnum2;
            } else {
                $dispnum2 = $req->session()->get('dispnum2');
            }
        }

        $depte = Dept::select('*')->where('dname', 'like', "%$dname%")
                                    ->orderby($category2, $sort2)->paginate($dispnum2);

        $req->session()->put(['dispnum2'=> $dispnum2, 'sort2' => $sort2, 'category2' => $category2, 'list2_page' => $list2_page]);

        $num = $depte->total();
        if ($num <= $dispnum2) {
            $listsortnum = "true";
        } else {
            $listsortnum = "false";
        }

        $data = ['depte' => $depte, 'array' => $array, 'listsortnum' => $listsortnum, 'numcount' => $numcount];
        return view('list2', $data);
    }

    public function log2(Request $req)
    {
        $pagenum = $req->i;
        $dispnum3 = $req->session()->get('dispnum3');
        $sort3 = $req->session()->get('sort3');
        $category3 = $req->session()->get('category3');
        $log_list = $req->session()->get('log_list');
        $word = $req->session()->get('word');
        $day1 = $req->session()->get('day1');
        $day2 = $req->session()->get('day2');
        $list3_page = $req->session()->get('list3_page');

        if (!empty($word)) {
            $count = UserLog::select('*')
                            ->where($log_list, 'like', "%$word%")
                            ->orderby($category3, $sort3)->count();

            $lastpage = ceil($count / $dispnum3);
            $check2 = $lastpage + 1;

            if ($pagenum == 0) {
                $check = $list3_page - 2;
                $pagenum = $list3_page -1;
                $req->session()->put('list3_page', $pagenum);
            } else if($pagenum == $check2) {
                $check = $list3_page;
                $pagenum = $list3_page + 1;
                $req->session()->put('list3_page', $pagenum);
            } else {
                $check = $pagenum - 1;
                $req->session()->put('list3_page', $pagenum);
            }

            $skip = $dispnum3 * $check;

            $searchlog = UserLog::select('*')
                            ->where($log_list, 'like', "%$word%")
                            ->orderby($category3, $sort3)->offset($skip)->limit($dispnum3)->get();

            $dataArray = ['searchlog' => $searchlog, 'pagenum' => $pagenum];

            return response()->json($dataArray);
        } else if ($log_list == 'access_time') {
            $count = UserLog::select('*')
                            ->where('access_time', '>=', $day1)
                            ->where('access_time', '<=', $day2)
                            ->orderby($category3, $sort3)->count();

            $lastpage = ceil($count / $dispnum3);
            $check2 = $lastpage + 1;

            if ($pagenum == 0) {
                $check = $list3_page - 2;
                $pagenum = $list3_page -1;
                $req->session()->put('list3_page', $pagenum);
            } else if($pagenum == $check2) {
                $check = $list3_page;
                $pagenum = $list3_page + 1;
                $req->session()->put('list3_page', $pagenum);
            } else {
                $check = $pagenum - 1;
                $req->session()->put('list3_page', $pagenum);
            }

            $skip = $dispnum3 * $check;

            $searchlog = UserLog::select('*')
                            ->where('access_time', '>=', $day1)
                            ->where('access_time', '<=', $day2)
                            ->orderby($category3, $sort3)->offset($skip)->limit($dispnum3)->get();

            $dataArray = ['searchlog' => $searchlog, 'pagenum' => $pagenum];

            return response()->json($dataArray);
        } else {
            $count = UserLog::select('*')
                            ->orderby($category3, $sort3)->count();

            $lastpage = ceil($count / $dispnum3);
            $check2 = $lastpage + 1;

            if ($pagenum == 0) {
                $check = $list3_page - 2;
                $pagenum = $list3_page -1;
                $req->session()->put('list3_page', $pagenum);
            } else if($pagenum == $check2) {
                $check = $list3_page;
                $pagenum = $list3_page + 1;
                $req->session()->put('list3_page', $pagenum);
            } else {
                $check = $pagenum - 1;
                $req->session()->put('list3_page', $pagenum);
            }

            $skip = $dispnum3 * $check;

            $searchlog = UserLog::select('*')
                            ->orderby($category3, $sort3)->offset($skip)->limit($dispnum3)->get();

            $dataArray = ['searchlog' => $searchlog, 'pagenum' => $pagenum];

            return response()->json($dataArray);
        }
    }

    public function logsort(Request $req)
    {
        $log_list = $req->session()->get('log_list');
        $word = $req->session()->get('word');
        $day1 = $req->session()->get('day1');
        $day2 = $req->session()->get('day2');
        $category3 = $req->session()->get('category3');
        $sort3 = $req->session()->get('sort3');
        $list3_page = 1;

        if ($req->sortaccess_time) {
            $sort3 = $req->sortaccess_time;
            $category3 = 'access_time';
        }
        if ($req->sortid) {
            $sort3 = $req->sortid;
            $category3 = 'user_id';
        }
        if ($req->sortip) {
            $sort3 = $req->sortip;
            $category3 = 'ip_address';
        }
        if ($req->sortagent) {
            $sort3 = $req->sortagent;
            $category3 = 'user_agent';
        }
        if ($req->sortsession) {
            $sort3 = $req->sortsession;
            $category3 = 'session_id';
        }
        if ($req->sorturl) {
            $sort3 = $req->sorturl;
            $category3 = 'access_url';
        }
        if ($req->sortoperation) {
            $sort3 = $req->sortoperation;
            $category3 = 'operation';
        }


        if ($sort3 === '▲') {
            $sort3 = 'asc';
            if ($req->dispnum3) {
                $dispnum3 = $req->dispnum3;
            } else {
                $dispnum3 = $req->session()->get('dispnum3');
            }
        } else if ($sort3 === '▼') {
            $sort3 = 'desc';
            if ($req->dispnum3) {
                $dispnum3 = $req->dispnum3;
            } else {
                $dispnum3 = $req->session()->get('dispnum3');
            }
        } else {
            if ($req->dispnum3) {
                $dispnum3 = $req->dispnum3;
            } else {
                $dispnum3 = $req->session()->get('dispnum3');
            }
        }

        if ($word) {
            $logger = UserLog::select('*')
                            ->where($log_list, 'like', "%$word%")->orderby($category3, $sort3)->paginate($dispnum3);

            $req->session()->put(['dispnum3'=> $dispnum3, 'sort3' => $sort3, 'category3' => $category3, 'list3_page' => $list3_page]);

            $data = ['logger' => $logger];

            return view('log', $data);
        } else if ($log_list == 'access_time') {
            $logger = UserLog::select('*')
                            ->where('access_time', '>=', $day1)
                            ->where('access_time', '<=', $day2)->orderby($category3, $sort3)->paginate($dispnum3);

            $req->session()->put(['dispnum3'=> $dispnum3, 'sort3' => $sort3, 'category3' => $category3, 'list3_page' => $list3_page]);

            $data = ['logger' => $logger];

            return view('log', $data);
        } else {
            $logger = UserLog::select('*')
                            ->orderby($category3, $sort3)->paginate($dispnum3);

            $req->session()->put(['dispnum3'=> $dispnum3, 'sort3' => $sort3, 'category3' => $category3, 'list3_page' => $list3_page]);

            $data = ['logger' => $logger];

            return view('log', $data);
        }
    }

    // public function list2all(Request $req)
    // {
    //     $array = $req->array;
    //     $numcount = $req->session()->get('numcount');

    //     if (in_array(3, $array)) {
    //         $depte = Dept::orderby('sort', 'asc')->paginate($numcount);

    //         $num = $depte->total();
    //         if ($num < $numcount) {
    //             $listsortnum = "true";
    //         } else {
    //             $listsortnum = "false";
    //         }

    //         $req->session()->get('dispnum', $numcount);

    //         $data = ['depte' => $depte, 'array' => $array, 'listsortnum' => $listsortnum, 'numcount' => $numcount];
    //         return view('list2', $data);

    //     } else {
    //         return view('dashboard');
    //     }
    // }






    public function aaa(Request $req)
    {
        $members = Emp::
            select('id', 'empno', 'ename')
            ->where('empno', 1001)->get();

        // dd($members);
        return response()->json($members);
    }
}
