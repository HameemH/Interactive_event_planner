document.getElementById('download-receipt').addEventListener('click', function () {
    const eventData = {
        venue, seating, stage, catering, photography, extra, total
    };

    const query = new URLSearchParams({ event_data: JSON.stringify(eventData) });

    window.location.href = `/download-receipt?${query.toString()}`;
});
