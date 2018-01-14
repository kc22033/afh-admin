@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container" style="width:90%">
    <div class="row">
        <div class="col-md-12">
            <afh-animal-edit :edit_id="{{json_encode($id)}}" :edit-mode="Edit"></afh-animal-edit>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection