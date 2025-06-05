<div>
    <h1>{{ $meeting->membership->name }}</h1>
    <h2>{{ $meeting->title }} vom {{ $meeting->date->format('d.m.Y') }}</h2>
    <h2>Teilnehmer:</h2>
    <p>{{ $meeting->participants->map(fn($participant) => $participant->user->full_name)->implode(', ') }}</p>

    <h2>Protokoll</h2>
    {!!   $meeting->protocol !!}
</div>
