<!DOCTYPE html>

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>顧客登録</title>
</head>
<body>

<h1>顧客登録</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('customers.store') }}" method="POST">
    @csrf

```
<div>
    <label>名前</label><br>
    <input
        type="text"
        name="name"
        value="{{ old('name') }}"
    >
</div>

<br>

<div>
    <label>Email</label><br>
    <input
        type="email"
        name="email"
        value="{{ old('email') }}"
    >
</div>

<br>

<div>
    <label>電話番号</label><br>
    <input
        type="text"
        name="phone"
        value="{{ old('phone') }}"
    >
</div>

<br>

<div>
    <label>会社名</label><br>
    <input
        type="text"
        name="company"
        value="{{ old('company') }}"
    >
</div>

<br>

<button type="submit">
    登録
</button>
```

</form>

<br>

<a href="{{ route('customers.index') }}">
    一覧へ戻る
</a>

</body>
</html>
