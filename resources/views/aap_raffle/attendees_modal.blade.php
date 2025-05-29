<!-- resources/views/aap_raffle/attendees_modal.blade.php -->

<!-- Attendees Raffle Modal -->
<div class="modal fade" id="attendeesRaffleModal" tabindex="-1" aria-labelledby="attendeesRaffleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('aap_raffles.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ar_members" value="0">
                <input type="hidden" name="ar_attendees" value="1">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendeesRaffleModalLabel">Create Attendee Raffle Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ar_nameprize" class="form-label">Prize Name</label>
                        <input type="text" class="form-control" name="ar_nameprize" required>
                    </div>

                    <div class="mb-3">
                        <label for="ar_noprize" class="form-label">Number of Prizes</label>
                        <input type="number" class="form-control" name="ar_noprize" required>
                    </div>

                    <div class="mb-3">
                        <label for="ar_order" class="form-label">Order</label>
                        <input type="number" class="form-control" name="ar_order" required>
                    </div>

                    <div class="mb-3">
                        <label for="raffle_image" class="form-label">Raffle Image</label>
                        <input type="file" class="form-control" name="raffle_image" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Raffle</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
// Function to set the next order number in the modal
function setNextOrderNumber(tableId) {
    const nextOrder = getNextOrderNumber(tableId);
    const modalId = '#attendeesRaffleModal';

    // Set the value in the modal
    document.querySelector(`${modalId} input[name="ar_order"]`).value = nextOrder;

    // Set the ar_members value based on which table is being used
    if (tableId === 'members-tbody') {
        document.querySelector(`${modalId} input[name="ar_members"]`).value = "1";
        document.querySelector(`${modalId} .modal-title`).textContent = "Create Members Raffle Entry";
    } else {
        document.querySelector(`${modalId} input[name="ar_members"]`).value = "0";
        document.querySelector(`${modalId} .modal-title`).textContent = "Create Attendees Raffle Entry";
    }
}
</script>