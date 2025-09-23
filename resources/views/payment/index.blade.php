{{-- resources/views/payments/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Payments</h1>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Game Username</th>
                            <th>Payment Number</th>
                            <th>Method</th>
                            <th>Email</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Transaction ID</th>
                            <th>Date & Time</th>
                            <th>Match</th>
                            <th>Order ID</th>
                            <th>Partners</th>
                            <th>Created</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($payments as $index => $p)
                            <tr>
                                <td>{{ $payments->firstItem() + $index }}</td>
                                <td>{{ $p->user_id }}</td>
                                <td>{{ $p->game_username }}</td>
                                <td>{{ $p->payment_number }}</td>
                                <td>{{ strtoupper($p->method) }}</td>
                                <td>{{ $p->email }}</td>
                                <td>{{ number_format((float)$p->amount, 2) }}</td>
                                <td>
                                    @php
                                        // style badge by status
                                        $badge = match (strtolower((string)$p->status)) {
                                            'paid','success','completed' => 'bg-success',
                                            'pending','processing'       => 'bg-warning',
                                            'failed','cancelled'         => 'bg-danger',
                                            default                      => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $p->status }}</span>
                                </td>
                                <td>{{ $p->transaction_id }}</td>
                                <td>
                                    {{-- If your DB stores separate date & time strings --}}
                                    {{ $p->date }} {{ $p->time }}
                                </td>
                                <td>
                                    {{ $p->match_name }}
                                    @if($p->match_id)
                                        <small class="text-muted d-block">ID: {{ $p->match_id }}</small>
                                    @endif
                                </td>
                                <td>{{ $p->orderId }}</td>
                                <td>
                                    @php
                                        // partners_name is cast to array in the model:
                                        // protected $casts = ['partners_name' => 'array'];
                                        $partners = is_array($p->partners_name) ? $p->partners_name : [];
                                    @endphp
                                    {{ implode(', ', array_filter($partners)) ?: '—' }}
                                </td>
                                <td>{{ optional($p->created_at)->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center py-4">No payments found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($payments->hasPages())
                <div class="card-footer">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
