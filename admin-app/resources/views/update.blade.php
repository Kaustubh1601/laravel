<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>
<body>
<form method="POST" action="/user/profile">
    @csrf
    @method('PUT') <!-- This indicates the request is a PUT method -->
    
    <label for="name">First Name:</label>
    <input type="text" name="fname" value="{{ Auth::user()->fname }}" required>

    <label for="name">Last Name:</label>
    <input type="text" name="lname" value="{{ Auth::user()->lname }}" required>

    <label for="email">Email:</label>
    <input type="email" name="email" value="{{ Auth::user()->email }}" required>

    <label for="name">Date of Birth:</label>
    <input type="date" name="dob" value="{{ Auth::user()->dob }}" required>

    <button type="submit">Update Profile</button>
</form>

</body>
</html>