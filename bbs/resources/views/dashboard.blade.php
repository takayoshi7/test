@extends('layouts.app2')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('マイページ') }}
        </h2>
    </x-slot>

    <h1>{{ Auth::user()->ename }}さんようこそ</h1>
    <br>
    <div>
        @if (!is_null(Auth::user()->img1))
        <img src="data:image/png;base64,{{ Auth::user()->img1 }}" height="100px">
        <button type="button" class="img1" onclick="img1func({{ Auth::user()->empno }})">変更</button>
        <button type="button" class="imgdelete1" value="{{ Auth::user()->empno }}">削除</button>
        @else
        <img src="{{ \Storage::url('img/no_image.jpg') }}" height="100px">
        <button type="button" class="img1" onclick="img1func({{ Auth::user()->empno }})">変更</button>
        @endif

        @if (!is_null(Auth::user()->img2))
        <img src="{{ \Storage::url('img/'.Auth::user()->img2) }}" height="100px">
        <button type="button" class="img2" onclick="img2func({{ Auth::user()->empno }})">変更</button>
        <button type="button" class="imgdelete2" value="{{ Auth::user()->empno }}">削除</button>
        @else
        <img src="{{ \Storage::url('img/no_image.jpg') }}" height="100px">
        <button type="button" class="img2" onclick="img2func({{ Auth::user()->empno }})">変更</button>
        @endif
    </div>


    <div id="select_img1">
        <form method="POST" enctype="multipart/form-data"  id="img1_form">
        @csrf
        <input type="hidden" id="dialog_empno">
        <input type="file" accept="image/*" id="simg1" name="simg1" class="form-control">
        <br><br>
        <button type="button" id="inimg1">アップロード</button>
        <br>
        <div id="img1error"></div>
        </form>
    </div>

    <div id="select_img2">
        <form method="POST" enctype="multipart/form-data"  id="img2_form">
        @csrf
        <input type="hidden" id="dialog_empno">
        <input type="file" accept="image/*" id="simg2" name="simg2" class="form-control">
        <br><br>
        <button type="button" id="inimg2">アップロード</button>
        <br>
        <div id="img2error"></div>
        </form>
    </div>
</x-app-layout>
