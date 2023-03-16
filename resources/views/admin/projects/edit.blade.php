@extends('layouts.main')

@section('title', 'Edit ' . $project['name'])

@section('content')

@include('includes.projects.form')
@endsection