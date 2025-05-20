@if ($winner)
    <p><strong>First Name:</strong> {{ $winner->members_firstname }}</p>
    <p><strong>Last Name:</strong> {{ $winner->members_lastname }}</p>
    <p><strong>Coupon Code:</strong> {{ $winner->ascd_couponcode }}</p>
    <script>
        const winner = @json($winner);
        console.log("🎉 Winner Info:", winner);
    </script>
@else
    <p>No active coupons found.</p>
@endif
