@if(!is_null(Auth::user()->ename))
{{ Auth::user()->ename }}さん
@else
{{ Auth::user()->empno }}さん
@endif
<br>
<p>メールアドレスを変更致しました。</p>
<p>下記、新しいメールアドレスになります。</p>
ーーーーーーーー
<p>{{ $email }}</P>
ーーーーーーーー
