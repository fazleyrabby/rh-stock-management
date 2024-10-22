@push('scripts')
<script>
    function updateData(element){
        const limit = element.value;
        const route = element.dataset.route;
        const searchInput = document.querySelector('input[name="q"]').value;
        const newUrl = `${route}?limit=${limit}&q=${encodeURIComponent(searchInput)}`;
        const limitInput = document.getElementById('limitInput');
        limitInput.value = limit;
        window.location.href = newUrl; 
    }
</script>
@endpush