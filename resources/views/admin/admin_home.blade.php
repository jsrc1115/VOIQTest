<!-- resources/views/auth/login.blade.php -->
<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Users</title>

    <script src="{{ elixir("js/vendor.js") }}"></script>
    <script src="{{ elixir("js/app.js") }}"></script>

    <link rel="stylesheet" href="{{ elixir("css/app.css") }}">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Admin User</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">Edit users <span class="sr-only">(current)</span></a></li>
                <li><a href="/admin/create_user">Create user</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/auth/logout">Logout</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<table class="table table-hover">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Options</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a href="/admin/update_user/{{$user->id}}" class="btn btn-warning btn-xs" role="button">Edit</a>
                <a href="/admin/delete_user/{{$user->id}}" class="btn btn-danger btn-xs" role="button">Delete</a>
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>