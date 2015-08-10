<!-- resources/views/auth/login.blade.php -->
<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>

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
            <a class="navbar-brand" href="#">Contacts User</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">Edit contacts <span class="sr-only">(current)</span></a></li>
                <li><a href="/contacts/create_contact">Create contact</a></li>
                <li><a href="/contacts/import_contacts">Upload contact list</a></li>
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
        <th>Emails</th>
        <th>Phone Numbers</th>
        <th>Options</th>
    </tr>
@foreach($contacts as $contact)
    <tr>
        <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
        <td>
            @foreach($contact->emails as $email)
                <ul>
                @if($email->primary)
                    <li><b>{{$email->email}}</b></li>
                @else
                    <li>{{$email->email}}</li>
                @endif
                </ul>
            @endforeach
        </td>
        <td>
            @foreach($contact->phoneNumbers as $number)
                <ul>
                    {{$number->phone_number}}
                </ul>
            @endforeach
        </td>
        <td>
            <a href="/contacts/delete_contact/{{$contact->id}}" class="btn btn-danger btn-xs" role="button">Delete</a>
        </td>
    </tr>
@endforeach
</table>
</body>
</html>