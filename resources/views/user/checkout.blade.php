{{-- 一瞬だけ表示されるので下記の文言を入れておく --}}
<p>決済ページへリダイレクトします。</p>
{{-- stripeの読み込み --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    const publicKey = '{{ $publicKey }}'
    const stripe = Stripe(publicKey)
    
    window.onload = function() { 
        stripe.redirectToCheckout({
            sessionId: '{{ $session->id }}' 
        }).then(function (result) {
            window.location.href = '{{ route('user.cart.index') }}';
        });
    }
</script>
