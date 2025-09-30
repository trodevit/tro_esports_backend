@extends('layouts.app')

@section('page_title','Contacts')

@section('content')
    <div class="container my-4">
        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-body-tertiary border-0 d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Contacts</h5>
                {{-- Optional actions can go here --}}
            </div>

            <div class="card-body">
                @if($contacts->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width:64px;">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th class="d-none d-md-table-cell" style="width:160px;">Received</th>
                                <th class="text-end" style="width:160px;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contacts as $i => $contact)
                                <tr>
                                    {{-- Index (works with or without pagination) --}}
                                    <td>
                                        {{ ($contacts instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                            ? $contacts->firstItem() + $i
                                            : $loop->iteration }}
                                    </td>

                                    <td class="fw-semibold">{{ $contact->name }}</td>

                                    <td>
                                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                    </td>

                                    <td>
                                        {{-- Truncate long text but keep full content in title tooltip --}}
                                        <span class="d-inline-block text-truncate" style="max-width: 320px;" title="{{ $contact->msg }}">
                                          {{ $contact->msg }}
                                        </span>
                                    </td>

                                    <td class="d-none d-md-table-cell">
                                        <span class="text-muted"
                                              title="{{ optional($contact->created_at)->toDayDateTimeString() }}">
                                          {{ optional($contact->created_at)->diffForHumans() }}
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            @isset($contact->id)
                                                <a href="#" class="btn btn-outline-primary">View</a>
                                            @endisset
                                            <a href="mailto:{{ $contact->email }}" class="btn btn-outline-secondary">Email</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination (shown only if paginator) --}}
                    @if($contacts instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="pt-3">
                            {{ $contacts->withQueryString()->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center text-muted py-5">
                        No contacts found.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
