<?php
require "../../../wp-load.php";

require "lib/pelecard.php";

$pele = new pelecard();
$results = $pele->callback();

?>

<script>
    window.parent.onbeforeunload = null;
    window.parent.location.reload()
</script>

