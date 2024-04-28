@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{ \Carbon\Carbon::parse($date)->format('Y年m月d日') }}</span><span class="ml-3">{{ $part }}部</span></p>
    <div class="h-75 border">
      <table class="w-100">
        <thead>
          <tr class="text-center">
            <th class="w-50">ID</th>
            <th class="w-50">名前</th>
            <th class="w-50">場所</th>
          </tr>
        </thead>
        <tbody>
          @foreach($reservePersons as $reservation)
            @foreach($reservation->users as $user)
              <tr class="text-center">
                <td>{{ $user->id }}</td>
                <td>{{ $user->over_name }} {{ $user->under_name }}</td>
                <td>リモート</td>
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
