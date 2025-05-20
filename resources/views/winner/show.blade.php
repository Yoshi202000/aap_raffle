@if ($couponCode && $winnerName)
    <p><strong>Name:</strong> {{ $winnerName }}</p>
    <p><strong>Coupon Code:</strong> {{ $couponCode }}</p>

    <script>
        const actualCouponCode = "{{ $couponCode }}";
        const winnerFullName = "{{ $winnerName }}";

        console.log("🎉 Winner:", winnerFullName, "Coupon:", actualCouponCode);
    </script>
@else
    <p>No active coupons found.</p>
@endif
