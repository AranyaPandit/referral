@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>User Investments</h2>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>Referral Commissions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($investments as $investment)
            <tr>
                <td>{{ $investment->user->name }}</td>
                <td>${{ number_format($investment->amount, 2) }}</td>
                <td>{{ $investment->status }}</td>
                <td>{{ $investment->created_at->format('Y-m-d') }}</td>
                <td>
                    @foreach($investment->referralEarnings as $earning)
                        <span class="badge bg-success">{{ $earning->user->name }} - ${{ number_format($earning->commission_amount, 2) }}</span>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
