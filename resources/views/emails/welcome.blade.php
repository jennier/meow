<p>Hello {{ $user['name'] }}</p>
<p>Welcome to MEOW, the Cut Cat's Courier internal server guy where you can do stuff like vote on ballots and read all about operating protocols that whoever trained you forgot to mention and get important updates you missed when you didn't read your emails.</p>

<p>Login by visiting {{ url('/auth/login') }}. Your username is <b>{{ $user['name'] }}</b> and your password is <b>{{ $user['password_show'] }}</b>. Probably a good idea to change it once you've logged in!</p>

<p>Thanks,<br>
- Cut Cats Courier HR</p>