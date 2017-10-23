@extends('layouts.app')

@section('styles')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
 -->
 <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection