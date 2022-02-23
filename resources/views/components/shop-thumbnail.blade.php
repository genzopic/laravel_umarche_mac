@props(['filename'])
<div>
    @if(empty($filename))
        <img src="{{ asset('images/no_image.jpg') }}" alt="no image">
    @else
        <img src="{{ asset('storage/shops/'.$filename)}}" alt="">
    @endif
</div>