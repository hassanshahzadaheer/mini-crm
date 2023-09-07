@extends('layouts.app')

@section('content')
  <main class="py-4">

  <edit-company-form :company-id="{{ $company->id }}"></edit-company-form>
</main>

@endsection
