@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Remarks
    </div>
    <div class="card-body">
        <ul>
            @foreach ($remarks as $remark)
                <li>
                    User: {{ $remark->assignedTo->name }}<br>
                    Remarks: {{ $remark->remarks }}<br>  
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
