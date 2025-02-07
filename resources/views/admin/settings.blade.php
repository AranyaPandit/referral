@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Global Settings</h2>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Commission Percentage (%)</label>
            <input type="number" name="commission_percentage" class="form-control" value="{{ $commission_percentage }}" min="1" max="100" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Max Commission Per User</label>
            <input type="number" name="max_commission_per_user" class="form-control" value="{{ $max_commission_per_user }}" min="1" max="50" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>
</div>
@endsection
