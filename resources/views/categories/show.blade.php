<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
    <title>{{ config('app.name') }}</title>
</head>

<body>
    <div class="container">
        <h1 class="mb-3"> {{ $title1 ?? 'category Show '}}</h1>
        <div class="table-responsive">
            <table class = "table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent Id</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        </a>
                        <td>{{ $category->id }}</td>
                        <td><a href="{{ $category->id }}">{{ $category->name }}</a></td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->parent_id }}</td>
                        <td>{{ $category->created_at }}</td>
                    </tr>
                </tbody>
        </div>
    </div>
    </table>
</body>

</html>
