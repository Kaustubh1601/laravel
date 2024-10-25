<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My peers</title>
</head>
<body>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>E-mail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user )
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->age}}</td>
                    <td>{{$user->email}}</td>
                    
                    <td>
                        <a href ="{{url('/user/delete/')}}/{{$user->user_id}}">
                            <button class="btn btn-danger">Delete</button>
                        </a>
                    </td>
                    <td>
                        <a href="{{url('/user/edit/')}}/{{$user->user_id}}">
                            <button class="btn">Edit</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</body>
</html>