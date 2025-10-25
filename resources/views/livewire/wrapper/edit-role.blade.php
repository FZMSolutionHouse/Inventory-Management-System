@extends('layouts.adminmaster')

@section('content')
    <livewire:role-edit-controller :roleId="$role->id" />
@endsection