<!DOCTYPE html>

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>顧客一覧</title>
</head>
<body>

```
<h1>顧客一覧</h1>

<a href="{{ route('customers.create') }}">
    新規登録
</a>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>名前</th>
            <th>Email</th>
            <th>電話番号</th>
            <th>会社名</th>
            <th>操作</th>
        </tr>
    </thead>

    <tbody>
        @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->company }}</td>
    
                <td>
                    <a href="{{ route('customers.edit', $customer->id) }}">
                        編集
                    </a>
    
                    <form
                        action="{{ route('customers.destroy', $customer->id) }}"
                        method="POST"
                        style="display:inline;"
                        onsubmit="return confirm('本当に削除しますか？')"
                    >
                        @csrf
                        @method('DELETE')
    
                        <button type="submit">
                            削除
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
```

</body>
</html>
