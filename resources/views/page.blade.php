@extends('layouts.master')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <h2>{{$name}}</h2>
    <p>This is my body content.</p>
    
    <h2>If statement...</h2>
    @if ($day == "Friday")
     <p>time to partay!</p>
    @else
        <p>Time to make money</p>
    @endif
    
    <h2>A foreach loop in blade</h2>
    @foreach($drinks as $drink)
        {{$drink}}<br />
    @endforeach
    
    <h2>Example execute PHP function</h2>
    <p>PHP date function exec here: {{date('D M Y')}}</p>
@endsection