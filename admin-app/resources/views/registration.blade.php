<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <form action="{{ $url }}" method="post">
        @csrf
        <!-- <pre>
        @php
            print_r($errors->all());
        @endphp -->
        <div class="mb-3">
            <label class="name">Name:</label>
            <input type="text" name="name" id="name" value="{{old('name')}}">
        </div>

        <div class="mb-3">
            <label class="age">Age:</label>
            <input type="number" name="age" id=""age value="{{old('age')}}">
        </div>

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