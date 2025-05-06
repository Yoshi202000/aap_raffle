<!DOCTYPE html>
<html>
<head>
    <title>Raffle Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Raffle Details</h2>
            </div>
            <div class="card-body">
                <h3>{{ $aap_raffle->ar_nameprize }}</h3>
                <p><strong>Date:</strong> {{ $aap_raffle->ar_date }}</p>
                <p><strong>Number of Prizes:</strong> {{ $aap_raffle->ar_noprize }}</p>
                
                <a href="{{ route('aap_raffles.index') }}" class="btn btn-primary">Back to List</a>
                <a href="{{ route('aap_raffles.edit', $aap_raffle->ar_id) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
</body>
</html>