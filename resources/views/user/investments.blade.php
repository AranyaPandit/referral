@extends('layouts.user')

@section('content')
<div class="container">
    <h2>My Investments</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>Referral Earnings</th>
            </tr>
        </thead>
        <tbody>
            @foreach($investments as $investment)
            <tr>
                <td>${{ number_format($investment->amount, 2) }}</td>
                <td>{{ $investment->status }}</td>
                <td>{{ $investment->created_at->format('Y-m-d') }}</td>
                <td>
                    @foreach($investment->referralEarnings as $earning)
                        <span class="badge bg-primary">${{ number_format($earning->commission_amount, 2) }} from {{ $earning->referredUser->name }}</span>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
