<p>Cats,<p>

<p>{{ $ballot->email }}</p>

<p>Link to the ballot: <a href="{{ route('ballots.show', ['id' => $ballot->id]) }}"> {{ $ballot->name }} </a></p>

<p>- {{ $ballot->owner->name }}</p>

<p>P.S. if you're having issues logging in to MEOW or with anything else, please text or email Jennie at jennieruff@gmail.com.</p>