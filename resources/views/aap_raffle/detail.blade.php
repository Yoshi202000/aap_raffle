<!-- resources/views/aap_raffle/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Raffle Details</h2>
                    <div>
                        <a href="{{ route('aap_raffles.edit', $aap_raffle->ar_id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('aap_raffles.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4 text-center">
                                @if($aap_raffle->raffle_image)
                                <img src="{{ asset($aap_raffle->raffle_image) }}" alt="{{ $aap_raffle->ar_nameprize }}"
                                    class="img-fluid rounded" style="max-height: 300px;">
                                @else
                                <div class="alert alert-info">No image available</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h3 class="mb-3">{{ $aap_raffle->ar_nameprize }}</h3>

                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 40%">Raffle ID:</th>
                                    <td>{{ $aap_raffle->ar_id }}</td>
                                </tr>
                                <tr>
                                    <th>Prize Type:</th>
                                    <td>{{ $aap_raffle->ar_nameprizet ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Number of Prizes:</th>
                                    <td>{{ $aap_raffle->ar_noprize }}</td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>{{ \Carbon\Carbon::parse($aap_raffle->ar_date)->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Display Order:</th>
                                    <td>{{ $aap_raffle->ar_order }}</td>
                                </tr>
                                <tr>
                                    <th>Branch ID:</th>
                                    <td>{{ $aap_raffle->branch_id ?: 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4>Additional Information</h4>
                            <table class="table table-striped">
                                <tr>
                                    <th style="width: 25%">Category:</th>
                                    <td>{{ $aap_raffle->ar_cat ?: 'N/A' }}</td>
                                    <th style="width: 25%">Members:</th>
                                    <td>{{ $aap_raffle->ar_members ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Attendees Type:</th>
                                    <td>{{ $aap_raffle->ar_attendees ?: 'N/A' }}</td>
                                    <th>Number of Attendees:</th>
                                    <td>{{ $aap_raffle->ar_noattendees ?: 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-between">
                            <form action="{{ route('aap_raffles.destroy', $aap_raffle->ar_id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this raffle?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Raffle</button>
                            </form>

                            <div>
                                <a href="{{ route('aap_raffles.edit', $aap_raffle->ar_id) }}"
                                    class="btn btn-primary">Edit Raffle</a>
                                <a href="{{ route('aap_raffles.index') }}" class="btn btn-secondary">Back to List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection