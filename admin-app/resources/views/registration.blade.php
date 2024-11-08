<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <form action="{{ $url? $url: ('/register') }}" method="post">
        @csrf
        <!-- <pre>
            {{ url('/register') }}
            $url? $url: 'register'
        @php
            print_r($errors->all());
        @endphp -->
        <div class="mb-3">
            <label class="name">First Name:</label>
            <input type="text" name="fname" id="fname" value="{{old('fname')}}">
        </div>

        <div class="mb-3">
            <label class="name">Last Name:</label>
            <input type="text" name="lname" id="lname" value="{{old('lname')}}">
        </div>

        <!-- <div class="mb-3">
            <label class="age">Age:</label>
            <input type="number" name="age" id=""age value="{{old('age')}}">
        </div> -->

        <div class="mb-3">
            <label class="email">E-mail:</label>
            <input type="email" name="email" id="email" value="{{old('email')}}">
        </div>
            @error('email')
            <p class='text-danger inputerror'>{{ $message }} </p>
            @enderror

        <div class="mb-3">
            <label class="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
            @error('password')
            <p class='text-danger inputerror'>{{ $message }} </p>
            @enderror

        <div class="md-3">
            <label class="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
        </div>
            @error('password_confirmation')
            <p class='text-danger inputerror'>{{ $message }} </p>
            @enderror

        <button type="submit" class="btn bg-gradient-dark">Submit</button>
    </form>
</body>
</html>