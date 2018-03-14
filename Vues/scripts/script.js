// Attendre que la page ait chargé
$(function () {
    // Rendre les lignes du tableau clickable
    $(".table-row").click(function () {
        window.location = $(this).attr("data-href");
    });

    // Date en français
    flatpickr.localize(flatpickr.l10ns.fr);

    flatpickr('.datepick', {
        dateFormat: "d/m/Y"
    });

    flatpickr('.timepick', {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
});