<!-- resources/views/aap_raffle/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Raffle: {{ $aap_raffle->ar_nameprize }}</h2>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('aap_raffles.update', $aap_raffle->ar_id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ar_nameprize" class="form-label">Prize Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('ar_nameprize') is-invalid @enderror" id="ar_nameprize" name="ar_nameprize" value="{{ old('ar_nameprize', $aap_raffle->ar_nameprize) }}" required>
                                @error('ar_nameprize')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                          
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="ar_noprize" class="form-label">Number of Prizes <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('ar_noprize') is-invalid @enderror" id="ar_noprize" name="ar_noprize" value="{{ old('ar_noprize', $aap_raffle->ar_noprize) }}" required min="1">
                                @error('ar_noprize')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="ar_date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('ar_date') is-invalid @enderror" id="ar_date" name="ar_date" value="{{ old('ar_date', $aap_raffle->ar_date) }}" required>
                                @error('ar_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="ar_order" class="form-label">Display Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('ar_order') is-invalid @enderror" id="ar_order" name="ar_order" value="{{ old('ar_order', $aap_raffle->ar_order) }}" required min="0" max="255">
                                @error('ar_order')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="branch_id" class="form-label">Branch ID</label>
                                <input type="number" class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id" value="{{ old('branch_id', $aap_raffle->branch_id) }}">
                                @error('branch_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="ar_cat" class="form-label">Category</label>
                                <input type="number" class="form-control @error('ar_cat') is-invalid @enderror" id="ar_cat" name="ar_cat" value="{{ old('ar_cat', $aap_raffle->ar_cat) }}">
                                @error('ar_cat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Participant Type</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="participant_type" id="members_radio" value="members" 
                                            {{ (old('participant_type') == 'members' || ($aap_raffle->ar_members == 1 && $aap_raffle->ar_attendees == 0)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="members_radio">Members</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="participant_type" id="attendees_radio" value="attendees" 
                                            {{ (old('participant_type') == 'attendees' || ($aap_raffle->ar_members == 0 && $aap_raffle->ar_attendees == 1)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="attendees_radio">Attendees</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="participant_type" id="none_radio" value="none" 
                                            {{ (old('participant_type') == 'none' || ($aap_raffle->ar_members == 0 && $aap_raffle->ar_attendees == 0)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="none_radio">None</label>
                                    </div>
                                </div>
                                
                                <!-- Hidden fields to store the actual values -->
                                <input type="hidden" name="ar_members" id="ar_members_hidden" value="{{ old('ar_members', $aap_raffle->ar_members) }}">
                                <input type="hidden" name="ar_attendees" id="ar_attendees_hidden" value="{{ old('ar_attendees', $aap_raffle->ar_attendees) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ar_noattendees" class="form-label">Number of Attendees</label>
                                <input type="number" class="form-control @error('ar_noattendees') is-invalid @enderror" id="ar_noattendees" name="ar_noattendees" value="{{ old('ar_noattendees', $aap_raffle->ar_noattendees) }}">
                                @error('ar_noattendees')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="raffle_image" class="form-label">Raffle Image</label>
                                <input type="file" class="form-control @error('raffle_image') is-invalid @enderror" id="raffle_image" name="raffle_image">
                                @error('raffle_image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                
                                @if($aap_raffle->raffle_image)
                                    <div class="mt-2">
                                        <p>Current Image:</p>
                                        <img src="{{ asset($aap_raffle->raffle_image) }}" alt="Raffle Image" class="img-thumbnail" style="max-height: 100px;">
                                        <p class="text-muted small">Upload a new image to replace this one.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update Raffle</button>
                                <a href="{{ route('aap_raffles.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Set the hidden fields based on the selected radio button
    document.addEventListener('DOMContentLoaded', function() {
        const participantRadios = document.querySelectorAll('input[name="participant_type"]');
        const membersHidden = document.getElementById('ar_members_hidden');
        const attendeesHidden = document.getElementById('ar_attendees_hidden');

        // Update hidden fields when form is submitted
        const updateHiddenFields = function() {
            const selectedValue = document.querySelector('input[name="participant_type"]:checked').value;
            
            if (selectedValue === 'members') {
                membersHidden.value = 1;
                attendeesHidden.value = 0;
            } else if (selectedValue === 'attendees') {
                membersHidden.value = 0;
                attendeesHidden.value = 1;
            } else {
                membersHidden.value = 0;
                attendeesHidden.value = 0;
            }
        };

        // Add change event listener to radio buttons
        participantRadios.forEach(function(radio) {
            radio.addEventListener('change', updateHiddenFields);
        });

        // Add submit event listener to the form
        document.querySelector('form').addEventListener('submit', updateHiddenFields);
    });
</script>
@endsection