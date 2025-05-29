<!DOCTYPE html>
<html>

<head>
    <title>Create AAP Raffle Entry</title>
    <script>
    function setParticipant(type) {
        if (type === 'members') {
            document.getElementById('ar_members').value = 1;
            document.getElementById('ar_attendees').value = 0;
        } else {
            document.getElementById('ar_members').value = 0;
            document.getElementById('ar_attendees').value = 1;
        }
    }
    </script>
</head>

<body>
    <h1>Create AAP Raffle Entry</h1>

    @if (session('success'))
    <p style="color: green">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('aap_raffles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Branch ID (optional):</label>
        <input type="number" name="branch_id"><br><br>

        <label>Category (ar_cat) (optional):</label>
        <input type="number" name="ar_cat"><br><br>

        <label>Participants:</label><br>
        <input type="radio" name="participant_type" value="members" onclick="setParticipant('members')" checked>
        Members<br>
        <input type="radio" name="participant_type" value="attendees" onclick="setParticipant('attendees')">
        Attendees<br><br>

        <input type="hidden" id="ar_members" name="ar_members" value="1">
        <input type="hidden" id="ar_attendees" name="ar_attendees" value="0">

        <label>Prize Name (ar_nameprize):</label>
        <input type="text" name="ar_nameprize" required><br><br>

        <label>Prize Title (ar_nameprizet) (optional):</label>
        <input type="text" name="ar_nameprizet"><br><br>

        <label>Number of Prizes (ar_noprize):</label>
        <input type="number" name="ar_noprize" required><br><br>

        <label>Number of Attendees (ar_noattendees):</label>
        <input type="number" name="ar_noattendees" required><br><br>

        <label>Date (ar_date):</label>
        <input type="date" name="ar_date" required><br><br>

        <label>Order (ar_order):</label>
        <input type="number" name="ar_order" min="0" max="99" required><br><br>

        <label>Raffle Image:</label>
        <input type="file" name="raffle_image" accept="image/*" required><br><br>

        <button type="submit">Submit Raffle</button>
    </form>
</body>

</html>