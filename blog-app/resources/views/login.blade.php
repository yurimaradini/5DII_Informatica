@if(isset($_POST['email']) && isset($_POST['pw']))
    @php
        return redirect()->route('login-check'/*, ['id' => 1]*/);
        //header("Location: " . URL::to('/'), true, 302);
        exit();
    @endphp
@else
<form action="login-check" method="POST">
    @csrf
    <label for="email">Email</label>
    <input id="email" name="email" type="email" required>

    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>

    <button type="submit">LOG IN</button>
</form>
@endif
