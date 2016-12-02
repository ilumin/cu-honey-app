<script>
    $('.month').filter(function() {
        var current_month = <?php echo json_encode($current_month); ?>;
        return $(this).data('month') < current_month;
    }).css('background', '#EEE');
</script>